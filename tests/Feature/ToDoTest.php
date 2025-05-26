<?php

use App\Models\ToDo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user, 'sanctum');
});

it('cria uma nova tarefa', function () {
    $title = fake()->sentence;
    $description = fake()->paragraph;
    $status = fake()->randomElement(config("enums.todo.status"));

    $response = $this->postJson('/api/todo', [
        'title' => $title,
        'description' => $description,
        'status' => $status,
    ]);

    $response->assertStatus(201)
        ->assertJsonFragment(['title' => $title]);

    $this->assertDatabaseHas('to_dos', [
        'title' => $title,
    ]);
});

it('lista todas as tarefas', function () {
    ToDo::factory(3)->create([
        'user_id' => $this->user->id,
    ]);

    $response = $this->getJson('/api/todo');

    $response->assertStatus(200)
        ->assertJsonCount(3, 'data');
});

it('atualiza o status de uma tarefa', function () {
    $initial_status = fake()->randomElement(config("enums.todo.status"));
    $final_status = fake()->randomElement(config("enums.todo.status"));
    $todo = ToDo::factory()->create([
        'status' => $initial_status,
        'user_id' => $this->user->id
    ]);

    $response = $this->patchJson("/api/todo-status/{$todo->id}", [
        'status' => $final_status,
    ]);

    $response->assertStatus(200)
        ->assertJsonFragment(['status' => $final_status]);

    $this->assertDatabaseHas('to_dos', [
        'id' => $todo->id,
        'status' => $final_status,
    ]);
});

it('deleta uma tarefa', function () {
    $todo = ToDo::factory()->create(
        ['user_id' => $this->user->id]
    );

    $response = $this->deleteJson("/api/todo/{$todo->id}");

    $response->assertStatus(200)
        ->assertJsonFragment(['message' => 'Tarefa deletada com sucesso']);

    $this->assertDatabaseMissing('to_dos', [
        'id' => $todo->id,
    ]);
});

it('filtra tarefas pelo status', function () {
    $completed = config("enums.todo.status")[1];
    $in_progress = config("enums.todo.status")[2];

    ToDo::factory(3)->create(['status' => $completed, 'user_id' => $this->user->id]);
    ToDo::factory(4)->create(['status' => $in_progress, 'user_id' => $this->user->id]);

    $response = $this->getJson('/api/todo?status=' . $completed);

    $response->assertStatus(200)
        ->assertJsonFragment(['status' => $completed])
        ->assertJsonMissing(['status' => $in_progress]);
});

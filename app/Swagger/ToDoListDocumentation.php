<?php

namespace App\Swagger;

/**
 * @OA\Tag(
 *     name="2. Tarefas",
 *     description="Gerenciamento de tarefas"
 * )
 *
 * @OA\PathItem(
 *      path="/api/todo",
 * )
 *
 * @OA\Get(
 *      path="/api/todo",
 *      summary="Listar todas as tarefas",
 *      security={{"bearerAuth":{}}},
 *      tags={"Tarefas"},
 *      operationId="1_listTodos",
 *      @OA\Parameter(
 *          name="Accept",
 *          in="header",
 *          required=true,
 *          description="Tipo de retorno esperado",
 *          @OA\Schema(type="string", default="application/json")
 *      ),
 *      @OA\Parameter(
 *          name="q",
 *          in="query",
 *          description="Termo de busca",
 *          required=false,
 *          @OA\Schema(type="string", example="Teste")
 *      ),
 *      @OA\Parameter(
 *          name="due_date_start",
 *          in="query",
 *          description="Filtrar por data de vencimento",
 *          required=false,
 *          @OA\Schema(type="string", format="date", example="2025-05-27")
 *      ),
 *      @OA\Parameter(
 *          name="due_date_end",
 *          in="query",
 *          description="Filtrar por data de vencimento",
 *          required=false,
 *          @OA\Schema(type="string", format="date", example="2025-05-27")
 *      ),
 *      @OA\Parameter(
 *          name="status",
 *          in="query",
 *          description="Filtrar pelo status da tarefa",
 *          required=false,
 *          @OA\Schema(type="string", example="in_progress")
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Lista de tarefas retornada com sucesso",
 *          @OA\JsonContent(
 *              type="array",
 *              @OA\Items(ref="#/components/schemas/ToDo")
 *          )
 *      ),
 *      @OA\Response(
 *          response=401,
 *          description="Não autorizado"
 *      )
 * )
 *
 * @OA\Post(
 *     path="/api/todo",
 *     summary="Criar uma nova tarefa",
 *     security={{"bearerAuth":{}}},
 *     tags={"Tarefas"},
 *     operationId="2_createTodo",
 *     @OA\Parameter(
 *         name="Accept",
 *         in="header",
 *         required=true,
 *         description="Tipo de retorno esperado",
 *         @OA\Schema(type="string", default="application/json")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"title","description","status"},
 *             @OA\Property(property="title", type="string", example="Nova tarefa"),
 *             @OA\Property(property="description", type="string", example="Descrição da tarefa"),
 *             @OA\Property(property="status", type="string", example="pending"),
 *             @OA\Property(property="due_date", type="string", format="date-time", example="2023-10-01T12:00:00Z")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Tarefa criada com sucesso",
 *         @OA\JsonContent(ref="#/components/schemas/ToDo")
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/todo/{id}",
 *     summary="Exibir detalhes de uma tarefa",
 *     security={{"bearerAuth":{}}},
 *     tags={"Tarefas"},
 *     operationId="3_getTodo",
 *     @OA\Parameter(
 *         name="Accept",
 *         in="header",
 *         required=true,
 *         description="Tipo de retorno esperado",
 *         @OA\Schema(type="string", default="application/json")
 *     ),
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID da tarefa",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Tarefa encontrada com sucesso",
 *         @OA\JsonContent(ref="#/components/schemas/ToDo")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Tarefa não encontrada"
 *     )
 * )
 *
 * @OA\Put(
 *     path="/api/todo/{id}",
 *     summary="Atualizar uma tarefa",
 *     security={{"bearerAuth":{}}},
 *     tags={"Tarefas"},
 *     operationId="4_updateTodo",
 *     @OA\Parameter(
 *         name="Accept",
 *         in="header",
 *         required=true,
 *         description="Tipo de retorno esperado",
 *         @OA\Schema(type="string", default="application/json")
 *     ),
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID da tarefa",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"title","description","status"},
 *             @OA\Property(property="title", type="string", example="Tarefa atualizada"),
 *             @OA\Property(property="description", type="string", example="Descrição atualizada"),
 *             @OA\Property(property="status", type="string", example="completed"),
 *             @OA\Property(property="due_date", type="string", format="date-time", example="2023-10-02T12:00:00Z")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Tarefa atualizada com sucesso",
 *         @OA\JsonContent(ref="#/components/schemas/ToDo")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Tarefa não encontrada"
 *     )
 * )
 *
 * @OA\Patch(
 *     path="/api/todo-status/{id}",
 *     summary="Atualizar status de uma tarefa",
 *     security={{"bearerAuth":{}}},
 *     tags={"Tarefas"},
 *     operationId="5_updateTodoStatus",
 *     @OA\Parameter(
 *         name="Accept",
 *         in="header",
 *         required=true,
 *         description="Tipo de retorno esperado",
 *         @OA\Schema(type="string", default="application/json")
 *     ),
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID da tarefa",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"status"},
 *             @OA\Property(property="status", type="string", example="completed")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Status atualizado com sucesso",
 *         @OA\JsonContent(ref="#/components/schemas/ToDo")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Tarefa não encontrada"
 *     )
 * )
 *
 * @OA\Delete(
 *     path="/api/todo/{id}",
 *     summary="Deletar uma tarefa",
 *     security={{"bearerAuth":{}}},
 *     tags={"Tarefas"},
 *     operationId="6_deleteTodo",
 *     @OA\Parameter(
 *         name="Accept",
 *         in="header",
 *         required=true,
 *         description="Tipo de retorno esperado",
 *         @OA\Schema(type="string", default="application/json")
 *     ),
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID da tarefa",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Tarefa deletada com sucesso",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Tarefa deletada com sucesso")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Tarefa não encontrada"
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="ToDo",
 *     type="object",
 *     title="Tarefa",
 *     required={"title"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Nova tarefa"),
 *     @OA\Property(property="description", type="string", example="Descrição"),
 *     @OA\Property(property="status", type="string", example="pending"),
 *     @OA\Property(property="due_date", type="string", format="date-time"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(property="deleted_at", type="string", format="date-time")
 * )
 */
class ToDoListDocumentation
{
    // Classe usada apenas para carregar as anotações do Swagger.
}

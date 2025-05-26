<?php

namespace App\Swagger;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="API de ToDo List",
 *         description="Documentação da API para gerenciar tarefas."
 *     ),
 *     @OA\Server(
 *         url="http://localhost:8000",
 *         description="Servidor Artisan"
 *     ),
 *     @OA\Server(
 *         url="https://todolist.local",
 *         description="Servidor Local"
 *     )
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="Token"
 * )
 */
class ApiDocumentation
{
    // Classe usada apenas para carregar a documentação da API.
}

<?php

namespace App\Swagger;

/**
 * @OA\Tag(
 *      name="1. Autenticação",
 *      description="Autenticação e autorização de usuários"
 *  )
 * @OA\Post(
 *     path="/api/register",
 *     summary="Cadastrar um novo usuário",
 *     tags={"Autenticação"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dados para cadastro de usuário",
 *         @OA\JsonContent(
 *             required={"name", "email", "password", "password_confirmation"},
 *             @OA\Property(property="name", type="string", example="Eduardo Nascimento"),
 *             @OA\Property(property="email", type="string", format="email", example="email@gmail.com"),
 *             @OA\Property(property="password", type="string", format="password", example="12345678"),
 *             @OA\Property(property="password_confirmation", type="string", format="password", example="12345678")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Usuário cadastrado com sucesso",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Registro realizado com sucesso"),
 *             @OA\Property(property="user", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Eduardo Nascimento"),
 *                 @OA\Property(property="email", type="string", example="email@gmail.com")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Erro de validação",
 *         @OA\JsonContent(
 *             @OA\Property(property="errors", type="object")
 *         )
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/login",
 *     summary="Login de usuário",
 *     tags={"Autenticação"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Credenciais para login",
 *         @OA\JsonContent(
 *             required={"email", "password"},
 *             @OA\Property(property="email", type="string", format="email", example="eduardo.nascimento@gmail.com"),
 *             @OA\Property(property="password", type="string", format="password", example="12345678")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Login realizado com sucesso",
 *         @OA\JsonContent(
 *             @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."),
 *             @OA\Property(property="token_type", type="string", example="Bearer"),
 *             @OA\Property(property="expires_in", type="integer", example=3600)
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Credenciais inválidas",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Email ou senha inválidos.")
 *         )
 *     )
 * )
 *
 * @OA\Schema(
 *      schema="Usuário",
 *      type="object",
 *      title="Usuário",
 *      required={"name", "email", "password"},
 *     @OA\Property(property="name", type="string", example="Eduardo Nascimento"),
 *     @OA\Property(property="email", type="string", format="email", example="email@gmail.com"),
 *     @OA\Property(property="password", type="string", format="password", example="12345678"),
 *  )
 */
class AuthDocumentation
{
    // Classe usada apenas para agrupar anotações Swagger
}

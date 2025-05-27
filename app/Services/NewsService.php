<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NewsService
{
    /**
     * Consulta a API de notícias com os filtros fornecidos.
     *
     * @param array $filters
     * @return array
     */
    public function list(array $filters = [])
    {
        $query = [
            'q' => $filters['q'] ?? 'technology',
            'from' => $filters['from'] ?? null,
            'sortBy' => $filters['sortBy'] ?? 'publishedAt',
            'pageSize' => $filters['pageSize'] ?? 12,
            'language' => $filters['language'] ?? 'en',
        ];

        $query = array_filter($query, fn($value) => !is_null($value));

        $response = Http::timeout(5)
            ->retry(3, 100)
            ->withHeaders([
                'Accept' => 'application/json',
                'Authorization' => config('services.newsapi.token'),
            ])
            ->get(config('services.newsapi.url') . '/everything', $query);

        if ($response->failed()) {
            Log::error('NewsAPI request failed', [
                'query' => $query,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return [
                'status' => 'error',
                'message' => 'Erro ao consultar as notícias.',
                'details' => $response->json(),
            ];
        }

        return $response->json();
    }

}

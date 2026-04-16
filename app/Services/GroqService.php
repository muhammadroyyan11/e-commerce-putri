<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqService
{
    private string $apiKey;
    private string $baseUrl = 'https://api.groq.com/openai/v1';
    private string $model   = 'llama-3.3-70b-versatile';

    public function __construct()
    {
        $this->apiKey = config('services.groq.api_key', '');
    }

    /**
     * Send a chat completion request to Groq.
     *
     * @param  array  $messages  [['role' => 'system|user|assistant', 'content' => '...']]
     * @param  int    $maxTokens
     * @return string
     */
    public function chat(array $messages, int $maxTokens = 1024): string
    {
        if (empty($this->apiKey)) {
            return 'API key Groq belum dikonfigurasi. Silakan isi GROQ_API_KEY di .env';
        }

        try {
            $response = Http::withToken($this->apiKey)
                ->timeout(30)
                ->post("{$this->baseUrl}/chat/completions", [
                    'model'      => $this->model,
                    'messages'   => $messages,
                    'max_tokens' => $maxTokens,
                    'stream'     => false,
                ]);

            if ($response->failed()) {
                Log::error('Groq API error', ['status' => $response->status(), 'body' => $response->body()]);
                return 'Maaf, terjadi kesalahan saat menghubungi AI. Silakan coba lagi.';
            }

            return $response->json('choices.0.message.content', 'Tidak ada respons dari AI.');

        } catch (\Exception $e) {
            Log::error('Groq exception', ['message' => $e->getMessage()]);
            return 'Maaf, AI sedang tidak tersedia. Silakan coba lagi nanti.';
        }
    }
}

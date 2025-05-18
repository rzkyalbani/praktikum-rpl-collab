<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LlamaController extends Controller
{
    public function index()
    {
        return view('chatbot');
    }

    public function ask(Request $request)
    {
        try {
            $request->validate([
                'prompt' => 'required|string',
            ]);

            session()->flash('prompt', $request->prompt);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama3-8b-8192', // Model tersedia per Mei 2025
                'messages' => [
                    ['role' => 'user', 'content' => $request->prompt]
                ]
            ]);

            return redirect('/chatbot')->with('response', $response->json()['choices'][0]['message']['content'] ?? 'No response');
        } catch (\Exception $e) {
            return redirect('/chatbot')->with('error', $e->getMessage());
        }
    }
}

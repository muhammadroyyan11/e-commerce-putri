<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\GroqService;
use Illuminate\Http\Request;

class AiController extends Controller
{
    public function __construct(private GroqService $groq) {}

    // ── Feature 1: Plant Care Chat ────────────────────────────────────────────

    public function chat(Request $request)
    {
        $request->validate([
            'message'    => 'required|string|max:500',
            'product_id' => 'nullable|integer|exists:products,id',
        ]);

        $locale  = app()->getLocale();
        $isEn    = $locale === 'en';
        $siteName = \App\Models\Setting::get('site_name', 'GreenHaven');

        $product = $request->filled('product_id')
            ? Product::with('category')->find($request->product_id)
            : null;

        $systemPrompt = $isEn
            ? "You are a friendly plant care expert assistant for {$siteName}, an online plant shop. Answer questions about plant care, watering, lighting, and general plant advice. Keep answers concise (2-4 sentences). Be warm and helpful. Do not answer questions unrelated to plants or gardening."
            : "Kamu adalah asisten ahli perawatan tanaman yang ramah untuk {$siteName}, toko tanaman online. Jawab pertanyaan tentang perawatan tanaman, penyiraman, pencahayaan, dan saran tanaman. Jawaban singkat dan padat (2-4 kalimat). Gunakan bahasa Indonesia yang santai. Jangan jawab pertanyaan di luar topik tanaman.";

        if ($product) {
            $context = $isEn
                ? "\n\nCurrent product: {$product->name} ({$product->category?->name}). Care level: {$product->care_level}. Watering: {$product->watering}. Light: {$product->light}. Height: {$product->height}."
                : "\n\nProduk saat ini: {$product->name} ({$product->category?->name}). Perawatan: {$product->care_level}. Penyiraman: {$product->watering}. Cahaya: {$product->light}. Tinggi: {$product->height}.";
            $systemPrompt .= $context;
        }

        $reply = $this->groq->chat([
            ['role' => 'system', 'content' => $systemPrompt],
            ['role' => 'user',   'content' => $request->message],
        ], 512);

        return response()->json(['reply' => $reply]);
    }

    // ── Feature 2: Generate Product Description (Admin) ───────────────────────

    public function generateDescription(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'category'   => 'nullable|string|max:255',
            'care_level' => 'nullable|string|max:255',
            'watering'   => 'nullable|string|max:255',
            'light'      => 'nullable|string|max:255',
            'height'     => 'nullable|string|max:255',
        ]);

        $name      = $request->name;
        $category  = $request->category  ?? '';
        $careLevel = $request->care_level ?? '';
        $watering  = $request->watering   ?? '';
        $light     = $request->light      ?? '';
        $height    = $request->height     ?? '';

        $prompt = "Tulis deskripsi produk tanaman untuk toko online dalam Bahasa Indonesia yang menarik, informatif, dan persuasif.\n"
            . "Format output: HTML murni (gunakan <p>, <ul>, <li>, <strong>). Jangan tambahkan markdown atau kode blok.\n"
            . "Panjang: 3-4 paragraf.\n\n"
            . "Data produk:\n"
            . "- Nama: {$name}\n"
            . ($category  ? "- Kategori: {$category}\n"          : '')
            . ($careLevel ? "- Tingkat perawatan: {$careLevel}\n" : '')
            . ($watering  ? "- Penyiraman: {$watering}\n"         : '')
            . ($light     ? "- Kebutuhan cahaya: {$light}\n"      : '')
            . ($height    ? "- Tinggi tanaman: {$height}\n"       : '')
            . "\nTulis deskripsi yang menarik pembeli, jelaskan keunikan tanaman, manfaatnya untuk ruangan, dan tips singkat perawatan.";

        $description = $this->groq->chat([
            ['role' => 'system', 'content' => 'Kamu adalah copywriter profesional untuk toko tanaman online. Output hanya HTML (p, ul, li, strong). Jangan gunakan markdown.'],
            ['role' => 'user',   'content' => $prompt],
        ], 1024);

        return response()->json(['description' => $description]);
    }
}

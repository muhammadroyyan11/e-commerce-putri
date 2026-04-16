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

        $locale   = app()->getLocale();
        $isEn     = $locale === 'en';
        $siteName = \App\Models\Setting::get('site_name', 'LongLeaf');
        $baseUrl  = url('/');

        // ── Build product catalog for context ────────────────────────────────
        $catalog = Product::with('category')
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'slug', 'category_id', 'care_level', 'watering', 'light', 'price', 'stock']);

        $catalogLines = $catalog->map(function ($p) use ($baseUrl) {
            $url      = $baseUrl . '/shop/' . $p->slug;
            $category = $p->category?->name ?? '';
            $price    = 'Rp' . number_format($p->price, 0, ',', '.');
            $stock    = $p->stock > 0 ? 'tersedia' : 'habis';
            return "- {$p->name} | {$category} | Perawatan: {$p->care_level} | Cahaya: {$p->light} | Penyiraman: {$p->watering} | Harga: {$price} | Stok: {$stock} | URL: {$url}";
        })->implode("\n");

        // ── Current product context (if on product page) ─────────────────────
        $currentProduct = $request->filled('product_id')
            ? Product::with('category')->find($request->product_id)
            : null;

        // ── System prompt ─────────────────────────────────────────────────────
        $systemPrompt = $isEn
            ? "You are JEZY, a friendly plant care expert assistant for {$siteName}, an online plant shop. Your name is JEZY.\n"
              . "Answer questions about plant care, watering, lighting, and plant recommendations.\n"
              . "IMPORTANT: When recommending plants, ONLY recommend plants from the catalog below. Always include the product URL as a clickable markdown link like [Plant Name](URL). If a plant is out of stock, mention it.\n"
              . "Keep answers concise and warm. Do not answer questions unrelated to plants.\n\n"
              . "=== AVAILABLE PRODUCTS ===\n{$catalogLines}"
            : "Kamu adalah JEZY, asisten ahli perawatan tanaman yang ramah untuk {$siteName}, toko tanaman online. Namamu adalah JEZY.\n"
              . "Jawab pertanyaan tentang perawatan tanaman, penyiraman, pencahayaan, dan rekomendasi tanaman.\n"
              . "PENTING: Saat merekomendasikan tanaman, HANYA rekomendasikan tanaman dari katalog di bawah ini. Selalu sertakan URL produk sebagai link markdown seperti [Nama Tanaman](URL). Jika stok habis, sebutkan.\n"
              . "Jawaban singkat, padat, dan ramah. Jangan jawab pertanyaan di luar topik tanaman.\n\n"
              . "=== PRODUK TERSEDIA ===\n{$catalogLines}";

        if ($currentProduct) {
            $context = $isEn
                ? "\n\n=== CURRENT PAGE PRODUCT ===\n{$currentProduct->name} ({$currentProduct->category?->name}). Care: {$currentProduct->care_level}. Watering: {$currentProduct->watering}. Light: {$currentProduct->light}. Height: {$currentProduct->height}."
                : "\n\n=== PRODUK HALAMAN INI ===\n{$currentProduct->name} ({$currentProduct->category?->name}). Perawatan: {$currentProduct->care_level}. Penyiraman: {$currentProduct->watering}. Cahaya: {$currentProduct->light}. Tinggi: {$currentProduct->height}.";
            $systemPrompt .= $context;
        }

        $reply = $this->groq->chat([
            ['role' => 'system', 'content' => $systemPrompt],
            ['role' => 'user',   'content' => $request->message],
        ], 768);

        // Convert markdown links [text](url) → HTML <a> tags for display
        $reply = preg_replace(
            '/\[([^\]]+)\]\((https?:\/\/[^\)]+)\)/',
            '<a href="$2" style="color:#16a34a;font-weight:600;text-decoration:underline;" target="_self">$1</a>',
            $reply
        );

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

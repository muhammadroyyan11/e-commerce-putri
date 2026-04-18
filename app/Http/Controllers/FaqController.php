<?php

namespace App\Http\Controllers;

use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::where('is_active', true)
            ->orderBy('category')
            ->orderBy('sort_order')
            ->get()
            ->groupBy('category');

        return view('pages.faq', compact('faqs'));
    }
}

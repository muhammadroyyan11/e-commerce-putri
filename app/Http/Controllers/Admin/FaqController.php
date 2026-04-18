<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('category')->orderBy('sort_order')->get();
        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.faqs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question_id' => 'required|string|max:500',
            'answer_id'   => 'required|string',
            'question_en' => 'required|string|max:500',
            'answer_en'   => 'required|string',
            'category'    => 'required|in:general,shipping,payment,care',
            'sort_order'  => 'nullable|integer|min:0',
        ]);

        Faq::create([
            'question_id' => $request->question_id,
            'answer_id'   => $request->answer_id,
            'question_en' => $request->question_en,
            'answer_en'   => $request->answer_en,
            'category'    => $request->category,
            'sort_order'  => $request->sort_order ?? 0,
            'is_active'   => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ berhasil ditambahkan.');
    }

    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question_id' => 'required|string|max:500',
            'answer_id'   => 'required|string',
            'question_en' => 'required|string|max:500',
            'answer_en'   => 'required|string',
            'category'    => 'required|in:general,shipping,payment,care',
            'sort_order'  => 'nullable|integer|min:0',
        ]);

        $faq->update([
            'question_id' => $request->question_id,
            'answer_id'   => $request->answer_id,
            'question_en' => $request->question_en,
            'answer_en'   => $request->answer_en,
            'category'    => $request->category,
            'sort_order'  => $request->sort_order ?? 0,
            'is_active'   => $request->boolean('is_active', false),
        ]);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ berhasil diperbarui.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ berhasil dihapus.');
    }
}

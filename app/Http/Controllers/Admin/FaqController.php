<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::ordered()->get()->groupBy('category');
        return view('admin.faqs.index', compact('faqs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:100',
            'question' => 'required|string|max:500',
            'answer'   => 'required|string',
            'sort_order' => 'nullable|integer',
        ]);

        Faq::create([
            'category'   => $request->category,
            'question'   => $request->question,
            'answer'     => $request->answer,
            'sort_order' => $request->sort_order ?? 0,
            'is_active'  => true,
        ]);

        return back()->with('success', 'FAQ added successfully.');
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'category' => 'required|string|max:100',
            'question' => 'required|string|max:500',
            'answer'   => 'required|string',
            'sort_order' => 'nullable|integer',
        ]);

        $faq->update([
            'category'   => $request->category,
            'question'   => $request->question,
            'answer'     => $request->answer,
            'sort_order' => $request->sort_order ?? $faq->sort_order,
        ]);

        return back()->with('success', 'FAQ updated successfully.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return back()->with('success', 'FAQ deleted.');
    }

    public function toggle(Faq $faq)
    {
        $faq->update(['is_active' => !$faq->is_active]);
        return back()->with('success', 'FAQ status updated.');
    }
}
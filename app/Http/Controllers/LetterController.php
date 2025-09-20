<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LetterController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $letters = Letter::with('category')
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "%$search%");
            })
            ->orderByDesc('archived_at')
            ->paginate(10);
        $categories = Category::all();
        return view('letters.index', compact('letters', 'categories', 'search'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('letters.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'number' => 'required|unique:letters,number',
            'category_id' => 'required|exists:categories,id',
            'title' => 'required',
            'file' => 'required|mimes:pdf',
        ]);
        $filePath = $request->file('file')->store('letters', 'public');
        Letter::create([
            'number' => $request->number,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'file_path' => $filePath,
            'archived_at' => now(),
        ]);
        return redirect()->route('letters.index')->with('success', 'Data berhasil disimpan');
    }

    public function show(Letter $letter)
    {
        return view('letters.show', compact('letter'));
    }

    public function edit(Letter $letter)
    {
        $categories = Category::all();
        return view('letters.edit', compact('letter', 'categories'));
    }

    public function update(Request $request, Letter $letter)
    {
        $request->validate([
            'number' => 'required|unique:letters,number,' . $letter->id,
            'category_id' => 'required|exists:categories,id',
            'title' => 'required',
            'file' => 'nullable|mimes:pdf',
        ]);
        $data = $request->only(['number', 'category_id', 'title']);
        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($letter->file_path);
            $data['file_path'] = $request->file('file')->store('letters', 'public');
        }
        $letter->update($data);
        return redirect()->route('letters.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy(Letter $letter)
    {
        Storage::disk('public')->delete($letter->file_path);
        $letter->delete();
        return response()->json(['success' => true]);
    }

    public function download(Letter $letter)
    {
        return Storage::disk('public')->download($letter->file_path, $letter->title . '.pdf');
    }
}

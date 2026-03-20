<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use Illuminate\Http\Request;

class MangaController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $query = Manga::query();
        
        if ($status) {
            $query->where('status', $status);
        }
        
        // Group by status for a structured view
        $mangas = $query->latest()->get()->groupBy('status');
        $allMangasCount = Manga::count();
        
        return view('mangas.index', compact('mangas', 'allMangasCount', 'status'));
    }

    public function create()
    {
        return view('mangas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mal_id' => 'nullable|integer',
            'title' => 'required|string|max:255',
            'type' => 'nullable|string|max:50',
            'status' => 'required|in:Plan to read,Reading,On-hold,Completed,Dropped',
            'image_url' => 'nullable|string',
            'url' => 'nullable|string',
        ]);

        // Check if manga already exists in tracker based on mal_id
        if ($validated['mal_id'] && Manga::where('mal_id', $validated['mal_id'])->exists()) {
            return redirect()->back()->with('error', 'This manga is already in your tracker!');
        }

        Manga::create($validated);

        return redirect()->route('mangas.index')->with('success', 'Manga added successfully!');
    }

    public function show(Manga $manga)
    {
        return view('mangas.show', compact('manga'));
    }

    public function edit(Manga $manga)
    {
        return view('mangas.edit', compact('manga'));
    }

    public function update(Request $request, Manga $manga)
    {
        $validated = $request->validate([
            'status' => 'required|in:Plan to read,Reading,On-hold,Completed,Dropped',
            // optionally allow changing other things, but usually just status is changed in a tracker
        ]);

        $manga->update($validated);

        return redirect()->route('mangas.index')->with('success', 'Tracker status updated successfully.');
    }

    public function destroy(Manga $manga)
    {
        $manga->delete();

        return redirect()->route('mangas.index')->with('success', 'Manga removed from tracker.');
    }
}

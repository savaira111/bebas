<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ebook;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EbookController extends Controller
{
    public function index()
    {
        $ebooks = Ebook::latest()->paginate(10);
        return view('ebooks.index', compact('ebooks'));
    }

    public function create()
    {
        return view('ebooks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'nullable|string',
            'pdf' => 'required|mimes:pdf|max:10240',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'is_auth_required' => 'nullable|boolean',
        ]);

        // Generate slug unik
        $slug = Str::slug($request->title);
        $count = Ebook::where('slug', 'like', "$slug%")->count();
        $finalSlug = $count ? "{$slug}-{$count}" : $slug;

        // Upload PDF
        $pdfPath = $request->file('pdf')->store('ebooks/files', 'public');

        // Upload Cover (optional)
        $coverPath = null;
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('ebooks/covers', 'public');
        }

        Ebook::create([
            'title' => $request->title,
            'author' => $request->author,
            'description' => $request->description,
            'slug' => $finalSlug,
            'pdf' => $pdfPath,
            'cover' => $coverPath,
            'is_auth_required' => $request->has('is_auth_required'),
        ]);

        return redirect()->route('ebooks.index')
            ->with('success', 'E-Book berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $ebook = Ebook::findOrFail($id);
        return view('ebooks.edit', compact('ebook'));
    }

    public function update(Request $request, $id)
    {
        $ebook = Ebook::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'nullable|string',
            'pdf' => 'nullable|mimes:pdf|max:10240',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'is_auth_required' => 'nullable|boolean',
        ]);

        $slug = Str::slug($request->title);
        $count = Ebook::where('slug', 'like', "$slug%")
            ->where('id', '!=', $ebook->id)
            ->count();

        $data = [
            'title' => $request->title,
            'author' => $request->author,
            'description' => $request->description,
            'slug' => $count ? "{$slug}-{$count}" : $slug,
            'is_auth_required' => $request->has('is_auth_required'),
        ];

        if ($request->hasFile('pdf')) {
            if ($ebook->pdf) {
                Storage::disk('public')->delete($ebook->pdf);
            }

            $data['pdf'] = $request->file('pdf')->store('ebooks/files', 'public');
        }

        if ($request->hasFile('cover')) {
            if ($ebook->cover) {
                Storage::disk('public')->delete($ebook->cover);
            }

            $data['cover'] = $request->file('cover')->store('ebooks/covers', 'public');
        }

        $ebook->update($data);

        return redirect()->route('ebooks.index')
            ->with('success', 'E-Book berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $ebook = Ebook::findOrFail($id);

        if ($ebook->pdf) {
            Storage::disk('public')->delete($ebook->pdf);
        }

        if ($ebook->cover) {
            Storage::disk('public')->delete($ebook->cover);
        }

        $ebook->delete();

        return redirect()->route('ebooks.index')
            ->with('success', 'E-Book berhasil dihapus.');
    }

    public function trashed()
    {
        $ebooks = Ebook::onlyTrashed()->latest()->paginate(10);
        return view('ebooks.trashed', compact('ebooks'));
    }

    public function restore($id)
    {
        $ebook = Ebook::onlyTrashed()->findOrFail($id);
        $ebook->restore();

        return back()->with('success', 'E-book berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        $ebook = Ebook::onlyTrashed()->findOrFail($id);

        if ($ebook->pdf) {
            Storage::disk('public')->delete($ebook->pdf);
        }

        if ($ebook->cover) {
            Storage::disk('public')->delete($ebook->cover);
        }

        $ebook->forceDelete();

        return back()->with('success', 'E-book berhasil dihapus permanen.');
    }
}

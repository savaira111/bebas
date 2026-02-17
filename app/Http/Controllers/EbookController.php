<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ebook;

class EbookController extends Controller
{
    // Tampilkan daftar e-book
    public function index()
    {
        $ebooks = Ebook::latest()->paginate(10);
        return view('ebooks.index', compact('ebooks'));
    }

    // Halaman create
    public function create()
    {
        return view('ebooks.create');
    }

    // Simpan e-book baru
    public function store(Request $request)
    {
        dd($request);
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:ebooks,slug',
            'category' => 'required|string|max:255',
            'pdf' => 'required|mimes:pdf|max:10240',
            'cover' => 'nullable|image|max:5120',
        ]);

        $ebook = new Ebook();
        $ebook->title = $request->title;
        $ebook->slug = $request->slug;
        $ebook->category = $request->category;

        if ($request->hasFile('pdf')) {
            $ebook->pdf = $request->file('pdf')->store('ebooks/files', 'public');
        }

        if ($request->hasFile('cover')) {
            $ebook->cover = $request->file('cover')->store('ebooks/covers', 'public');
        }

        $ebook->save();

        return redirect()->route('ebooks.index')
            ->with('success', 'E-Book berhasil ditambahkan.');
    }

    // Halaman edit
    public function edit($id)
    {
        $ebook = Ebook::findOrFail($id);
        return view('ebooks.edit', compact('ebook'));
    }

    // Update e-book
    public function update(Request $request, $id)
    {
        $ebook = Ebook::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:ebooks,slug,' . $ebook->id,
            'category' => 'required|string|max:255',
            'pdf' => 'nullable|mimes:pdf|max:10240',
            'cover' => 'nullable|image|max:5120',
        ]);

        $data = [
            'title' => $request->title,
            'slug' => $request->slug,
            'category' => $request->category,
        ];

        if ($request->hasFile('pdf')) {
            if ($ebook->pdf) {
                \Storage::disk('public')->delete($ebook->pdf);
            }
            $data['pdf'] = $request->file('pdf')->store('ebooks/files', 'public');
        }

        if ($request->hasFile('cover')) {
            if ($ebook->cover) {
                \Storage::disk('public')->delete($ebook->cover);
            }
            $data['cover'] = $request->file('cover')->store('ebooks/covers', 'public');
        }

        $ebook->update($data);

        return redirect()->route('ebooks.index')
            ->with('success', 'E-Book berhasil diperbarui.');
    }

    // Hapus e-book (Soft Delete)
    public function destroy($id)
    {
        $ebook = Ebook::findOrFail($id);
        $ebook->delete();

        return redirect()->route('ebooks.index')
            ->with('success', 'E-Book berhasil dihapus (Moved to Trash).');
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

        return back()->with('success', 'Ebook restored successfully.');
    }

    public function forceDelete($id)
    {
        $ebook = Ebook::onlyTrashed()->findOrFail($id);
        
        if ($ebook->pdf) {
            \Storage::disk('public')->delete($ebook->pdf);
        }
        if ($ebook->cover) {
            \Storage::disk('public')->delete($ebook->cover);
        }

        $ebook->forceDelete();

        return back()->with('success', 'Ebook permanently deleted.');
    }
}

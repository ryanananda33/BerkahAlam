<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminHeroController extends Controller
{
    public function index()
    {
        $heroes = Hero::all();
        return view('admin.hero.index', compact('heroes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'subjudul' => ['required', 'string', 'max:255'],
            'gambar' => ['required', 'image', 'max:10240'], // Max 10MB
            'tentang_gambar' => ['nullable', 'image', 'max:10240'],
        ]);

        $imagePath = null;
        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $imageName = 'hero_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/hero'), $imageName);
            $imagePath = 'uploads/hero/' . $imageName;
        }

        $tentangImagePath = null;
        if ($request->hasFile('tentang_gambar')) {
            $image = $request->file('tentang_gambar');
            $imageName = 'about_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/hero'), $imageName);
            $tentangImagePath = 'uploads/hero/' . $imageName;
        }

        Hero::create([
            'judul' => $request->judul,
            'subjudul' => $request->subjudul,
            'gambar' => $imagePath,
            'tentang_gambar' => $tentangImagePath,
        ]);

        return redirect()->route('admin.hero.index')->with('success', 'Hero Banner berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $hero = Hero::findOrFail($id);

        $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'subjudul' => ['required', 'string', 'max:255'],
            'gambar' => ['nullable', 'image', 'max:10240'],
            'tentang_gambar' => ['nullable', 'image', 'max:10240'],
        ]);

        $imagePath = $hero->gambar;
        if ($request->hasFile('gambar')) {
            if ($hero->gambar && File::exists(public_path($hero->gambar))) {
                File::delete(public_path($hero->gambar));
            }

            $image = $request->file('gambar');
            $imageName = 'hero_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/hero'), $imageName);
            $imagePath = 'uploads/hero/' . $imageName;
        }

        $tentangImagePath = $hero->tentang_gambar;
        if ($request->hasFile('tentang_gambar')) {
            if ($hero->tentang_gambar && File::exists(public_path($hero->tentang_gambar))) {
                File::delete(public_path($hero->tentang_gambar));
            }

            $image = $request->file('tentang_gambar');
            $imageName = 'about_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/hero'), $imageName);
            $tentangImagePath = 'uploads/hero/' . $imageName;
        }

        $hero->update([
            'judul' => $request->judul,
            'subjudul' => $request->subjudul,
            'gambar' => $imagePath,
            'tentang_gambar' => $tentangImagePath,
        ]);

        return redirect()->route('admin.hero.index')->with('success', 'Hero Banner & Tentang Kami berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $hero = Hero::findOrFail($id);

        if ($hero->gambar && File::exists(public_path($hero->gambar))) {
            File::delete(public_path($hero->gambar));
        }

        if ($hero->tentang_gambar && File::exists(public_path($hero->tentang_gambar))) {
            File::delete(public_path($hero->tentang_gambar));
        }

        $hero->delete();

        return redirect()->route('admin.hero.index')->with('success', 'Hero Banner berhasil dihapus!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::latest()->paginate(3);
        return view('posts.index', compact('posts'));
    }

    //Membuat function create untuk menampilkan form tambah data
    public function create(): View
    {
        return view('posts.create');
    }

    //Membuat function store untuk memproses data ke database dan upload gambar
    public function store(Request $request): RedirectResponse
    {
        //Membuat validasi form
        $messages = [
            'image.required' => 'Gambar wajib diunggah.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Gambar harus berformat png, jpg, atau jpeg.',
            'image.max' => 'Ukuran gambar maksimal adalah 2MB.',
            'title.required' => 'Judul wajib diisi.',
            'title.min' => 'Judul harus terdiri dari minimal 5 karakter.',
            'content.required' => 'Konten wajib diisi.',
            'content.min' => 'Konten harus terdiri dari minimal 10 karakter.',
        ];
        $this->validate($request, [
            'image'     => 'required|image|mimes:png,jpg,jpeg|max:2040',
            'title'     => 'required|min:5',
            'content'   => 'required|min:10'
        ], $messages);

        //Upload gambar
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        //Simpan ke database
        Post::create([
            'image'     => $image->hashName(),
            'title'     => $request->title,
            'content'   => $request->content
        ]);

        //redirect ke halaman index
        return redirect()->route('posts.index')->with([
            'success' => 'Data berhasil disimpan'
        ]);
    }

    //Membuat show data berdasarkan id
    public function show(string $id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show', compact('post'));
    }

    //Membuat method edit
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    //Membuat method update
    public function update(Request $request, $id)
    {
        //Membuat validasi form
        $messages = [
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Gambar harus berformat png, jpg, atau jpeg.',
            'image.max' => 'Ukuran gambar maksimal adalah 2MB.',
            'title.required' => 'Judul wajib diisi.',
            'title.min' => 'Judul harus terdiri dari minimal 5 karakter.',
            'content.required' => 'Konten wajib diisi.',
            'content.min' => 'Konten harus terdiri dari minimal 10 karakter.',
        ];
        $this->validate($request, [
            'image'     => 'image|mimes:png,jpg,jpeg|max:2040',
            'title'     => 'required|min:5',
            'content'   => 'required|min:10'
        ], $messages);

        $post = Post::findOrFail($id);

        //upload gambar
        if ($request->hasFile('image')) {
            //upload gambar baru
            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());

            //hapus gambar jika gambarnya berbeda
            Storage::delete('public/posts' . $post->image);

            //update data
            $post->update([
                'image'     => $image->hashName(),
                'title'     => $request->title,
                'content'   => $request->content
            ]);
        } else {
            $post->update([
                'title'     => $request->title,
                'content'   => $request->content
            ]);
        }
        return redirect()->route('posts.index')->with(
            [
                'success' => 'Data berhasil diubah'
            ]
        );
    }
}
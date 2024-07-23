<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() : View
    {
        $posts = Post::latest()->paginate(3);
        return view('posts.index', compact('posts'));
    }

    //Membuat function create untuk menampilkan form tambah data
    public function create() : View
    {
        return view('posts.create');
    }

    //Membuat function store untuk memproses data ke database dan upload gambar
    public function store(Request $request) : RedirectResponse
    {
        //Membuat validasi form
        $this->validate($request, [
            'image'     => 'required|image|mimes:png,jpg,jpeg|max:2040',
            'title'     => 'required|min:5',
            'content'   => 'required|min:10'
        ]);

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
}

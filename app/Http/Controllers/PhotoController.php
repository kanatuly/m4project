<?php

namespace App\Http\Controllers;

use App\Jobs\ResizePhoto;
use App\Models\Book;
use App\Models\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function thumbnail($id)
    {
        $book = Book::find($id);
        $thumbnails = [];
        foreach ($book->photos as $photo){
            array_push($thumbnails, $photo->thumbnail);
        }
        return view('photos.thumbnail', ['thumbnails' => $thumbnails,'id' => $book->id]);
    }
    public function create($id)
    {
        return view('photos.create', ['id' => $id]);
    }
    public function store($id, Request $request)
    {
        $request->validate([
            'text' => 'required',
            'photo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:5242880',
        ]);
        $photo = new Photo;
        $photo->name = time().'_'.$request->file('photo')->getClientOriginalName();
        $request->file('photo')->storeAs('photos', $photo->name, 'public');
        $photo->book_id = $id;
        $photo->description = $request->text;
        $photo ->save();
        ResizePhoto::dispatch($photo);
        return redirect("books\show\\".$id);
    }
}


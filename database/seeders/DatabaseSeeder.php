<?php

namespace Database\Seeders;

use App\Models\User;
use \App\Models\Book;
use App\Models\Photo;
use \App\Models\Author;
use App\Jobs\ResizePhoto;
use App\Models\Thumbnail;
use Illuminate\Database\Seeder;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    public function run()
    {   
        $users = User::factory(5)->create();
        foreach($users as $user){
            Author::factory(rand(1, 3))->create(['user_id' => $user->id]);
        }
        $authors = Author::all();
        foreach($authors as $author){
            Book::factory(rand(2, 4))->create(['user_id' => $author->user_id, 'author_id' => $author->id]);
        }
        $books = Book::all();
        foreach($books as $book){
            Photo::factory(rand(2, 4))->create(['book_id' => $book->id]);
        }
        $photos = Photo::all();
        foreach($photos as $photo){
            ResizePhoto::dispatch($photo);
        }
    }
}

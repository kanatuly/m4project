<?php

namespace App\Jobs;

use App\Models\Thumbnail;
use Intervention\Image\Facades\Image;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ResizePhoto implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $photo;

    public function __construct($photo)
    {   
        $this->photo = $photo;
    }

    public function handle()
    {
        //ddd(0);
        $photo = Storage::get('photos/'.$this->photo->name);
        $photo = Image::make($photo);
        $photo->resize(150, 150);
        $photo->save('public/storage/thumbs/'.$this->photo->name);
        $thumbnail = new Thumbnail;
        $thumbnail->name = $this->photo->name;
        $thumbnail->description = $this->photo->description;
        $thumbnail->photo_id = $this->photo->id;
        $thumbnail->save();
    }
}

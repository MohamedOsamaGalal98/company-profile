<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Team extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'team';

    protected $fillable = [
        'firstname',
        'lastname',
        'position',
    ];

    public function getImages()
    {
        return $this->getMedia('images');
    }


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->useDisk('public')
            ->acceptsFile(function ($file) {
                return in_array($file->mimeType, ['image/jpeg', 'image/png', 'image/gif']); // Accept only image files
            })
            ->withResponsiveImages(); // Enable responsive images for better performance
    }
}

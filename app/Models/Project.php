<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Project extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'category',
        'client_name',
        'demo_email',
        'demo_password',
        'demo_link',
        'dashboard_email',
        'dashboard_password',
        'dashboard_link',
    ];

    public function getImages()
    {
        return $this->getMedia('images');
    }

    // public function registerMediaCollections(): void
    // {
    //     $this->addMediaCollection('image')
    //         ->useDisk('public');
    // }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images') // Ensure this matches the collection name in your Filament resource
            ->useDisk('public') // Ensure you're using the correct disk
            ->acceptsFile(function ($file) {
                return in_array($file->mimeType, ['image/jpeg', 'image/png', 'image/gif']); // Accept only image files
            })
            ->withResponsiveImages(); // Enable responsive images for better performance
    }

    public function clientOpinions()
    {
        return $this->hasMany(ClientOpinion::class);
    }
}

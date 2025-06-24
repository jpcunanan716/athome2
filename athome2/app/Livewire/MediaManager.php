<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Media;
use App\Models\House;
use Illuminate\Support\Facades\Session;

class MediaManager extends Component
{
    use WithFileUploads;

    public $mediaList; 
    public $images = [];
    public $imagesPreview = [];
    public $house_id; 

    public function mount()
    {
        // Get the house ID from the session
        $this->house_id = Session::get('last_created_house_id');
        // Load the media list
        $this->mediaList = Media::where('house_id', $this->house_id)->get();
    }

    public function updatedImages()
    {
        $this->validate([
            'images.*' => 'image', // Validate each image
        ]);

        $this->imagesPreview = [];

        foreach ($this->images as $image) {
            $this->imagesPreview[] = $image->temporaryUrl(); // Generate preview URLs
        }
    }

    public function removeImage($index)
    {
        // Remove the image from both arrays
        if (isset($this->images[$index])) {
            unset($this->images[$index]);
            $this->images = array_values($this->images); // Reindex array
        }
        
        if (isset($this->imagesPreview[$index])) {
            unset($this->imagesPreview[$index]);
            $this->imagesPreview = array_values($this->imagesPreview); // Reindex array
        }
    }

    public function save()
    {
        $this->validate([
            'images' => 'required|array|min:1', // Ensure at least one image is uploaded
            'images.*' => 'required|image', // Validate each image (max 2MB)
        ]);

        foreach ($this->images as $image) {
            $imagePath = $image->store('media', 'public'); // Store each image

            Media::create([
                'image_path' => $imagePath,
                'house_id' => $this->house_id,
            ]);
        }

        // Refresh the media list
        $this->mediaList = Media::where('house_id', $this->house_id)->get();
        $this->reset(['images', 'imagesPreview']); // Clear the input and previews

        // Redirect to /home after successful upload
        session()->flash('message', 'Images uploaded successfully!');
        return $this->redirect('/');
    }

    public function delete($id)
    {
        $media = Media::findOrFail($id);
        $media->delete();
        $this->mediaList = Media::where('house_id', $this->house_id)->get(); // Refresh the media list
    }

    public function render()
    {
        return view('livewire.media-manager')->layout('layouts.app');
    }
}
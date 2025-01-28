<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VinylMaster;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class VinylImageController extends Controller
{
    public function index($id)
    {
        $vinylMaster = VinylMaster::findOrFail($id);
        $images = $vinylMaster->media;

        return view('admin.vinyls.images', compact('vinylMaster', 'images'));
    }

    public function store(Request $request, $id)
{
    $request->validate([
        'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $vinylMaster = VinylMaster::findOrFail($id);

    if ($request->hasFile('images')) {
        $manager = new ImageManager(new Driver());

        foreach ($request->file('images') as $image) {
            $img = $manager->read($image);

            // Get the current dimensions
            $width = $img->width();
            $height = $img->height();

            // Determine the size to crop (smallest dimension)
            $size = min($width, $height);

            // Calculate crop position (center)
            $x = ($width - $size) / 2;
            $y = ($height - $size) / 2;

            // Crop the image
            $img->crop($size, $size, $x, $y);

            // Resize to 400x400
            $img->resize(400, 400);

            // Generate a unique filename
            $filename = uniqid('vinyl_') . '.jpg';
            $path = 'vinyl_images/' . $filename;

            // Save the image
            Storage::disk('public')->put($path, $img->toJpeg(80));

            $media = new Media([
                'file_path' => $path,
                'file_name' => $filename,
                'file_size' => Storage::disk('public')->size($path),
                'file_type' => 'image/jpeg',
            ]);
            $vinylMaster->media()->save($media);
        }
    }

    return redirect()->route('admin.vinyl.images', $id)->with('success', 'Images uploaded and cropped successfully.');
}

    public function destroy($id, $imageId)
    {
        $media = Media::findOrFail($imageId);

        if ($media->mediable_id == $id && $media->mediable_type == VinylMaster::class) {
            Storage::disk('public')->delete($media->file_path);
            $media->delete();
            return redirect()->route('admin.vinyl.images', $id)->with('success', 'Image deleted successfully.');
        }

        return redirect()->route('admin.vinyl.images', $id)->with('error', 'Unable to delete the image.');
    }
}

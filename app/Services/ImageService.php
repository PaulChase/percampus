<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as ImageOptimizer;

class ImageService
{



  public function save($image, $postId)
  {

    $fileNameWithExt = $image->getClientOriginalName();

    // get only the file name
    $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

    // get the extension e.g .png, .jpg etc
    $extension = $image->getClientOriginalExtension();

    /*
				the filename to store is a combination of the the main file name with a timestamp, then the file extension. The reason is to have a unique filename for every image uplaoded.
				*/
    $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

    // the path to store
    $path = $image->getRealPath() . '.jpg';

    // reducing the file size of the image and also optimizing it for fast loading
    $imageResize = ImageOptimizer::make($image->temporaryUrl());
    $imageResize->resize(1000, 1000, function ($const) {
      $const->aspectRatio();
    })->encode('jpg', 60);
    // $home = $imageResize->save('/test/testing.jpg');




    // saving it to the s3 bucket and also making it public so my website can access it
    Storage::put('public/images/' . $fileNameToStore, $imageResize->__toString(), 'public');

    // get the public url from s3
    $url  = Storage::url('public/images/' . $fileNameToStore);

    Image::create([
      'post_id' => $postId,
      'Image_name' => $fileNameToStore,
      'Image_path' => $url
    ]);
  }
}

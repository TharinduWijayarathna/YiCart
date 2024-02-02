<?php

namespace domain\Services\ImageService;
use Illuminate\Support\Facades\File;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;

/**
 * ImageService
 * php version 8
 *
 * @category Service

 * */

class ImageService
{
    protected $image;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->image = new Image();
    }

    /**
     * Store
     * stor image data
     *
     * @param  mixed $image
     * @return Image
     */
    public function store($image): Image
    {
        if (isset($image)) {
            $originalName = $image->getClientOriginalName();
        $fileName = pathinfo($originalName, PATHINFO_FILENAME) . '_' . time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads'), $fileName);
        $filePath = 'uploads/' . $fileName;
        $data['name'] = asset($filePath);
        return $this->image->create($data);
        }
    }

    /**
     * Delete
     * delete image data
     *
     * @param  mixed $image
     * @return void
     */
    public function delete($image)
    {
        if (isset($image)) {
            $filePath = public_path(str_replace(asset('/'), '', $image->name));

            if (File::exists($filePath)) {
                File::delete($filePath);
            }

            $image->delete();
        }
    }

}

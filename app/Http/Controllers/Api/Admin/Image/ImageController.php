<?php

namespace App\Http\Controllers\Api\Admin\Image;

use App\Http\Controllers\Controller;
use App\Services\ImageHandleService;
use App\Http\Requests\Admin\Image\ImageRequest;
class ImageController extends Controller
{
    public function store(ImageRequest $request, ImageHandleService $uploadImageService){
        $result = $uploadImageService->save($request->image,$request->folder,$request->id);
        return response($result);
    }

}

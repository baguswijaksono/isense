<?php

namespace App\Http\Controllers;


class FileController extends Controller
{
    public function showimage($imageName)
    {
        $file = storage_path('app/private/image/' . $imageName);
        return response()->file($file);
    }
}

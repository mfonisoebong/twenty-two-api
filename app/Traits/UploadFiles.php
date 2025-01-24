<?php

namespace App\Traits;

use Error;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

trait UploadFiles
{

    public function uploadFiles($documentFiles, $folder, $max = 4)
    {
        $documents = [];

        if (count($documentFiles) > $max) {
            throw new Error("Maximum of $max documents are allowed for upload");
        }

        foreach ($documentFiles as $file) {
            $uuid = Str::uuid();

            $fileName = time() . '_'  . $uuid . '_' . $file->getClientOriginalName();
            $file->storeAs('public/' . $folder, $fileName);
            array_push($documents, "{$folder}/{$fileName}");
        }

        return $documents;
    }

    public function uploadFile($file, $folder)
    {
        $uuid = Str::uuid();
        $fileName = time() . '_' . $uuid . '_' . $file->getClientOriginalName();

        $file->storeAs('public/' . $folder, $fileName);
        return "{$folder}/{$fileName}";
    }

    public function getFilePath(?string $path)
    {

        if (!$path) {
            return null;
        }

        $filePath = asset('storage/' . $path);

        return $filePath;
    }
}

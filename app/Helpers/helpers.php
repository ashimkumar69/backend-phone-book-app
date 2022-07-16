<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

if (!function_exists('storeFile')) {
    /**
     * SEO Friendly File Storing.
     *
     * @param UploadedFile $file
     * @param string $path
     * @param string|null $contentName // Required to be SEO Friendly, pass null if you're ignoring SEO.
     * @param string|null $disk
     *
     * @return string
     */
    function storeFile(UploadedFile $file, string $path, ?string $contentName, ?string $disk = 'public'): string
    {
        if ($contentName === null) {
            return $file->store("${path}", $disk);
        }

        $extension = $file->guessExtension();
        $hash = Str::random(5);
        $slug = Str::slug($contentName);
        return $file->storeAs("${path}", "${slug}-${hash}.${extension}", $disk);
    }
}

if (!function_exists('deleteFile')) {
    /**
     * @param string $path
     * @param string|null $disk
     *
     * @return bool
     */
    function deleteFile(string $path, ?string $disk = 'public'): bool
    {
        if (Storage::disk($disk)->exists($path)) {
            Storage::disk($disk)->delete($path);
            return true;
        }
        return false;
    }
}


if (!function_exists('getPathInfoBaseName')) {
    /**
     * @param string $path
     *
     * @return string
     */
    function getPathInfoBaseName(string $path): string
    {
        return pathinfo($path,PATHINFO_BASENAME);
    }
}


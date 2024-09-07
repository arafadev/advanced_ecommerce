<?php
namespace App\Traits;

use Illuminate\Support\Str;

trait UploadImgTrait
{
    public function uploadImg($name, $file, $directory)
    {
        $file_name = Str::slug($name) . "." . $file->getClientOriginalExtension();
        $file->move(public_path($directory), $file_name);
        return $file_name;
    }


}
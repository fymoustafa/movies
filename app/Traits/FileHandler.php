<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;

trait FileHandler{
    
    public static function save_img($image, $path){
         
        $imageExtension = $image->getClientOriginalExtension();

        $imageName = uniqid();
        $dist = storage_path('app/public/');
        $full_path = $dist . $path . '/';

        if(!file_exists($dist)){
            mkdir($dist, 0777, true);
        }
        if(!file_exists($dist . $path)){
            mkdir($dist . $path, 0777, true);
        }

        $image->move($full_path, $imageName . '.' . $imageExtension);

        return $path.'/'.$imageName.'.'.$imageExtension;
    }

    public static function remove($full_path){
        if(File::exists($full_path)) {
            File::delete($full_path);
          }
    }
}
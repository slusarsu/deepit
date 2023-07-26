<?php

namespace App\Adm\Services;

use Illuminate\Support\Facades\Storage;

class AdmService
{
    public static function getViewBladeFileNames(string $paths): array
    {
        $files = Storage::disk('views')->files($paths);
        $templates = [];
        foreach ($files as $item) {
            $itemArr = explode('/', $item);
            $last = end($itemArr);
            $result = str_replace('.blade.php','',$last);
            $templates[$result] = $result;
        }

        return $templates;
    }
}

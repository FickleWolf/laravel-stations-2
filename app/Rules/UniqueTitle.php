<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Movie;

class UniqueTitle implements Rule
{
    public function __construct()
    {
        //
    }

    public function passes($attribute, $value)
    {
        // 重複するタイトルがあるかどうかを確認する
        return !Movie::where('title', $value)->exists();
    }

    public function message()
    {
        return 'このタイトルは既に存在します。';
    }
}

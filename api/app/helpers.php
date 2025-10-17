<?php

use App\Models\User;
use Illuminate\Support\Str;

if (! function_exists('generate_unique_slug')) {
    function generate_unique_slug(string $name, ?int $excludeUserId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        $query = User::where('slug', $slug);

        if ($excludeUserId) {
            $query->where('id', '!=', $excludeUserId);
        }

        while ($query->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;

            $query = User::where('slug', $slug);
            if ($excludeUserId) {
                $query->where('id', '!=', $excludeUserId);
            }
        }

        return $slug;
    }
}

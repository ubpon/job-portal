<?php

namespace App\Services;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagService
{
    public function listing(Request $request)
    {
        return Tag::query()
            ->filterTags($request->input('tag'))
            ->orderBy('name')
            ->latest();
    }
}

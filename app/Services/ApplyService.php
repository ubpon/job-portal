<?php

namespace App\Services;

use App\Models\Listing;
use Illuminate\Http\Request;

class ApplyService
{
    public function apply(Request $request, Listing $listing)
    {
        $listing->clicks()
            ->create([
                'user_agent' => $request->userAgent(),
                'ip' => $request->ip()
            ]);

        return $listing;
    }
}

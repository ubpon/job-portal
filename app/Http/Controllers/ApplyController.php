<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Services\ApplyService;
use Illuminate\Http\Request;

class ApplyController extends Controller
{
    private ApplyService $applyService;

    public function __construct(ApplyService $applyService)
    {
        $this->applyService = $applyService;
    }

    public function apply(Listing $listing, Request $request)
    {
        $result = $this->applyService->apply($request, $listing);

        return redirect()->to($result->apply_link);
    }
}

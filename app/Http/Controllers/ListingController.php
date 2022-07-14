<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
use App\Models\Listing;
use App\Services\ListingService;
use App\Services\TagService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
    private ListingService $listingService;
    private TagService $tagService;
    private UserService $userService;

    public function __construct(
        ListingService $listingService,
        TagService $tagService,
        UserService $userService
    ) {
        $this->listingService = $listingService;
        $this->tagService = $tagService;
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $listingQuery = $this->listingService->listing($request);

        $listings = $listingQuery->get();

        $tagQuery = $this->tagService->listing($request);

        $tags = $tagQuery->get();

        return view('listings.index', compact('listings', 'tags'));
    }

    public function show(Listing $listing, Request $request)
    {
        return view('listings.show', compact('listing'));
    }

    public function create()
    {
        return view('listings.create');
    }

    public function store(JobRequest $request)
    {
        // is a user signed in? if not, create one and authenticate
        $user = Auth::user();

        if (!$user) {
            $user = $this->userService->create($request);
        }

        return $this->listingService->create($request, $user);
    }
}

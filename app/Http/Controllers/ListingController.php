<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ListingController extends Controller
{
    public function __construct()
    {


    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $filters = $request->only([
            'priceFrom',
            'priceTo',
            'beds',
            'baths',
            'areaFrom',
            'areaTo'
        ]);


        $listings = Listing::with('images')->filter($filters)->orderBy('created_at', 'desc')->withoutSold()->paginate(10)->withQueryString();


        return inertia('Listing/Index', compact(['listings', 'filters']));
    }


    public function show(Request $request, int $id)
    {

        $cacheKey = "listing_{$id}";

        $listing = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($id) {

            return Listing::with('images')->findOrFail($id);
        });

        $offer = !$request->user() ? null : $request->user()->offers()->where('listing_id', $listing->id)->first();

        return inertia('Listing/Show', compact('listing', 'offer'));
    }


}
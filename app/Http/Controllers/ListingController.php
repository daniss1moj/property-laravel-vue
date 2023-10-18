<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
    public function __construct()
    {

        $this->authorizeResource(Listing::class, 'listing');
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


    public function show(Request $request, Listing $listing)
    {

        $listing->load('images');
        $offer = !$request->user() ? null : $request->user()->offers()->where('listing_id', $listing->id)->first();

        return inertia('Listing/Show', compact('listing', 'offer'));
    }


}
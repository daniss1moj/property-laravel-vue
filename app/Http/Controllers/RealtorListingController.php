<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Policies\RealtorListingPolicy;
use Illuminate\Http\Request;

class RealtorListingController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Listing::class, 'listing');
    }

    public function index(Request $request)
    {

        $filters = [
            'deleted' => $request->boolean('deleted'),
            ...$request->only(['by', 'order'])
        ];

        $listings = $request->user()->listings()->withCount(['images', 'offers'])->filter($filters)->paginate(5)->withQueryString();
        return inertia('Realtor/Index', compact(['listings', 'filters']));
    }

    public function show(Listing $listing)
    {

        $this->authorize('isListingOwner', $listing);
        return inertia('Realtor/Show', ['listing' => $listing->load('offers', 'offers.bidder')]);
    }


    public function create()
    {
        return inertia('Realtor/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'beds' => 'required|integer|min:0|max:30',
            'baths' => 'required|integer|min:0|max:30',
            "area" => 'required|integer|min:1|max:1500',
            "city" => "required",
            "code" => "required",
            'street' => 'required',
            "street_nr" => "required|min:1",
            'price' => 'required|integer|min:1'
        ]);
        $request->user()->listings()->create($data);
        return redirect()->route('realtor.listings.index')->with('success', 'Listing was created!');
    }
    public function edit(Listing $listing)
    {
        return inertia('Realtor/Edit', compact('listing'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing)
    {
        $data = $request->validate([
            'beds' => 'required|integer|min:0|max:30',
            'baths' => 'required|integer|min:0|max:30',
            "area" => 'required|integer|min:10|max:1500',
            "city" => "required",
            "code" => "required",
            "street_nr" => "required|min:1",
            'price' => 'required|integer|min:1'

        ]);
        $listing->update($data);
        return redirect()->route('realtor.listings.index')->with('success', 'Listing was updated!');
    }

    public function destroy(Listing $listing)
    {
        $listing->deleteOrFail();

        return redirect()->back()->with('success', 'Listing was deleted!');
    }

    public function restore(Listing $listing)
    {
        $listing->restore();
        return redirect()->route('realtor.listings.index')->with('success', 'Listing was restored!');
    }
}
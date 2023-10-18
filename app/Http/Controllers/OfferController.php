<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Notifications\OfferMade;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function store(Request $request, Listing $listing)
    {
        try {
            $data = $request->validate([
                'amount' => 'required|integer|min:1|max:200000000'
            ]);


            $offer = $request->user()->offers()->make($data);
            $offer->listing()->associate($listing);
            $offer->save();

            $listing->owner->notify(
                new OfferMade($offer)
            );
            return redirect()->back()->with('success', 'Offer was made!');

        } catch (\Exception $exception) {
            dd($exception);
        }

    }
}
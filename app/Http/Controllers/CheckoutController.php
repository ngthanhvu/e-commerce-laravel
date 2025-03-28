<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Thanh toán";
        $addresses = Address::where('user_id', Auth::user()->id)->get();
        return view('checkout', compact('title', 'addresses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Checkout $checkout)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Checkout $checkout)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Checkout $checkout)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Checkout $checkout)
    {
        //
    }
}

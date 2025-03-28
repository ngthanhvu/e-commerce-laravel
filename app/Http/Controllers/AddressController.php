<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Địa chỉ";
        $address = Address::where('user_id', Auth::user()->id)->get();
        return view('profile.address', compact('title', 'address'));
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
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'user_id' => 'required|string|max:255',
        ], [
            'name.required' => 'Vui lòng nhập tên',
            'phone.required' => 'Vui lòng nhập sđt',
            'address.required' => 'Vui lòng nhập điểm giao hàng',
        ]);
        Address::create($request->all());
        return redirect()->back()->with('success', 'Thêm điểm giao hàng thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Address $address)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Address::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Xoá điểm giao hàng thành công!');
    }
}

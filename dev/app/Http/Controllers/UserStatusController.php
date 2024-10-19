<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserStatusRequest;
use App\Http\Requests\UpdateUserStatusRequest;
use App\Models\UserStatus;

class UserStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreUserStatusRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UserStatus $userStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserStatus $userStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserStatusRequest $request, UserStatus $userStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserStatus $userStatus)
    {
        //
    }
}

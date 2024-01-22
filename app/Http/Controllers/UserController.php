<?php

namespace App\Http\Controllers;

use App\Data\UserData;
use App\Models\User;
use Spatie\LaravelData\CursorPaginatedDataCollection;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): DataCollection|CursorPaginatedDataCollection|PaginatedDataCollection
    {
        return UserData::collection(User::paginate(10));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): UserData
    {
        return UserData::from($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserData $data, User $user): UserData
    {
        $user->update($data->all());

        return UserData::from($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): void
    {
        $user->delete();
    }
}

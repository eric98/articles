<?php

namespace Ergare17\Articles\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ApiUserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    // Injeccció de depèndències
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required',
            'password' => 'required',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password,
        ]);

        return $user;
    }

    public function destroy(User $user)
    {
        $user->delete();

        return $user;
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $user->name = $request->name;
        $user->save();

        return $user;
    }

    public function show(User $user)
    {
        return $user;
    }
}

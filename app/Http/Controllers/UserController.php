<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.users.index', ['collection' => User::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);

        if ($data) {
            User::create($data);
            return back()->with('msg', 'Success Create New User');
        }

        return back()->exceptInput('password');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('dashboard.users.edit', ['item' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => ''
        ]);


        if ($data) {
            $data['password'] = $data['password'] == '' ? $user->password : $data['password'];
            $name = $data['name'];

            $user->update($data);
            return redirect()->route('user.index')->with('msg', "Success Update User($name)");
        }

        return back()->exceptInput('password');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('user.index')->with('msg', 'Success Create Delete User');
    }
}

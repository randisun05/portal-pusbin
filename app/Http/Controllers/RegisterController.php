<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('register.register', [
            'title' => "Register",
            'users' => User::all(),

            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('register.index', [
            'title' => "Register",
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request ->validate([
            'name'=>'required|max:255',
            'username'=>['required','min:3','max:255','unique:users'],
            'email'=>'required|unique:users',
            'password'=>'required|min:5|max:255'
           ]);

        //    $validatedData['password'] = bcrypt($$validatedData['password']);
           $validatedData['password'] = Hash::make($validatedData['password']);

           User::create($validatedData);

           return redirect()->to('/admin/register')->with('success', 'Admin Berhasil Ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $user;
        return view('register.register', [
            'title' => "Register",
            'user' => $user

            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('register.edit', [
            'title' => "Register",
            'user' => $user

            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request ->validate([
            'name'=>'required|max:255',
            'username'=>['required','min:3','max:255','unique:users'],
            'email'=>'required|unique:users',
            'password'=>'required|min:5|max:255'
           ]);

        //    $validatedData['password'] = bcrypt($$validatedData['password']);
           $validatedData['password'] = Hash::make($validatedData['password']);

           User::where('id', $user->id)
           ->update($validatedData);

           return redirect()->to('/admin/register')->with('success', 'Admin Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);

        return redirect('/admin/register')->with('success','Admin Berhasil Dihapus');
    }
}

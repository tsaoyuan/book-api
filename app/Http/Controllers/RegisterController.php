<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(Request $request){
        // dd($request);
        $validated = $this->validate($request, [
            'name' => 'required|min:3|max:64',
            'email' => 'required|email|max:255|unique:users,email', 
            'password' => 'required|min:4|max:8|confirmed'// password_confirmation
        ]);

        // dd($validated);
        User::create($validated);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(Request $request){
        // dd($request);
        // 方法一: $this->validate($request, [...略
        $validated = $this->validate($request, [
            'name' => 'required|min:3|max:64',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:4|max:8'
        ]);

        // 方法二: $request->validate([...略
        // $validated = $request->validate([
        //     'name' => 'required|min:3|max:64',
        //     'email' => 'required|email|max:255|unique:users,email',
        //     'password' => 'required|min:4|max:8'
        // ]);
        dd($validated);
    }
}

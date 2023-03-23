<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

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
        // 將 call api 遇到 email 已重複(已註冊過) 的 json 格式顯示訊息, 用 abort_if() 客制成有效的訊息  
        abort_if(
            User::where('email', $request->input('email'))->first(),
            Response::HTTP_BAD_REQUEST,
            __('auth.duplicate email')
        );
        $user = User::create(
            array_merge(
                $validated, ['password' => Hash::make($validated['password'])]
            )
        );
        return response(['data' => $user]);
    }
}

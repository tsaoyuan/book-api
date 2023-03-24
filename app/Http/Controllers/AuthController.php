<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credential = $this->validate($request, [
            'email'    => ['required', 'email', 'max:255'],
            'password' => ['required', 'alpha_num', 'min:4', 'max:8'],
        ]);
        //驗證成功會給予token、驗證不成功會給你false
        $token = Auth::attempt($credential);
        // 取得目前登入的使用者資訊
        $user = Auth::user();
        abort_if(!$token, Response::HTTP_BAD_REQUEST, '帳號密碼錯誤');
        return response(['data' => $token, 'user' => $user]);
    }

}

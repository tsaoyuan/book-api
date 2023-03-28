<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    //
    public function store(Request $request)
    {
    
        // 通過 Policy 來授權動作
        // The current user can create the book
        $this->authorize('create', [Book::class]);
        // 取得目前登入的使用者資訊
        $user = Auth::user();
        $validated = $this->validate($request, [
            'name'   => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
        ]);
        // dd($validated);
        // table users 和 books 在 model 中，設定著一對多的關聯
        return $user->books()->create($validated);
    }
}

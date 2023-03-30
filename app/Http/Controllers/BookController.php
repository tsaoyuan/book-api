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

    public function index(Request $request){

        // 通過 Policy 來授權動作
        // The current user can viewAny the book
        // Controller Method index() 對應 Policy Method viewAny
        $this->authorize('viewAny', [Book::class]);
        $books = Book::latest();
        if ($request->boolean('owned')) {
            $books->where('user_id', Auth::user()->getKey());
        }
        return $books->paginate();

    }

    public function update(Request $request, Book $book){
        // App\Models\Book => App\Policies\BookPolicy
        // dd(Book::class);

        // 從外部注入的 Book Model instance
        // dd($book);

        // Controller 的 authorize() 用 BookPolicy 的 update() 判斷 user 是否(true or false)可以更新
        // true: 進行下一步
        // false: 403 
        $this->authorize('update', [Book::class, $book]);
        
        
    }
}

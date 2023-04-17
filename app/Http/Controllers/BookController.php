<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;
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
        // return $user->books()->create($validated);

        // use BookResource
        return BookResource::make($user->books()->create($validated));


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

    // 根據情境設計 定義一個 外部依賴注入 參數：$book
    // router model binding $book
    public function show(Book $book){
        $this->authorize('view', [Book::class, $book]);
        // dd($book);
        return BookResource::make($book);

        // BookResource.php 內的 UserResource::make($this->whenLoaded('user'))，要搭配 load() 才能顯示關聯的 user 資料載入到 BookResource
        // return BookResource::make($book->load('user'));

    }




    public function update(Request $request, Book $book){

        $this->authorize('update', [Book::class, $book]);
        $validated = $this->validate($request, [
            'name'   => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
        ]);

        // dd($validated);
        $book->update($validated);
        return $book;
        
    }

    // public function destroy(Request $request, Book $book){
    // 根據情境設計 定義一個 外部依賴注入 參數：$book
    public function destroy(Book $book){
    
        $this->authorize('delete', [Book::class, $book]);
        // dd($book->delete());
        $book->delete();
        return response()->noContent();

    }
}

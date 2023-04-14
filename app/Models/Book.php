<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'author',
    ];

    // User hasmany Book, 定義 Book 反向關聯(belongsTo) User
    public function user(){
        return $this->belongsTo(User::class);
    }
}

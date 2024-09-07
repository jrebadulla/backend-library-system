<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageBook extends Model
{
    use HasFactory;

    protected $table = 'books';
    public $timestamps = true;
    protected $primaryKey = 'book_id';
    protected $fillable = ["book_id", 'book_name', 'author', 'genre', 'fiction', 'publication_date', 'isbn', 'copies_available'];
}



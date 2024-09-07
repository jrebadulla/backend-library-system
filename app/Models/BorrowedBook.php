<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowedBook extends Model
{
    use HasFactory;

    protected $table = 'borrowed_books';
    public $timestamps = true;
    protected $primaryKey = 'book_id';
    protected $fillable = ["book_id", 'user_id', 'borrowed_at', 'due_date', 'return_at', 'status', 'created_at', 'updated_at'];
    public function book()
    {
        return $this->belongsTo(ManageBook::class, 'book_id', 'book_id');
    }
}

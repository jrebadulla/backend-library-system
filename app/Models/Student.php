<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = "students";

    protected $primaryKey = "user_id";
    protected $fillable = ['student_number','full_name', 'address','username', 'email', 'phone_number','membership_start_date','borrowing_limit', 'year_level','password'];
}

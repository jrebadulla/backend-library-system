<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;

    protected $table = 'users'; 
    public $timestamps = false;
    protected $primaryKey = 'user_id';
    protected $fillable = ['username', 'password', 'usertype', 'course', 'address', 'lastname', 'firstname', 'middlename', 'year_level', 'confirm_password', 'studentnumber'];
}


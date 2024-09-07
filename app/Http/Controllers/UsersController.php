<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function insertUsers(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'usertype' => 'required|string',
            'course' => 'required|string',
            // 'address' => 'required|string',
            // 'firstname' => 'required|string',
            // 'middlename' => 'required|string',
            // 'lastname' => 'required|string',
            // 'studentnumber' => 'required|string',
            // 'year_level' => 'required|string',
            // 'confirm_password' => 'required|string',
        ]);

        $user = new Users();
        $user->username = $request->input('username');
        $user->password = Hash::make($request->input('password'));
        $user->usertype = $request->input('usertype');
        $user->course = $request->input('course');
        // $user->address = $request->input('address');
        // $user->firstname = $request->input('firstname');
        // $user->middlename = $request->input('middlename');
        // $user->lastname = $request->input('lastname');
        // $user->studentnumber = $request->input('studentnumber');
        // $user->year_level = $request->input('year_level');
        // $user->confirm_password = $request->input('confirm_password');

        $user->save();

        return response()->json("Data inserted");
    }

    public function getUsers()
    {
        $users = Users::all();

        return response()->json($users);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
                'user_id' => $user->user_id, 
                'usertype' => $user->usertype
            ]);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }
}

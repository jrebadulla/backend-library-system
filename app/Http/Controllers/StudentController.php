<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StudentController extends Controller
{
    public function insertStudent(Request $request)
    {
        \Log::info('Request Data: ', $request->all());

        try {
            $request->validate([
                'student_number' => 'required|string|max:255',
                'full_name' => 'required|string|max:255',
                'email' => 'required|string|max:255',
                'phone_number' => 'required|string|max:11',
                'address' => 'required|string|max:255',
                'username' => 'required|string|max:255',
                'year_level' => 'required|string|max:15',
                'password' => 'required|string|max:100',
            ]);

            $data = $request->all();
            $data['password'] = Hash::make($data['password']);
            $data['borrowing_limit'] = 10;
            $data['membership_start_date'] = Carbon::now()->format('Y-m-d H:i:s');

            \Log::info('Validated Data: ', $data);

            $studentDetails = Student::create($data);

            \Log::info('Student Created: ', $studentDetails->toArray());

            return response()->json([
                'message' => 'New student inserted successfully',
                'student' => $studentDetails
            ], 201);

        } catch (\Exception $e) {
            \Log::error('Insertion Error: ', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Failed to insert student',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
    
        $user = Student::where('username', $request->username)->first();
    
        if ($user && Hash::check($request->password, $user->password)) {
       
            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
                'user_id' => $user->id, 
                'usertype' => $user->usertype
            ]);
        } else {
         
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }
}

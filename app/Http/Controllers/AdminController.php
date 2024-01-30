<?php

namespace App\Http\Controllers;
use App\Models\user;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function list(){
        $users = user::all();
        return view('admin.index', ['users' => $users]);
    }

    public function promote(Request $request)
    {
    
        // Get the user by ID
        $user = User::find($request->input('user_id'));
    
        // Check if the user exists
        if ($user) {
            // Update the user's role (adjust this based on your actual role field)
            $user->update([
                'role' => 'admin', // Change 'admin' to the desired role for promotion
            ]);
    
            // You can add additional logic or flash a success message if needed
            return redirect()->back()->with('success', 'User promoted successfully');
        } else {
            // Handle the case where the user with the given ID does not exist
            return redirect()->back()->with('error', 'User not found');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Rtsp;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = Rtsp::all();
        return view('home', ['data' => $data]);
    }

    public function ask()
    {
        try {
            if (Auth::check() && Auth::user()->role != 'admin') {
                // Update the user's role to 'askfor'
                Auth::user()->update(['role' => 'askfor']);
                return redirect()->route('home');
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
    
    

}

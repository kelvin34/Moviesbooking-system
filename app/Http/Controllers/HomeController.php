<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Movie;
use App\Models\Screens;
use App\Models\Upcoming;
use App\Models\Seats;
use App\Models\Tickets;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        if (Auth::user()->roles=="Client") {
            return redirect('/client/home');
        }
        else if (Auth::user()->roles=="Admin") {
            return redirect('/admin/home');
        }
        else{
            return view('home');
        }
    }

    public function clientdash()
    {
        Movie::checkScheduledStatus();
        $movies=Movie::limit(50)->orderByDesc('id')->where('status','Upcoming')->orWhere('status','On Air')->get();
        return view('client.home',compact('movies')); 
    }

    public function admindash()
    {
        Movie::checkScheduledStatus();
        return view('admin.home');
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect('login');
        }
        Property::setUserLogs('Saving New User');
        $storeData = $request->validate([
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'integer', 'min:9'],
            'idno' => ['required', 'integer', 'min:8',],
            'roles' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:5', 'confirmed'],
        ]); 
         try { 
            $saveuser = new User;
            $saveuser->fname =$request->input('fname');
            $saveuser->lname =$request->input('lname');
            $saveuser->phone =$request->input('phone');
            $saveuser->idno =$request->input('idno');
            $saveuser->email =$request->input('email');
            $saveuser->roles =$request->input('roles');
            $saveuser->password =Hash::make($request->input('password'));
            $saveuser->save();
                return back()->with('success', 'User Updated Successfully!');
            } catch(\Illuminate\Database\QueryException $ex){ 
              // dd($ex->getMessage()); 
                return back()->with('dbError', $ex->getMessage());
            }
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect('login');
        }
        try { 
           $updateData = $request->validate([
                'fname' => ['required', 'string', 'max:255'],
                'lname' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'integer', 'min:9'],
                'idno' => ['required', 'integer', 'min:8',],
            ]);
            User::whereId($id)->update($updateData);
            return back()->with('success', 'Profile Information updated!');
        } catch(\Illuminate\Database\QueryException $ex){ 
          // dd($ex->getMessage()); 
            return back()->with('dbError', $ex->getMessage());
        }
    }
}

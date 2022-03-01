<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Movie;
use App\Models\Screens;
use App\Models\Upcoming;
use App\Models\Seats;
use App\Models\Tickets;
use App\Models\Members;
use App\Models\Members_Plan;
use App\Notifications\ClientNotification;
use App\Notifications\ClientNotificationAdmin;
use Carbon\Carbon;

class AdminsController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','verified']);
        // if (!\Auth::check()) {
        //     return redirect('login');
        // }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function adminAccount(){
        return view('admin.newadmin');
    }

    public function adminonair(){
        Movie::checkScheduledStatus();
        return view('admin.onair');
    }

    public function adminmovies(){
        Movie::checkScheduledStatus();
        return view('admin.movies');
    }

    public function adminscreens(){
        $screens=Screens::limit(20)->orderByDesc('id')->get();
        return view('admin.screens',compact('screens'));
    }

    public function adminsearchMovies(){
        Movie::checkScheduledStatus();
        return view('admin.search');
    }


    public function adminupcoming(){
        Movie::checkScheduledStatus();
        return view('admin.upcoming');
    }

    public function admintickets(){
        return view('admin.ticketssales');
    }

    public function adminrequests(){
        return view('admin.requests');
    }

    public function adminrefunds(){
        return view('admin.refunds');
    }
    
    public function adminmyprofile(){
        return view('admin.profile');
    }

    public function adminmynewmember(){
        return view('admin.newmember');
    }


    public function adminmyplans(){
        $plans=Members_Plan::orderByDesc('id')->get();
        return view('admin.plans',compact('plans'));
    }


    public function adminmysubscribed(){
        $subscribed=Members::orderByDesc('id')->get();
        return view('admin.subscribed',compact('subscribed'));
    }

    

    public function adminmymembers(){
        $members=Member_plans::orderByDesc('id')->get();
        return view('admin.members',compact('members'));
    }

    public function adminmypayments(){
        return view('admin.payments');
    }

    public function adminmywallets(){
        return view('admin.wallets');
    }


    public function selNotifications($id){
        $unread=\Auth::user()->unreadNotifications->where('id',$id);
        if ($unread) {
            $unread->markAsRead();
            $unread=\Auth::user()->unreadNotifications->where('id',$id);
            return view('admin.notifications',compact('unread'));
        }
        else{
            return view('admin.notifications',compact('unread'));
        }
    }

    public function Notifications(){
        \Auth::user()->unreadNotifications->markAsRead();
        $unread=\Auth::user()->notifications;
        return view('admin.notifications',compact('unread'));
    }
}

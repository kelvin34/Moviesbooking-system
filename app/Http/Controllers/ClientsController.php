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
use App\Notifications\ClientNotification;
use App\Notifications\ClientNotificationAdmin;
use Carbon\Carbon;

// use App\Notifications\NewWriter;
// use App\Notifications\NewWriterNotification;

class ClientsController extends Controller
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
        if (!\Auth::check()) {
            return redirect('login');
        }
        $this->middleware('auth');
        try { 
           $updateData = $request->validate([
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
            $changepass=User::findOrFail($id);
            $changepass->password =Hash::make($request->input('password'));
            $changepass->save();
            return back()->with('success', 'Password Changed!');
        } catch(\Illuminate\Database\QueryException $ex){ 
            return back()->with('dbError', $ex->getMessage());
        }
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

    public function clientmovies(){
        Movie::checkScheduledStatus();
        $movies=Movie::limit(50)->orderByDesc('id')->get();
        return view('client.movies',compact('movies')); 
    }
    public function clientupcoming(){
        Movie::checkScheduledStatus();
        $movies=Movie::limit(20)->orderByDesc('id')->where('status','Thriller')->orWhere('status','Upcoming')->get();
        return view('client.upcoming',compact('movies'));
    }
    public function clienttickets(){
        return view('client.mytickets');
    }

    public function clientrequests(){
        return view('client.clientrequests');
    }
    public function clientrefunds(){
        return view('client.refunds');
    }
    public function clientmyaccount(){
        return view('client.myaccount');
    }

    public function clientmyprofile(){
        return view('client.profile');
    }

    
    
    public function unread_notifications(){
        $unread=\Auth::user()->unreadNotifications;
        return json_encode($unread);
    }

    public function streamscount(){
        $unread=Upcoming::orderByDesc('id')->limit(20)->where('status','Airing')->orWhere('status','Live')->count();
        return $unread;
    }

    public function timeDiff($time){
        if ($time=='null' || $time=='') {
            return '';
        }
        else{
        $timezone= (\Auth::check())?\Auth::user()->timezone:'UTC'; 
        return Carbon::parse($time)->setTimezone($timezone)->diffForHumans();
        }
    }

    public function selNotifications($id){
        $unread=\Auth::user()->unreadNotifications->where('id',$id);
        if ($unread) {
            $unread->markAsRead();
            $unread=\Auth::user()->unreadNotifications->where('id',$id);
            return view('client.notifications',compact('unread'));
        }
        else{
            return view('client.notifications',compact('unread'));
        }
    }

    public function Notifications(){
        \Auth::user()->unreadNotifications->markAsRead();
        $unread=\Auth::user()->notifications;
        return view('client.notifications',compact('unread'));
    }
}

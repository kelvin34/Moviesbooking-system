<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Movie;
use App\Models\Screens;
use App\Models\Upcoming;
use App\Models\Seats;
use App\Models\Tickets;
use App\Models\Wallet;
use App\Models\Payments;
use App\Models\Requests;
use App\Models\Refunds;
use App\Models\Members_Plan;
use App\Models\Members;
use App\Models\Members_Subs;
use App\Http\Controllers\StreamController;
use App\Notifications\ClientNotification;
use App\Notifications\ClientNotificationAdmin;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies=Movie::limit(50)->orderByDesc('id')->where('status','Upcoming')->orWhere('status','On Air')->get();
        return view('index',compact('movies'));  
    }

    public function movies()
    {
        $movies=Movie::limit(100)->orderByDesc('id')->where('status','Upcoming')->orWhere('status','On Air')->get();
        return view('movies',compact('movies'));  
    }

    public function onair()
    {
        $movies=Movie::limit(50)->orderByDesc('id')->where('status','Upcoming')->orWhere('status','On Air')->get();
        return view('onair',compact('movies'));  
    }

    public function upcoming()
    {
        $movies=Movie::limit(50)->orderByDesc('id')->where('status','Upcoming')->orWhere('status','On Air')->get();
        return view('upcoming',compact('movies'));  
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
        $movieid=trim($request->input('movieid'));
        if ($movieid=='') {
            \DB::beginTransaction();
            try {
            $saveData = $request->validate([
                'title' => ['required', 'string', 'max:255'],
                'film' => ['required', 'string', 'max:255'],
                'director' => ['required', 'string', 'max:255'],
                'genre' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string', 'max:2000'],
            ]);
            $newmovie = new Movie;
            $newmovie->title =$request->input('title');
            $newmovie->film =$request->input('film');
            $newmovie->director =$request->input('director');
            $newmovie->genre =$request->input('genre');
            $newmovie->description =$request->input('description');
            $newmovie->save();
                \DB::commit();
                // return redirect('/admin/movies')->with('success', 'Movie Added');
                return back()->with('success', 'Movie Added');
            } 
            
            catch(\Illuminate\Database\QueryException $ex){
                \DB::rollback(); 
                return back()->with('dbError', 'Movie Not Added '. $ex->getMessage());
            }
        }
        else{
            \DB::beginTransaction();
            try {
            $saveData = $request->validate([
                'title' => ['required', 'string', 'max:255'],
                'film' => ['required', 'string', 'max:255'],
                'director' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string', 'max:1000'],
            ]);
                if($newmovie =Movie::find($movieid)){
                    $newmovie->title =$request->input('title');
                    $newmovie->film =$request->input('film');
                    $newmovie->director =$request->input('director');
                    $newmovie->description =$request->input('description');
                    $newmovie->save();
                    \DB::commit();
                    return back()->with('success', 'Movie Updated');
                }
                else{

                    return back()->with('dbError', 'Movie Not Found');
                }
            } 
            
            catch(\Illuminate\Database\QueryException $ex){
                \DB::rollback(); 
                return back()->with('dbError', 'Movie Not Updated '. $ex->getMessage());
            }
        }
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

    public static function getMonths(){
        $startyear=2020;
        $startmonth=01;
        $endyear=date('Y');
        $startyear=$endyear-1;
        $currentdate= date('Y-m');
        $endmonth=12;
        for ($i=$startyear; $i <= $endyear; $i++) { 
            if ($i==$startyear) {
                $startmonth=10;
            }
            else{
                $startmonth=01;
            }

            if ($i==$endyear) {
                $endmonth=date('m');
            }
            else{
                $endmonth=12;
            }
            for ($m=$startmonth; $m <=$endmonth ; $m++) { 
                if(strlen($m)==1){
                    $m='0'.$m;
                }
                $month= $i.'-'.$m;
                $month1= $i.' '.$m;
                $monthly=Movie::getMonthDateDash($month1);
                $yearly=Movie::getYearDateDash($month1);
                
                if ($currentdate==$month) {
                    echo '<li class="page-item active monthlystats" data-id0="'.$month.'" data-id1="'.$monthly.'" data-id2="'.$yearly.'" data-id3="'.$currentdate.'">
                            <a class="page-link" href="#">
                                <p class="page-month">'.$monthly.'</p>
                                <p class="page-year">'.$yearly.'</p>
                            </a>
                        </li>';
                }
                else{
                    echo '<li class="page-item monthlystats" data-id0="'.$month.'" data-id1="'.$monthly.'" data-id2="'.$yearly.'" data-id3="'.$currentdate.'">
                            <a class="page-link" href="#">
                                <p class="page-month">'.$monthly.'</p>
                                <p class="page-year">'.$yearly.'</p>
                            </a>
                        </li>';
                }
                
            }
        }
    }

    public static function getMonthsPrev(){
        $startyear=2020;
        $startmonth=1;
        $endyear=date('Y');
        $startyearnow=$endyear-1;
        $currentdate= date('Y-m');
        $endmonth=12;
        for ($i=$startyear; $i <= $endyear; $i++) { 
            if ($i==2020) {
                $startmonth=7;
            }
            else{
                $startmonth=1;
            }

            if ($i==$endyear) {
                $endmonth=date('m');
            }
            else{
                $endmonth=12;
            }
            for ($m=$startmonth; $m <=$endmonth ; $m++) { 
                if(strlen($m)==1){
                    $m='0'.$m;
                }
                $month= $i.'-'.$m;
                $month1= $i.' '.$m;
                $monthly=Movie::getMonthDateDash($month1);
                $yearly=Movie::getYearDateDash($month1);
                
                if ($currentdate==$month) {
                        echo '<button class="btn btn-default btn-sm btn-small text-sm p-1 active monthlystats" data-id0="'.$month.'" data-id1="'.$monthly.'" data-id2="'.$yearly.'" data-id3="'.$currentdate.'">
                            <a class="page-link" href="#">
                                <p class="page-month">'.$monthly.'</p>
                                <p class="page-year">'.$yearly.'</p>
                            </a>
                          </button>';
                }
                else{
                    echo '<button class="btn btn-default btn-sm btn-small text-sm p-1 monthlystats" data-id0="'.$month.'" data-id1="'.$monthly.'" data-id2="'.$yearly.'" data-id3="'.$currentdate.'">
                            <a class="page-link" href="#">
                                <p class="page-month">'.$monthly.'</p>
                                <p class="page-year">'.$yearly.'</p>
                            </a>
                          </button>';
                }
                
            }
        }
    }

    public function getMonthlyBillsAdmin(Request $request)
    {
        if (!Auth::check()) {
            return redirect('login');
        }
        $month=$request->input('month');
        if ($month==0) {
            $month=date('Y-m');
        }
        $wallet=Movie::getWalletBalAdmin();
        $wallettotal=Movie::getWalletTotalAdmin($month);
        $walletused=Movie::getWalletUsedAdmin($month);
        $walletrefunded=Movie::getWalletRefundedAdmin($month);

        $ticket=Movie::getTicketAllAdmin($month);
        $ticketused=Movie::getTicketUsedAdmin($month);
        $ticketreturned=Movie::getTicketReservedAdmin($month);
        $ticketexpired=Movie::getTicketExpiredAdmin($month);


        $allrequests=Movie::getRequestsAllAdmin($month);
        $pendingrequests=Movie::getRequestsRequestedAdmin($month);
        $acceptedrequests=Movie::getRequestsResolvedAdmin($month);
        $cancelledrequests=Movie::getRequestsCanceledAdmin($month);
        $output='';
        
        $output.='<div class="col-12 col-sm-6 col-lg-4 col-md-4 p-1 m-0">
                <div class="info-box" style="overflow-x:auto;">
                  <span class="info-box-icon bg-olive elevation-1"><i class="fa fa-bullseye"> <span class="p-1 m-1">'.$ticket.'</span></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text"> Tickets</span>
                    <span class="info-box-number">Used: <b class="text-info">'.$ticketused.'/'.$ticket.'</b></span>
                    <span class="info-box-number">Reserved: <b class="text-info">'.$ticketreturned.'/'.$ticket.'</b></span>
                    <span class="info-box-number">Expired: <b class="text-info">'.$ticketexpired.'/'.$ticket.'</b></span>
                    
                  </div>
                </div>
              </div>';
        $output.='<div class="col-12 col-sm-6 col-lg-4 col-md-4 p-1 m-0">
                <div class="info-box" style="overflow-x:auto;">
                  <span class="info-box-icon bg-olive elevation-1"><i class="fa fa-bomb"> <span class="p-1 m-1">'.$allrequests.'</span></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text"> Requests</span>
                    <span class="info-box-number">Accepted: <b class="text-info">'.$acceptedrequests.'/'.$allrequests.'</b></span>
                    <span class="info-box-number">Requested: <b class="text-info">'.$pendingrequests.'/'.$allrequests.'</b></span>
                    <span class="info-box-number">Canceled: <b class="text-info">'.$cancelledrequests.'/'.$allrequests.'</b></span>
                    
                  </div>
                </div>
              </div>';
        $output.='<div class="col-12 col-sm-6 col-lg-4 col-md-4 p-1 m-0">
                <div class="info-box" style="overflow-x:auto;">
                  <span class="info-box-icon bg-olive elevation-1"><i class="fas fa-briefcase"> <span class="p-1 text-sm">'.$wallet.'</span></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text"> Wallet</span>
                    <span class="info-box-number">Total: <b class="text-info">Kshs. '.$wallettotal.'</b></span>
                    <span class="info-box-number">Used: <b class="text-info">Kshs. '.$walletused.'</b></span>
                    <span class="info-box-number">Refunded: <b class="text-info">Kshs. '.$walletrefunded.'</b></span>
                    
                  </div>
                </div>
              </div>';
        echo $output;
    }

    public function getMonthlyRequestsAdmin(Request $request)
    {
        if (!Auth::check()) {
            return redirect('login');
        }
        
        $allrequests=Requests::orderByDesc('id')->limit(6)->get();
        $output=''; 
        foreach ($allrequests as $thisrequests) {
            $request_id=$thisrequests->id;
            $status=$thisrequests->status;
            $request=$thisrequests->request;
            $movie=$thisrequests->movie;
            $movie_requested=$thisrequests->movie_requested;
            $comments=$thisrequests->comments;
            $created_at=$thisrequests->created_at;
            $sent_at=Movie::getTimeInTimezone($created_at);
            $sent_at_diff=Movie::getTimeInTimezoneForHumans($created_at);

            $requested_by=$thisrequests->requested_by;
            $sender=Movie::getAccountDetailsName($requested_by);

            $movie_name=$this->getMovieName($movie);
            $output.='
                <div class="col-4 m-0 p-0">
                    <div class="p-1 m-1 callout callout-success requestedmovie" data-id0="'.$request_id.'" data-id1="'.$movie_requested.'" data-id2="'.$movie.'" data-id3="'.$request.'" data-id4="'.$comments.'" data-id5="'.$status.'" data-id6="'.$sent_at.'" style="cursor:pointer;" >
                    <div>
                      <p class="text-sm p-1 m-0 bg-olive" style="border-radius:7px;">'.$movie_requested.'(<span class="text-lime">'.$status.'</span>) <span class="badge badge-light float-right">'.$sent_at_diff.'</span></p>
                      <p class="text-xs p-1 m-0 text-dark" style="white-space:pre-line;">'.$comments.'</p>
                      <p class="text-xs p-1 m-0">Sent By: <b>'.$sender.'.</b></p>
                    </div></div>
                </div>';
        }
        echo $output;
    }

    public function getMonthlyMembersAdmin(Request $request)
    {
        if (!Auth::check()) {
            return redirect('login');
        }
        $allmembers=User::orderByDesc('id')->limit(6)->where('status','Active')->get();
        $output=''; 
        foreach ($allmembers as $thismembers) {
            $member_id=$thismembers->id;
            $status=$thismembers->status;
            $fname=$thismembers->fname;
            $lname=$thismembers->lname;
            $phone=$thismembers->phone;
            $roles=$thismembers->roles;
            $gender=$thismembers->gender;
            $created_at=$thismembers->created_at;
            $since_on=Movie::getTimeInTimezone($created_at);
            $since_on_diff=Movie::getTimeInTimezoneForHumans($created_at);
            $output.='
                <div class="col-lg-3 col-md-4 col-6 m-0 p-1">
                    <div class="callout callout-info p-2">
                        <div class="product-img">';
            if($gender=='Male'){
                $output.='<img src="/assets/img/avatar.png" class="profile-user-img img-circle" alt="User Image">';
            }
            else{
                $output.='<img src="/assets/img/avatar3.png" class="profile-user-img img-circle" alt="User Image">';
            }
            $output.='</div>
                        <div class="product-info">
                            <a class="users-list-name" data-id0="'.$member_id.'" data-id1="'.$fname.'" data-id2="'.$lname.'" data-id3="'.$phone.'" data-id4="'.$gender.'" data-id5="'.$status.'" data-id6="'.$since_on.'" style="cursor:pointer;">'.$fname.' '.$lname.'</a>
                            <span class="users-list-date">'.$roles.'</span>
                            <span class="users-list-date">'.$since_on_diff.'</span>
                        </div>
                    </div>
                  </div>';
        }
        echo $output;
    }

    public function getMonthlyMoviesAdmin(Request $request)
    {
        if (!Auth::check()) {
            return redirect('login');
        }
        $allmovies=Movie::orderByDesc('id')->limit(6)->get();
        $output=''; 
        foreach ($allmovies as $thismovies) {
            $movie_id=$thismovies->id;
            $status=$thismovies->status;
            $title=$thismovies->title;
            $film=$thismovies->film;
            $director=$thismovies->director;
            $genre=$thismovies->genre;
            $description=$thismovies->description;
            $created_at=$thismovies->created_at;
            $since_on=Movie::getTimeInTimezone($created_at);
            $since_on_diff=Movie::getTimeInTimezoneForHumans($created_at);
            $output.='
                <div class="col-lg-4 col-6 m-0 p-1">
                    <div class="callout callout-info p-0">
                      <div class="product-img">
                          <span class="fa fa-film fa-3x text-olive"></span>
                        </div>
                        <div class="product-info">
                          <a class="product-title" data-id0="'.$movie_id.'" data-id1="'.$title.'" data-id2="'.$film.'" data-id3="'.$director.'" data-id4="'.$genre.'" data-id5="'.$status.'" data-id6="'.$since_on.'" style="cursor:pointer;">'.$title.'(<span class="text-dark">'.$status.'</span>) 
                            <span class="badge badge-light float-right">'.$since_on_diff.'</span></a>
                          <span class="product-description" style="white-space:pre-line;">
                            By: '.$film.'
                          </span>
                        </div>
                    </div>
                  </div>

                ';
        }
        echo $output;
    }

    public function getMonthlyBills(Request $request)
    {
        if (!Auth::check()) {
            return redirect('login');
        }
        $month=$request->input('month');
        if ($month==0) {
            $month=date('Y-m');
        }
        $wallet=Movie::getWalletBal();
        $wallettotal=Movie::getWalletTotal($month);
        $walletused=Movie::getWalletUsed($month);
        $walletrefunded=Movie::getWalletRefunded($month);

        $ticket=Movie::getTicketAll($month);
        $ticketused=Movie::getTicketUsed($month);
        $ticketreturned=Movie::getTicketReserved($month);
        $ticketexpired=Movie::getTicketExpired($month);

        $allrequests=Movie::getRequestsAll($month);
        $pendingrequests=Movie::getRequestsRequested($month);
        $acceptedrequests=Movie::getRequestsResolved($month);
        $cancelledrequests=Movie::getRequestsCanceled($month);
        $output='';
        
        $output.='<div class="col-12 col-sm-6 col-lg-4 col-md-4 p-1 m-0">
                <div class="info-box" style="overflow-x:auto;">
                  <span class="info-box-icon bg-olive elevation-1"><i class="fa fa-bullseye"> <span class="p-1 m-1">'.$ticket.'</span></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text"> Tickets</span>
                    <span class="info-box-number">Used: <b class="text-info">'.$ticketused.'/'.$ticket.'</b></span>
                    <span class="info-box-number">Reserved: <b class="text-info">'.$ticketreturned.'/'.$ticket.'</b></span>
                    <span class="info-box-number">Expired: <b class="text-info">'.$ticketexpired.'/'.$ticket.'</b></span>
                    
                  </div>
                </div>
              </div>';
        $output.='<div class="col-12 col-sm-6 col-lg-4 col-md-4 p-1 m-0">
                <div class="info-box" style="overflow-x:auto;">
                  <span class="info-box-icon bg-olive elevation-1"><i class="fa fa-bomb"> <span class="p-1 m-1">'.$allrequests.'</span></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text"> Requests</span>
                    <span class="info-box-number">Accepted: <b class="text-info">'.$acceptedrequests.'/'.$allrequests.'</b></span>
                    <span class="info-box-number">Requested: <b class="text-info">'.$pendingrequests.'/'.$allrequests.'</b></span>
                    <span class="info-box-number">Canceled: <b class="text-info">'.$cancelledrequests.'/'.$allrequests.'</b></span>
                    
                  </div>
                </div>
              </div>';
        $output.='<div class="col-12 col-sm-6 col-lg-4 col-md-4 p-1 m-0">
                <div class="info-box" style="overflow-x:auto;">
                  <span class="info-box-icon bg-olive elevation-1"><i class="fas fa-briefcase"> <span class="p-1 text-sm">'.$wallet.'</span></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text"> Wallet</span>
                    <span class="info-box-number">Total: <b class="text-info">Kshs. '.$wallettotal.'</b></span>
                    <span class="info-box-number">Used: <b class="text-info">Kshs. '.$walletused.'</b></span>
                    <span class="info-box-number">Refunded: <b class="text-info">Kshs. '.$walletrefunded.'</b></span>
                    
                  </div>
                </div>
              </div>';
        echo $output;
    }

    
    public function newMovieRequests(Request $request)
    {
        if (!Auth::check()) {
            return redirect('login');
        }
        \DB::beginTransaction();
        try {
        $saveData = $request->validate([
            'movie_title' => ['required', 'string', 'max:255'],
            'movie_description' => ['required', 'string', 'max:1000'],
        ]);
        $owner=\Auth::user()->id;
        $fullname=\Auth::user()->fname.' '.\Auth::user()->lname;
        $phone=\Auth::user()->phone;
        $email =\Auth::user()->email;
        $requestmovieid=$request->input('requestmovieid');
        $newrequest = new Requests;
        if($requestmovieid!=''){
            $newrequest->movie =$requestmovieid;
        }
        $newrequest->movie_requested =$request->input('movie_title');
        $newrequest->request =$request->input('movie_description');
        $newrequest->requested_by =$owner;
        $newrequest->comments ='Movie Requested by Client';
        $newrequest->status ='Requested';
        $newrequest->save();
            \Auth::user()->notify(new ClientNotification('Movie Request',$owner,$email,$fullname,$phone,'No Movie ID','No Movie Name','No Screen ID','No Screen Name','No Upcoming ID','No Seat ID','No Seat Name','No Seat Section','No Ticket Amount','No Start Date','No End Date','No Ticket ID','No Ticket','Movie Request','No Wallet','No Sold On','No Used On','New Movie Request Sent'));
            $admins=User::where('roles','Admin')->where('status','Active')->get();
            foreach ($admins as $admin) {
                $admin->notify(new ClientNotificationAdmin('Movie Request',$owner,$email,$fullname,$phone,'No Movie ID','No Movie Name','No Screen ID','No Screen Name','No Upcoming ID','No Seat ID','No Seat Name','No Seat Section','No Ticket Amount','No Start Date','No End Date','No Ticket ID','No Ticket','Movie Request','No Wallet','No Sold On','No Used On','New Movie Request Sent'));
            }

            \DB::commit();
            echo 'New Request Sent Successful';
        } 
        
        catch(\Illuminate\Database\QueryException $ex){
            \DB::rollback(); 
            echo 'New Request was not Sent '. $ex->getMessage();
        }
    }

    public function respondMovieRequests(Request $request)
    {
        \DB::beginTransaction();
        try {
            
            $requestmovieid=$request->input('requestmovieid');

            if($requestmovieid==''){
                $request_id=$request->input('request_id');
                $request_comments=$request->input('request_comments');
                $newrequest = Requests::find($request_id);
                $owner=$newrequest->requested_by;
                $thiscomments='';
                if($request_comments==''){
                    $thiscomments ='Movie Was not found. Request was Canceled';
                }
                else{
                    $thiscomments =$request->input('request_comments');
                }
                $newrequest->comments=$thiscomments;
                $newrequest->status ='Canceled';
                $newrequest->save();
                $fullname=Movie::getAccountDetailsName($owner);
                $thisuser=User::find($owner);
                $thisuser->notify(new ClientNotification('Movie Request Response',$owner,'No Email',$fullname,'No Phone','No Movie ID','No Movie Name','No Screen ID','No Screen Name','No Upcoming ID','No Seat ID','No Seat Name','No Seat Section','No Ticket Amount','No Start Date','No End Date','No Ticket ID','No Ticket','Movie Request Response','No Wallet','No Sold On','No Used On',$thiscomments));
                $admins=User::where('roles','Admin')->where('status','Active')->get();
                foreach ($admins as $admin) {
                    $admin->notify(new ClientNotificationAdmin('Movie Request Response',$owner,'No Email',$fullname,'No Phone','No Movie ID','No Movie Name','No Screen ID','No Screen Name','No Upcoming ID','No Seat ID','No Seat Name','No Seat Section','No Ticket Amount','No Start Date','No End Date','No Ticket ID','No Ticket','Movie Request Response','No Wallet','No Sold On','No Used On',$thiscomments));
                }
                \DB::commit();
                echo 'No Movie Found. Request Was Canceled';
            }
            else{
                $request_id=$request->input('request_id');
                $newrequest = Requests::find($request_id);
                $owner=$newrequest->requested_by;
                $newrequest->movie =$request->input('requestmovieid');
                $newrequest->comments =$request->input('request_comments');
                $newrequest->status ='Resolved';
                $newrequest->save();
                $fullname=Movie::getAccountDetailsName($owner);
                $thisuser=User::find($owner);
                $thisuser->notify(new ClientNotification('Movie Request Response',$owner,'No Email',$fullname,'No Phone','No Movie ID','No Movie Name','No Screen ID','No Screen Name','No Upcoming ID','No Seat ID','No Seat Name','No Seat Section','No Ticket Amount','No Start Date','No End Date','No Ticket ID','No Ticket','Movie Request Response','No Wallet','No Sold On','No Used On',$request->input('request_comments')));
                $admins=User::where('roles','Admin')->where('status','Active')->get();
                foreach ($admins as $admin) {
                    $admin->notify(new ClientNotificationAdmin('Movie Request Response',$owner,'No Email',$fullname,'No Phone','No Movie ID','No Movie Name','No Screen ID','No Screen Name','No Upcoming ID','No Seat ID','No Seat Name','No Seat Section','No Ticket Amount','No Start Date','No End Date','No Ticket ID','No Ticket','Movie Request Response','No Wallet','No Sold On','No Used On',$request->input('request_comments')));
                }
                \DB::commit();
                echo 'Movie Request Is Now Responded to';
            } 
        } 
        
        catch(\Illuminate\Database\QueryException $ex){
            \DB::rollback(); 
            echo 'New Request was not Sent '. $ex->getMessage();
        }
    }

    public function respondRefundRequests(Request $request)
    {
        \DB::beginTransaction();
        try {
            
            $amount_refunded=$request->input('amount_refunded');
            $resolved_on=new Carbon(Carbon::now()->format('Y-m-d H:i:s'));
            if($amount_refunded<=0){
                $refund_id=$request->input('refund_id');
                $newrequest = Refunds::find($refund_id);
                $owner=$newrequest->by;
                $newrequest->comments =$request->input('refund_comments');
                $newrequest->resolved_on=$resolved_on;
                $newrequest->status ='Declined';
                $newrequest->save();
                $fullname=Movie::getAccountDetailsName($owner);
                $thisuser=User::find($owner);
                $thisuser->notify(new ClientNotification('Refund Request Response',$owner,'No Email',$fullname,'No Phone','No Movie ID','No Movie Name','No Screen ID','No Screen Name','No Upcoming ID','No Seat ID','No Seat Name','No Seat Section','No Ticket Amount','No Start Date','No End Date','No Ticket ID','No Ticket','Declined','No Wallet','No Sold On','No Used On',$request->input('refund_comments')));
                $admins=User::where('roles','Admin')->where('status','Active')->get();
                foreach ($admins as $admin) {
                    $admin->notify(new ClientNotificationAdmin('Refund Request Response',$owner,'No Email',$fullname,'No Phone','No Movie ID','No Movie Name','No Screen ID','No Screen Name','No Upcoming ID','No Seat ID','No Seat Name','No Seat Section','No Ticket Amount','No Start Date','No End Date','No Ticket ID','No Ticket','Declined','No Wallet','No Sold On','No Used On',$request->input('refund_comments')));
                }
                \DB::commit();
                echo 'Refund Request Declined';
            }
            else{
                $refund_id=$request->input('refund_id');
                $requestresponse = Refunds::find($refund_id);
                $by=$requestresponse->by;
                $reason=$requestresponse->reason;
                $bytickets=Tickets::where('holder',$by)->get();
                $ticket_found=0;
                foreach ($bytickets as $tickets) {
                    $ticket=$tickets->ticket;
                    $ticket_id=$tickets->id;
                    if(preg_match("/$ticket/i", $reason,$match)){
                        $ticket_found=1;
                        $requestresponse->amount_refunded =$request->input('amount_refunded');
                        $requestresponse->comments =$request->input('refund_comments');
                        $requestresponse->resolved_on=$resolved_on;
                        $requestresponse->status ='Resolved';
                        $requestresponse->save();

                        $updatewallet = new Wallet;
                        $updatewallet->ticket_id =$ticket_id;
                        $updatewallet->amount_out =0;
                        $updatewallet->amount_in =$amount_refunded;
                        $updatewallet->description ='Amount Refunded';
                        $updatewallet->owner =$by;
                        $updatewallet->status ='Success';
                        $updatewallet->save();
                        $fullname=Movie::getAccountDetailsName($by);
                        $thisuser=User::find($by);
                        $thisuser->notify(new ClientNotification('Refund Request Response',$by,'No Email',$fullname,'No Phone','No Movie ID','No Movie Name','No Screen ID','No Screen Name','No Upcoming ID','No Seat ID','No Seat Name','No Seat Section','No Ticket Amount','No Start Date','No End Date','No Ticket ID','No Ticket','Resolved','No Wallet','No Sold On','No Used On',$request->input('refund_comments')));
                        $admins=User::where('roles','Admin')->where('status','Active')->get();
                        foreach ($admins as $admin) {
                            $admin->notify(new ClientNotificationAdmin('Refund Request Response',$by,'No Email',$fullname,'No Phone','No Movie ID','No Movie Name','No Screen ID','No Screen Name','No Upcoming ID','No Seat ID','No Seat Name','No Seat Section','No Ticket Amount','No Start Date','No End Date','No Ticket ID','No Ticket','Resolved','No Wallet','No Sold On','No Used On',$request->input('refund_comments')));
                        }
                        \DB::commit();

                        echo 'Refund Request Is Now Responded to.';
                    }

                }
                if ($ticket_found==0) {
                    $requestresponse->comments =$request->input('refund_comments');
                    $requestresponse->resolved_on=$resolved_on;
                    $requestresponse->status ='Declined';
                    $requestresponse->save();
                    $fullname=Movie::getAccountDetailsName($by);
                    $thisuser=User::find($by);
                    $thisuser->notify(new ClientNotification('Refund Request Response',$by,'No Email',$fullname,'No Phone','No Movie ID','No Movie Name','No Screen ID','No Screen Name','No Upcoming ID','No Seat ID','No Seat Name','No Seat Section','No Ticket Amount','No Start Date','No End Date','No Ticket ID','No Ticket','Declined','No Wallet','No Sold On','No Used On',$request->input('refund_comments')));
                    $admins=User::where('roles','Admin')->where('status','Active')->get();
                    foreach ($admins as $admin) {
                        $admin->notify(new ClientNotificationAdmin('Refund Request Response',$by,'No Email',$fullname,'No Phone','No Movie ID','No Movie Name','No Screen ID','No Screen Name','No Upcoming ID','No Seat ID','No Seat Name','No Seat Section','No Ticket Amount','No Start Date','No End Date','No Ticket ID','No Ticket','Declined','No Wallet','No Sold On','No Used On',$request->input('refund_comments')));
                    }
                    \DB::commit();
                    echo 'Refund Request Declined. No Ticket Found.';
                }
            } 
        } 
        
        catch(\Illuminate\Database\QueryException $ex){
            \DB::rollback(); 
            echo 'New Request was not Sent '. $ex->getMessage();
        }
    }

    public function newRefundRequests(Request $request)
    {
        $owner=\Auth::user()->id;
        $fullname=\Auth::user()->fname.' '.\Auth::user()->lname;
        $phone=\Auth::user()->phone;
        $email =\Auth::user()->email;
        \DB::beginTransaction();
        try {
            $ticket_id=$request->input('ticket_id');
            if ($ticket_id!='') {
                $upcoming=$request->input('upcoming');
                $seat_id=$request->input('seat_id');

                $section=$this->getSeatStatusID($seat_id);
                $availability=$this->getSeatAvailability($seat_id,$upcoming);
                $ticket_amount=$this->getSeatAmount($section,$upcoming);
                $seat_holder=$this->getSeatHolder($seat_id,$upcoming);
                $seat_holder_name=$this->getSeatHolderName($seat_holder);
                $seat_holder_phone=$this->getSeatHolderPhone($seat_holder);
                $movie_id=$this->getMovieId($upcoming);
                $movie_name=$this->getMovieName($movie_id);
                $screen_id=$this->getScreenId($upcoming);
                $screen_name=$this->getScreenName($screen_id);
                $seat_name=$this->getSeatName($seat_id);
                $sold_on_date=Movie::getTimeInTimezone($this->getSeatSoldOn($seat_id,$upcoming));
                $used_on_date=Movie::getTimeInTimezone($this->getSeatUsedOn($seat_id,$upcoming));
                $ticket_id=$this->getTicketId($seat_id,$upcoming);
                $thisticket=$this->getTicketName($seat_id,$upcoming);
                $status=$this->getTicketStatus($seat_id,$upcoming);
                $sold_on=Movie::getTimeInTimezone($sold_on_date);
                $used_on=Movie::getTimeInTimezone($used_on_date);
                $start_date=$this->getStartDate($upcoming);
                $end_date=$this->getEndDate($upcoming);
                $email=$this->getEmail($seat_holder);
$reason='Request for Refund of Canceled Ticket: '.$thisticket.'
Movie: '.$movie_name.'.
On Screen: '.$screen_name.'.
Airing AT: '.$start_date.'.';
                if ($this->checkRefundSentforCanceled($thisticket)>0) {
                    echo 'Refund Request Was Sent Successful';
                }
                else{
                    $newrefundrequest = new Refunds;
                    $newrefundrequest->amount_requested =$ticket_amount;
                    $newrefundrequest->reason =$reason;
                    $newrefundrequest->by =$owner;
                    $newrefundrequest->comments ='Refund Requested by Client';
                    $newrefundrequest->status ='Requested';
                    $newrefundrequest->save();
                    \Auth::user()->notify(new ClientNotification('Refund Request',$owner,$email,$fullname,$phone,'No Movie ID','No Movie Name','No Screen ID','No Screen Name','No Upcoming ID','No Seat ID','No Seat Name','No Seat Section','No Ticket Amount','No Start Date','No End Date','No Ticket ID','No Ticket','Refund Request','No Wallet','No Sold On','No Used On',$reason));
                    $admins=User::where('roles','Admin')->where('status','Active')->get();
                    foreach ($admins as $admin) {
                        $admin->notify(new ClientNotificationAdmin('Refund Request',$owner,$email,$fullname,$phone,'No Movie ID','No Movie Name','No Screen ID','No Screen Name','No Upcoming ID','No Seat ID','No Seat Name','No Seat Section','No Ticket Amount','No Start Date','No End Date','No Ticket ID','No Ticket','Refund Request','No Wallet','No Sold On','No Used On',$reason));
                    }

                    \DB::commit();
                    echo 'New Refund Request Sent Successful';
                }
                
            }
            else{
                $saveData = $request->validate([
                    'reason' => ['required', 'string', 'max:1000'],
                    'amount_requested' => 'required|numeric|between:1,100000',
                ]);
                $newrefundrequest = new Refunds;
                $newrefundrequest->amount_requested =$request->input('amount_requested');
                $newrefundrequest->reason =$request->input('reason');
                $newrefundrequest->by =$owner;
                $newrefundrequest->comments ='Refund Requested by Client';
                $newrefundrequest->status ='Requested';
                $newrefundrequest->save();
                \Auth::user()->notify(new ClientNotification('Refund Request',$owner,$email,$fullname,$phone,'No Movie ID','No Movie Name','No Screen ID','No Screen Name','No Upcoming ID','No Seat ID','No Seat Name','No Seat Section','No Ticket Amount','No Start Date','No End Date','No Ticket ID','No Ticket','Refund Request','No Wallet','No Sold On','No Used On',$request->input('reason')));
                    $admins=User::where('roles','Admin')->where('status','Active')->get();
                    foreach ($admins as $admin) {
                        $admin->notify(new ClientNotificationAdmin('Refund Request',$owner,$email,$fullname,$phone,'No Movie ID','No Movie Name','No Screen ID','No Screen Name','No Upcoming ID','No Seat ID','No Seat Name','No Seat Section','No Ticket Amount','No Start Date','No End Date','No Ticket ID','No Ticket','Refund Request','No Wallet','No Sold On','No Used On',$request->input('reason')));
                    }
                \DB::commit();
                echo 'New Refund Request Sent Successful';
            }
            
        } 
        
        catch(\Illuminate\Database\QueryException $ex){
            \DB::rollback(); 
            echo 'New Refund Request was not Sent '. $ex->getMessage();
        }
    }


    public function saveScreen(Request $request)
    {
        $screenmovieid=trim($request->input('screenmovieid'));
        if ($screenmovieid=='') {
            \DB::beginTransaction();
            try {
            $saveData = $request->validate([
                'screen' => ['required', 'string', 'max:255'],
                'rowsleft' => 'required|numeric|between:1,100',
                'rowscenter' => 'required|numeric|between:1,100',
                'rowsright' => 'required|numeric|between:1,100',
                'capacity' => 'required|numeric|between:10,100000',
            ]);
            $newscreen = new Screens;
            $newscreen->screen =$request->input('screen');
            $newscreen->rowsleft =$request->input('rowsleft');
            $newscreen->rowscenter =$request->input('rowscenter');
            $newscreen->rowsright =$request->input('rowsright');
            $newscreen->capacity =$request->input('capacity');
            $newscreen->save();
            $id=$newscreen->id;
            $this->setSeats($id);
                \DB::commit();
                return redirect('/admin/screens')->with('success', 'Screen Added');
            } 
            
            catch(\Illuminate\Database\QueryException $ex){
                \DB::rollback(); 
                return redirect('/admin/screens')->with('dbError', 'Screen Not Added '. $ex->getMessage());
            }
        }
        else{

            \DB::beginTransaction();
            try {
            $saveData = $request->validate([
                'screen' => ['required', 'string', 'max:255'],
                'rowsleft' => 'required|numeric|between:1,100',
                'rowscenter' => 'required|numeric|between:1,100',
                'rowsright' => 'required|numeric|between:1,100',
                'capacity' => 'required|numeric|between:10,100000',
            ]);
                if($newscreen =Screens::find($screenmovieid)){
                    $newscreen->screen =$request->input('screen');
                    $newscreen->rowsleft =$request->input('rowsleft');
                    $newscreen->rowscenter =$request->input('rowscenter');
                    $newscreen->rowsright =$request->input('rowsright');
                    $newscreen->capacity =$request->input('capacity');
                    $newscreen->save();
                    Seats::where('screen',$screenmovieid)->delete();
                    $this->setSeats($screenmovieid);
                    \DB::commit();
                    return redirect('/admin/screens')->with('success', 'Screen Updated');
                }
                else{

                    return redirect('/admin/screens')->with('dbError', 'Screen Not Found');
                }
            } 
            
            catch(\Illuminate\Database\QueryException $ex){
                \DB::rollback(); 
                return redirect('/admin/screens')->with('dbError', 'Screen Not Updated '. $ex->getMessage());
            }
        }
    }

    
    public function bookSeat(Request $request)
    {   
        $owner=\Auth::user()->id;
        $fullname=\Auth::user()->fname.' '.\Auth::user()->lname;
        $phone=\Auth::user()->phone;
        $email =\Auth::user()->email;
        $movie_id=$request->input('movie_id');
        $movie_name=$request->input('movie_name');
        $screen_name=$request->input('screen_name');
        $screen_id=$request->input('screen_id');
        $upcoming=$request->input('upcoming');
        $seat_id=$request->input('seat_id');
        $seat_name=$request->input('seat_name');
        $seat_section=$request->input('seat_section');
        $ticket_amount=$request->input('ticket_amount');
        $currentdate=date('YmdHis');
        $solddate=new Carbon(Carbon::now()->format('Y-m-d H:i:s'));
        $start_date=$this->getStartDate($upcoming);
        $end_date=$this->getEndDate($upcoming);
        $ticket=$upcoming.'-'.$seat_name.'-'.$currentdate;
        \DB::beginTransaction();
        try {
            $newticket = new Tickets;
            $newticket->ticket =$ticket;
            $newticket->seat_no =$seat_id;
            $newticket->upcoming =$upcoming;
            $newticket->holder =$owner;
            $newticket->status ='Booked';
            $newticket->save();
            $ticket_id=$newticket->id;
            User::find($owner)->notify(new ClientNotification('Booked',$owner,$email,$fullname,$phone,$movie_id,$movie_name,$screen_id,$screen_name,$upcoming,$seat_id,$seat_name,$seat_section,$ticket_amount,$start_date,$end_date,$ticket_id,$ticket,'Booked','No Wallet',$currentdate,'No Used On','Seat Booked Successfully'));
                $admins=User::where('roles','Admin')->where('status','Active')->get();
                foreach ($admins as $admin) {
                    $admin->notify(new ClientNotificationAdmin('Booked',$owner,$email,$fullname,$phone,$movie_id,$movie_name,$screen_id,$screen_name,$upcoming,$seat_id,$seat_name,$seat_section,$ticket_amount,$start_date,$end_date,$ticket_id,$ticket,'Booked','No Wallet',$currentdate,'No Used On','Seat Booked Successfully'));
                }
            $wallet=Movie::getWalletBal();
            if ($wallet>=$ticket_amount) {
                Tickets::where('id',$ticket_id)->update(['status'=>'Reserved','sold_on'=>$solddate]); 
                $updatewallet = new Wallet;
                $updatewallet->ticket_id =$ticket_id;
                $updatewallet->amount_out =$ticket_amount;
                $updatewallet->amount_in =0;
                $updatewallet->description ='Paid for Ticket';
                $updatewallet->owner =$owner;
                $updatewallet->status ='Success';
                $updatewallet->save();
                User::find($owner)->notify(new ClientNotification('Reserved',$owner,$email,$fullname,$phone,$movie_id,$movie_name,$screen_id,$screen_name,$upcoming,$seat_id,$seat_name,$seat_section,$ticket_amount,$start_date,$end_date,$ticket_id,$ticket,'Reserved','No Wallet',$solddate,'No Used On','Seat Reserved Successfully'));
                $admins=User::where('roles','Admin')->where('status','Active')->get();
                foreach ($admins as $admin) {
                    $admin->notify(new ClientNotificationAdmin('Reserved',$owner,$email,$fullname,$phone,$movie_id,$movie_name,$screen_id,$screen_name,$upcoming,$seat_id,$seat_name,$seat_section,$ticket_amount,$start_date,$end_date,$ticket_id,$ticket,'Reserved','No Wallet',$solddate,'No Used On','Seat Reserved Successfully'));
                }
                echo '
                    <div class="bg-warning">Seat Booked and Reserved Successful.<br>
                        Your Ticket is: <b>'.$ticket.'</b><br>
                        Your Can Cancel Ticket in My Tickets<br>
                        Thank You.
                    </div>';
            }
            else{
                echo '
                    <div class="bg-warning">Seat Booked Successful.<br>
                        Your Ticket is: <b>'.$ticket.'</b><br>
                        <span class="text-danger">Seat is Not Paid for.</span><br>
                        Your Need to Complete Payment in the next 10 minutes.<br>
                        Your Account number is: <b>'.$ticket_id.'</b><br>
                        Paybill Number is: <b>123412</b><br>
                        Once Paid, Confirm With Transaction Id in My Tickets<br>
                        Thank You.
                    </div>';
            }
            \DB::commit();

        } 
        
        catch(\Illuminate\Database\QueryException $ex){
            \DB::rollback(); 
            echo 'Could not Book Seat. Error.<br>'. $ex->getMessage();
        }
        catch(\Swift_TransportException $ex){ 
            \DB::rollback();
            echo 'Could not Book Seat. Error.<br> Please check your Connection.';
        }
    }

    public function payTicket(Request $request)
    {   
        $owner=\Auth::user()->id;
        $fullname=\Auth::user()->fname.' '.\Auth::user()->lname;
        $phone=\Auth::user()->phone;
        $email =\Auth::user()->email;
        $movie_id=$request->input('movie_id');
        $movie_name=$request->input('movie_name');
        $screen_name=$request->input('screen_name');
        $screen_id=$request->input('screen_id');
        $upcoming=$request->input('upcoming');
        $seat_id=$request->input('seat_id');
        $seat_name=$request->input('seat_name');
        $seat_section=$request->input('seat_section');
        $ticket_amount=$request->input('ticket_amount');
        $ticket_id=$request->input('ticket_id');
        $ticket=$request->input('ticket');
        $transactionid=$request->input('transactionid');
        $total_amount=$request->input('total_amount');
        $currentdate=new Carbon(Carbon::now()->format('Y-m-d H:i:s'));
        $description='Deposited Amount '.$ticket;
        $start_date=$this->getStartDate($upcoming);
        $end_date=$this->getEndDate($upcoming);
        \DB::beginTransaction();
        try {
            $newpayment = new Payments;
            $newpayment->paid_on =$currentdate;
            $newpayment->transaction_id =$transactionid;
            $newpayment->amount =$total_amount;
            $newpayment->ticket_id =$ticket_id;
            $newpayment->description =$description;
            $newpayment->paid_by =$owner;
            $newpayment->status ='Success';
            $newpayment->save();
            $updatewallet = new Wallet;
            $updatewallet->ticket_id =$ticket_id;
            $updatewallet->amount_out =0;
            $updatewallet->amount_in =$total_amount;
            $updatewallet->description ='Amount Deposited';
            $updatewallet->owner =$owner;
            $updatewallet->status ='Success';
            $updatewallet->save();
            $wallet=Movie::getWalletBal();
            if ($wallet>=$ticket_amount) {
                Tickets::where('id',$ticket_id)->update(['status'=>'Reserved','sold_on'=>$currentdate]); 
                $updatewallet = new Wallet;
                $updatewallet->ticket_id =$ticket_id;
                $updatewallet->amount_out =$ticket_amount;
                $updatewallet->amount_in =0;
                $updatewallet->description ='Paid for Ticket';
                $updatewallet->owner =$owner;
                $updatewallet->status ='Success';
                $updatewallet->save();
                User::find($owner)->notify(new ClientNotification('Reserved',$owner,$email,$fullname,$phone,$movie_id,$movie_name,$screen_id,$screen_name,$upcoming,$seat_id,$seat_name,$seat_section,$ticket_amount,$start_date,$end_date,$ticket_id,$ticket,'Reserved','No Wallet',$currentdate,'No Used On','Seat Reserved Successfully'));
                $admins=User::where('roles','Admin')->where('status','Active')->get();
                foreach ($admins as $admin) {
                    $admin->notify(new ClientNotificationAdmin('Reserved',$owner,$email,$fullname,$phone,$movie_id,$movie_name,$screen_id,$screen_name,$upcoming,$seat_id,$seat_name,$seat_section,$ticket_amount,$start_date,$end_date,$ticket_id,$ticket,'Reserved','No Wallet',$currentdate,'No Used On','Seat Reserved Successfully'));
                }
                echo '
                    <div class="bg-warning">Payment Success.<br>
                        Seat Reserved Successful.<br>
                        Your Ticket is: <b>'.$ticket.'</b><br>
                        Your Can Cancel Ticket in My Tickets<br>
                        Thank You.
                    </div>';
            }
            else{
                echo '
                    <div class="bg-warning">Payment Unsuccessful.<br>
                        Your Ticket is: <b>'.$ticket.'</b><br>
                        <span class="text-danger">Seat is Not Paid for.</span><br>
                        Your Need to Complete Payment in 10 minutes.<br>
                        Your Account number is: <b>'.$ticket_id.'</b><br>
                        Paybill Number is: <b>123412</b><br>
                        Once Paid, Confirm With Transaction ID Here<br>
                        Thank You.
                    </div>';
            }
            \DB::commit();

        } 
        
        catch(\Illuminate\Database\QueryException $ex){
            \DB::rollback(); 
            echo 'Could not Pay for Ticket. Error.<br>'. $ex->getMessage();
        }
        catch(\Swift_TransportException $ex){ 
            \DB::rollback();
            echo 'Could not pay for Ticket. Error.<br> Please check your Connection.';
        }
    }


    public function payPackageAmount($amount,$wallet,$id,$member,$days,$plan,$total_amount,$transactionid)
    {   
        $planid=$id;
        $timezone=(\Auth::check())?\Auth::user()->timezone:'UTC'; 
        $start=new Carbon(Carbon::now()->format('Y-m-d H:i:s'));
        $end=new Carbon(Carbon::now()->setTimezone($timezone)->format('Y-m-d H:i:s'));
        $diff=$start->diffInHours($end,false);
        $paid_on=$end->subHours($diff);
        $currentdate=$start->subHours($diff);
        $to=$currentdate->addDays($days);

        $description='Deposited Amount For Streaming Package';
        \DB::beginTransaction();
        try {
            $newpayment = new Payments;
            $newpayment->paid_on =$paid_on;
            $newpayment->transaction_id =$transactionid;
            $newpayment->amount =$total_amount;
            $newpayment->ticket_id =$planid;
            $newpayment->description =$description;
            $newpayment->paid_by =$member;
            $newpayment->status ='Success';
            $newpayment->save();
            $updatewallet = new Wallet;
            $updatewallet->ticket_id =$planid;
            $updatewallet->amount_out =0;
            $updatewallet->amount_in =$total_amount;
            $updatewallet->description ='Amount Deposited';
            $updatewallet->owner =$member;
            $updatewallet->status ='Success';
            $updatewallet->save();
            $wallet=Movie::getWalletBal();
            if ($wallet>=$amount) {
                $member_id='';
                $foundmember = Members::where('member',$member)->get()->count();
                if ($foundmember>0) {
                    Members::where('member',$member)->update(['status'=>'Active']);
                    $member_id=Members::where('member',$member)->where('plan',$planid)->get()->first()->id;
                }
                else{
                    $newmember = new Members;
                    $newmember->plan =$id;
                    $newmember->member =$member;
                    $newmember->status ='Active';
                    $newmember->save();
                    $member_id=$newmember->id;
                }
                $updatewallet = new Wallet;
                $updatewallet->ticket_id =$planid;
                $updatewallet->amount_out =$amount;
                $updatewallet->amount_in =0;
                $updatewallet->description ='Paid for Subscription';
                $updatewallet->owner =$member;
                $updatewallet->status ='Success';
                $updatewallet->save();

                $newSubs = new Members_Subs;
                $newSubs->member_plan =$planid;
                $newSubs->member =$member;
                $newSubs->member_id =$member_id;
                $newSubs->paid =$amount;
                $newSubs->to =$to;
                $newSubs->status ='Active';
                $newSubs->save();
                
            echo '
                <div class="bg-warning">Payment Success.<br>
                    Your Subscription Is Active.<br>
                    Thank You.
                </div>';
            }
            else{
                echo '
                    <div class="bg-warning">Payment Unsuccessful.<br>
                        
                        <span class="text-danger">Subscription is Not Paid for.</span><br>
                        Your Wallet Account is less than Required Package Amount.<br>
                        Paybill Number is: <b>123412</b><br>
                        Once Paid, Confirm With Transaction ID Here<br>
                        Thank You.
                    </div>';
            }
            \DB::commit();

        } 
        
        catch(\Illuminate\Database\QueryException $ex){
            \DB::rollback(); 
            echo 'Could not Complete Payment. Error.<br>'. $ex->getMessage();
        }
    }

    public function payPackageAmountWallet($amount,$wallet,$id,$member,$days,$plan)
    {   
        $planid=$id;
        $timezone=(\Auth::check())?\Auth::user()->timezone:'UTC'; 
        $start=new Carbon(Carbon::now()->format('Y-m-d H:i:s'));
        $end=new Carbon(Carbon::now()->setTimezone($timezone)->format('Y-m-d H:i:s'));
        $diff=$start->diffInHours($end,false);
        
        $currentdate=$start->subHours($diff);
        $to=$currentdate->addDays($days);

        $description='Deposited Amount For Streaming Package';
        \DB::beginTransaction();
        try {
            $wallet=Movie::getWalletBal();
            if ($wallet>=$amount) {
                $member_id='';
                $foundmember = Members::where('member',$member)->get()->count();
                if ($foundmember>0) {
                    Members::where('member',$member)->update(['status'=>'Active']);
                    $member_id=Members::where('member',$member)->where('plan',$planid)->get()->first()->id;
                }
                else{
                    $newmember = new Members;
                    $newmember->plan =$id;
                    $newmember->member =$member;
                    $newmember->status ='Active';
                    $newmember->save();
                    $member_id=$newmember->id;
                }
                $updatewallet = new Wallet;
                $updatewallet->ticket_id =$planid;
                $updatewallet->amount_out =$amount;
                $updatewallet->amount_in =0;
                $updatewallet->description ='Paid for Subscription';
                $updatewallet->owner =$member;
                $updatewallet->status ='Success';
                $updatewallet->save();

                $newSubs = new Members_Subs;
                $newSubs->member_plan =$planid;
                $newSubs->member =$member;
                $newSubs->member_id =$member_id;
                $newSubs->paid =$amount;
                $newSubs->to =$to;
                $newSubs->status ='Active';
                $newSubs->save();
                
            echo '
                <div class="bg-warning">Payment Success.<br>
                    Your Subscription Is Active.<br>
                    Thank You.
                </div>';
            }
            else{
                echo '
                    <div class="bg-warning">Payment Unsuccessful.<br>
                        <span class="text-danger">Subscription is Not Paid for.</span><br>
                        Your Wallet Account is less than Required Package Amount.<br>
                        Paybill Number is: <b>123412</b><br>
                        Once Paid, Confirm With Transaction ID Here<br>
                        Thank You.
                    </div>';
            }
            \DB::commit();

        } 
        
        catch(\Illuminate\Database\QueryException $ex){
            \DB::rollback(); 
            echo 'Could not Complete Payment. Error.<br>'. $ex->getMessage();
        }
    }

    public function checkinTicketAccept(Request $request)
    {   
        $ticket_id=$request->input('ticket_id');
        $upcoming=$request->input('upcoming');
        $seat_id=$request->input('seat_id');
        $currentdate=new Carbon(Carbon::now()->format('Y-m-d H:i:s'));

        $section=$this->getSeatStatusID($seat_id);
        $availability=$this->getSeatAvailability($seat_id,$upcoming);
        $ticket_amount=$this->getSeatAmount($section,$upcoming);
        $seat_holder=$this->getSeatHolder($seat_id,$upcoming);
        $seat_holder_name=$this->getSeatHolderName($seat_holder);
        $seat_holder_phone=$this->getSeatHolderPhone($seat_holder);
        $movie_id=$this->getMovieId($upcoming);
        $movie_name=$this->getMovieName($movie_id);
        $screen_id=$this->getScreenId($upcoming);
        $screen_name=$this->getScreenName($screen_id);
        $seat_name=$this->getSeatName($seat_id);
        $sold_on_date=Movie::getTimeInTimezone($this->getSeatSoldOn($seat_id,$upcoming));
        $used_on_date=Movie::getTimeInTimezone($this->getSeatUsedOn($seat_id,$upcoming));
        $ticket_id=$this->getTicketId($seat_id,$upcoming);
        $thisticket=$this->getTicketName($seat_id,$upcoming);
        $status=$this->getTicketStatus($seat_id,$upcoming);
        $sold_on=Movie::getTimeInTimezone($sold_on_date);
        $used_on=Movie::getTimeInTimezone($used_on_date);
        $start_date=$this->getStartDate($upcoming);
        $end_date=$this->getEndDate($upcoming);
        $email=$this->getEmail($seat_holder);
        \DB::beginTransaction();
        try {
            $statuscheck= Tickets::where('id',$ticket_id)->update(['status'=>'Checked','used_on'=>$currentdate]); 
            if ($statuscheck) {
                User::find($seat_holder)->notify(new ClientNotification('Checked In Accepted',$seat_holder,$email,$seat_holder_name,$seat_holder_phone,$movie_id,$movie_name,$screen_id,$screen_name,$upcoming,$seat_id,$seat_name,$section,$ticket_amount,$start_date,$end_date,$ticket_id,$thisticket,'Checked In Accepted','No Wallet',$sold_on,$currentdate,'Ticket Checked In  Accepted Successfully'));
                $admins=User::where('roles','Admin')->where('status','Active')->get();
                foreach ($admins as $admin) {
                    $admin->notify(new ClientNotificationAdmin('Checked In Accepted',$seat_holder,$email,$seat_holder_name,$seat_holder_phone,$movie_id,$movie_name,$screen_id,$screen_name,$upcoming,$seat_id,$seat_name,$section,$ticket_amount,$start_date,$end_date,$ticket_id,$thisticket,'Checked In Accepted','No Wallet',$sold_on,$currentdate,'Ticket Checked In  Accepted Successfully'));
                }
                 echo '
                <div class="bg-success">Check In Accepted Successful.<br>
                    Client can now Get In.<br>
                    Thank You.
                </div>';
            }
            else{
                 echo '
                <div class="bg-warning">Check In Acceptance Failed.<br>
                    Please Try Again.<br>
                    Thank You.
                </div>';
            }
           
            \DB::commit();
        } 
        
        catch(\Illuminate\Database\QueryException $ex){
            \DB::rollback(); 
            echo 'Could not Accept Check in. Error.<br>'. $ex->getMessage();
        }
        catch(\Swift_TransportException $ex){ 
            \DB::rollback();
            echo 'Could not Accept Check in. Error.<br> Please check your Connection.';
        }
    }

    public function checkinTicket(Request $request)
    {   
        $owner=\Auth::user()->id;
        $email=\Auth::user()->email;
        $ticket_id=$request->input('ticket_id');
        $upcoming=$request->input('upcoming');
        $seat_id=$request->input('seat_id');
        $section=$this->getSeatStatusID($seat_id);
        $availability=$this->getSeatAvailability($seat_id,$upcoming);
        $ticket_amount=$this->getSeatAmount($section,$upcoming);
        $seat_holder=$this->getSeatHolder($seat_id,$upcoming);
        $seat_holder_name=$this->getSeatHolderName($seat_holder);
        $seat_holder_phone=$this->getSeatHolderPhone($seat_holder);
        $movie_id=$this->getMovieId($upcoming);
        $movie_name=$this->getMovieName($movie_id);
        $screen_id=$this->getScreenId($upcoming);
        $screen_name=$this->getScreenName($screen_id);
        $seat_name=$this->getSeatName($seat_id);
        $sold_on_date=Movie::getTimeInTimezone($this->getSeatSoldOn($seat_id,$upcoming));
        $used_on_date=Movie::getTimeInTimezone($this->getSeatUsedOn($seat_id,$upcoming));
        $ticket_id=$this->getTicketId($seat_id,$upcoming);
        $thisticket=$this->getTicketName($seat_id,$upcoming);
        $status=$this->getTicketStatus($seat_id,$upcoming);
        $sold_on=Movie::getTimeInTimezone($sold_on_date);
        $used_on=Movie::getTimeInTimezone($used_on_date);
        $start_date=$this->getStartDate($upcoming);
        $end_date=$this->getEndDate($upcoming);

        \DB::beginTransaction();
        try {
            $statuscheck= Tickets::where('id',$ticket_id)->update(['status'=>'Checked']); 
            if ($statuscheck) {
                User::find($owner)->notify(new ClientNotification('Checked In',$owner,$email,$seat_holder_name,$seat_holder_phone,$movie_id,$movie_name,$screen_id,$screen_name,$upcoming,$seat_id,$seat_name,$section,$ticket_amount,$start_date,$end_date,$ticket_id,$thisticket,'Checked In','No Wallet',$sold_on,$used_on,'Ticket Checked In Successfully'));
                $admins=User::where('roles','Admin')->where('status','Active')->get();
                foreach ($admins as $admin) {
                    $admin->notify(new ClientNotificationAdmin('Checked In',$owner,$email,$seat_holder_name,$seat_holder_phone,$movie_id,$movie_name,$screen_id,$screen_name,$upcoming,$seat_id,$seat_name,$section,$ticket_amount,$start_date,$end_date,$ticket_id,$thisticket,'Checked In','No Wallet',$sold_on,$used_on,'Ticket Checked In Successfully'));
                }
                 echo '
                <div class="bg-success">Check In Success.<br>
                    Please Show ticket when Requested.<br>
                    Thank You.
                </div>';
            }
            else{
                 echo '
                <div class="bg-warning">Check In Failed.<br>
                    Please Try Again.<br>
                    Thank You.
                </div>';
            }
           
            \DB::commit();
        } 
        
        catch(\Illuminate\Database\QueryException $ex){
            \DB::rollback(); 
            echo 'Could not Check in. Error.<br>'. $ex->getMessage();
        }
        catch(\Swift_TransportException $ex){ 
            \DB::rollback();
            echo 'Could not Check in. Error.<br> Please check your Connection.';
        }
    }

    public function cancelTicket(Request $request)
    {   
        $owner=\Auth::user()->id;
        $email=\Auth::user()->email;
        $ticket_id=$request->input('ticket_id');
        $upcoming=$request->input('upcoming');
        $seat_id=$request->input('seat_id');
        $section=$this->getSeatStatusID($seat_id);
        $availability=$this->getSeatAvailability($seat_id,$upcoming);
        $ticket_amount=$this->getSeatAmount($section,$upcoming);
        $seat_holder=$this->getSeatHolder($seat_id,$upcoming);
        $seat_holder_name=$this->getSeatHolderName($seat_holder);
        $seat_holder_phone=$this->getSeatHolderPhone($seat_holder);
        $movie_id=$this->getMovieId($upcoming);
        $movie_name=$this->getMovieName($movie_id);
        $screen_id=$this->getScreenId($upcoming);
        $screen_name=$this->getScreenName($screen_id);
        $seat_name=$this->getSeatName($seat_id);
        $sold_on_date=Movie::getTimeInTimezone($this->getSeatSoldOn($seat_id,$upcoming));
        $used_on_date=Movie::getTimeInTimezone($this->getSeatUsedOn($seat_id,$upcoming));
        $ticket_id=$this->getTicketId($seat_id,$upcoming);
        $thisticket=$this->getTicketName($seat_id,$upcoming);
        $status=$this->getTicketStatus($seat_id,$upcoming);
        $sold_on=Movie::getTimeInTimezone($sold_on_date);
        $used_on=Movie::getTimeInTimezone($used_on_date);
        $start_date=$this->getStartDate($upcoming);
        $end_date=$this->getEndDate($upcoming);

        \DB::beginTransaction();
        try {
            $statuscheck= Tickets::where('id',$ticket_id)->update(['status'=>'Canceled']); 
            if ($statuscheck) {
                User::find($owner)->notify(new ClientNotification('Canceled',$owner,$email,$seat_holder_name,$seat_holder_phone,$movie_id,$movie_name,$screen_id,$screen_name,$upcoming,$seat_id,$seat_name,$section,$ticket_amount,$start_date,$end_date,$ticket_id,$thisticket,'Canceled','No Wallet',$sold_on,$used_on,'Ticket Canceled Successfully'));
                $admins=User::where('roles','Admin')->where('status','Active')->get();
                foreach ($admins as $admin) {
                    $admin->notify(new ClientNotificationAdmin('Canceled',$owner,$email,$seat_holder_name,$seat_holder_phone,$movie_id,$movie_name,$screen_id,$screen_name,$upcoming,$seat_id,$seat_name,$section,$ticket_amount,$start_date,$end_date,$ticket_id,$thisticket,'Canceled','No Wallet',$sold_on,$used_on,'Ticket Canceled Successfully'));
                }
                 echo '
                <div class="bg-success">Canceled Successfully.<br>
                    You Can Request for Refund.<br>
                    Thank You.
                </div>';
            }
            else{
                 echo '
                <div class="bg-warning">Canceled Failed.<br>
                    Please Try Again.<br>
                    Thank You.
                </div>';
            }
           
            \DB::commit();
        } 
        
        catch(\Illuminate\Database\QueryException $ex){
            \DB::rollback(); 
            echo 'Could not Cancel in. Error.<br>'. $ex->getMessage();
        }
        catch(\Swift_TransportException $ex){ 
            \DB::rollback();
            echo 'Could not Cancel in. Error.<br> Please check your Connection.'.$ex->getMessage();
        }
    }

    public function getLatestTickets()
    {   
        $this->updateExpiredUnpaid();
        $id=\Auth::user()->id;
        $latesttickets=Tickets::orderByDesc('id')->limit(10)->where('holder',$id)->get();
        foreach ($latesttickets as $ticket) {
            $ticket_id=$ticket->id;
            $status=$ticket->status;
            $thisticket=$ticket->ticket;
            $seat_id=$ticket->seat_no;
            $upcoming=$ticket->upcoming;
            $sold_on=Movie::getTimeInTimezone($ticket->sold_on);
            $used_on=Movie::getTimeInTimezone($ticket->used_on);
            $movie_id=$this->getMovieId($upcoming);
            $movie_name=$this->getMovieName($movie_id);
            $screen_id=$this->getScreenId($upcoming);
            $screen_name=$this->getScreenName($screen_id);
            $condition=$this->getSeatConditionID($seat_id);
            $section=$this->getSeatStatusID($seat_id);
            $seat_name=$this->getSeatName($seat_id);
            $availability=$this->getSeatAvailability($seat_id,$upcoming);
            $ticket_amount=$this->getSeatAmount($section,$upcoming);
            $start_date=$this->getStartDate($upcoming);
            $end_date=$this->getEndDate($upcoming);
            $wallet=Movie::getWalletBal();
            if ($status=='Booked') {
                echo '
                    <div class="p-2 callout callout-info finishticketpayment" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$screen_id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="'.$seat_name.'" data-id7="'.$section.'" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" style="cursor:pointer;">
                        <div>
                          <p class="text-sm p-0 m-0">'.$thisticket.'(<span class="text-info">'.$status.'</span>)</p>
                          <p class="text-xs text-info">Click Here to Complete Payment Kshs.('.$ticket_amount.').</p>
                        </div>
                    </div>
                    ';
            }

            else if ($status=='UnPaid') {
                echo '
                    <div class="p-2 callout callout-danger unpaidticketpayment" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$screen_id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="'.$seat_name.'" data-id7="'.$section.'" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" style="cursor:pointer;">
                        <div>
                          <p class="text-sm p-0 m-0">'.$thisticket.'(<span class="text-danger">'.$status.'</span>)</p>
                          <p class="text-xs text-danger">Payment was not Completed.</p>
                        </div>
                    </div>
                    ';
            }

            else if ($status=='Canceled') {
                echo '
                    <div class="p-2 callout callout-danger cancelledticketpayment" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$screen_id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="'.$seat_name.'" data-id7="'.$section.'" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" style="cursor:pointer;">
                        <div>
                          <p class="text-sm p-0 m-0">'.$thisticket.'(<span class="text-danger">'.$status.'</span>)</p>
                          <p class="text-xs text-danger">Ticket Canceled.</p>
                        </div>
                    </div>
                    ';
            }

            else if ($status=='Reserved') {
                echo '
                    <div class="p-2 callout callout-success reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$screen_id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="'.$seat_name.'" data-id7="'.$section.'" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" style="cursor:pointer;">
                        <div>
                          <p class="text-sm p-0 m-0">'.$thisticket.'(<span class="text-lime">'.$status.'</span>)</p>
                          <p class="text-xs text-lime">Seat Reserved. Please Check In to be Allowed In</p>
                        </div>
                    </div>
                    ';
            }

            else if ($status=='Checked') {
                echo '
                    <div class="p-2 callout callout-success reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$screen_id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="'.$seat_name.'" data-id7="'.$section.'" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" style="cursor:pointer;">
                        <div>
                          <p class="text-sm p-0 m-0">'.$thisticket.'(<span class="text-lime">'.$status.'</span>)</p>
                          <p class="text-xs text-lime">Seat Checked In.</p>
                        </div>
                    </div>
                    ';
            }
         } 
    }

    public function getAllTickets()
    {   
        $this->updateExpiredUnpaid();
        $id=\Auth::user()->id;
        $latesttickets=Tickets::orderByDesc('id')->where('holder',$id)->get();
        foreach ($latesttickets as $ticket) {
            $ticket_id=$ticket->id;
            $status=$ticket->status;
            $thisticket=$ticket->ticket;
            $seat_id=$ticket->seat_no;
            $upcoming=$ticket->upcoming;
            $sold_on=Movie::getTimeInTimezone($ticket->sold_on);
            $used_on=Movie::getTimeInTimezone($ticket->used_on);
            $movie_id=$this->getMovieId($upcoming);
            $movie_name=$this->getMovieName($movie_id);
            $screen_id=$this->getScreenId($upcoming);
            $screen_name=$this->getScreenName($screen_id);
            $condition=$this->getSeatConditionID($seat_id);
            $section=$this->getSeatStatusID($seat_id);
            $seat_name=$this->getSeatName($seat_id);
            $availability=$this->getSeatAvailability($seat_id,$upcoming);
            $ticket_amount=$this->getSeatAmount($section,$upcoming);
            $start_date=$this->getStartDate($upcoming);
            $end_date=$this->getEndDate($upcoming);
            $wallet=Movie::getWalletBal();
            if ($status=='Booked') {
                echo '
                    <div class="col-4 m-0 p-0">
                        <div class="p-1 m-1 callout callout-info finishticketpayment" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$screen_id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="'.$seat_name.'" data-id7="'.$section.'" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" style="cursor:pointer;">
                        <div>
                          <p class="text-sm p-1 m-0 bg-olive" style="border-radius:7px;">'.$thisticket.'(<span class="text-info">'.$status.'</span>)</p>
                          <p class="text-xs text-info">Click Here to Complete Payment Kshs.('.$ticket_amount.').</p>
                        </div>
                    </div></div>
                    ';
            }

            else if ($status=='UnPaid') {
                echo '
                    <div class="col-4 m-0 p-0">
                        <div class="p-1 m-1 callout callout-danger unpaidticketpayment" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$screen_id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="'.$seat_name.'" data-id7="'.$section.'" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" style="cursor:pointer;">
                        <div>
                          <p class="text-sm p-1 m-0 bg-olive" style="border-radius:7px;">'.$thisticket.'(<span class="text-danger">'.$status.'</span>)</p>
                          <p class="text-xs text-danger">Payment was not Completed.</p>
                        </div>
                    </div></div>
                    ';
            }

            else if ($status=='Canceled') {
                echo '
                    <div class="p-2 callout callout-danger cancelledticketpayment" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$screen_id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="'.$seat_name.'" data-id7="'.$section.'" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" style="cursor:pointer;">
                        <div>
                          <p class="text-sm p-1 m-0 bg-olive" style="border-radius:7px;">'.$thisticket.'(<span class="text-danger">'.$status.'</span>)</p>
                          <p class="text-xs text-danger">Ticket Canceled.</p>
                        </div>
                    </div>
                    ';
            }

            else if ($status=='Reserved') {
                echo '
                    <div class="col-4 m-0 p-0">
                        <div class="p-1 m-1 callout callout-success reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$screen_id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="'.$seat_name.'" data-id7="'.$section.'" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" style="cursor:pointer;">
                        <div>
                          <p class="text-sm p-1 m-0 bg-olive" style="border-radius:7px;">'.$thisticket.'(<span class="text-lime">'.$status.'</span>)</p>
                          <p class="text-xs p-1 m-0 text-lime">Seat Reserved. Please Check In to be Allowed In</p>
                          <p class="text-xs p-1 m-0">PLaced ON: '.$sold_on.'.</p>
                        </div>
                    </div></div>
                    ';
            }

            else if ($status=='Checked') {
                echo '
                    <div class="col-4 m-0 p-0">
                        <div class="p-1 m-1 callout callout-success reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$screen_id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="'.$seat_name.'" data-id7="'.$section.'" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" style="cursor:pointer;">
                        <div>
                          <p class="text-sm p-1 m-0 bg-olive" style="border-radius:7px;">'.$thisticket.'(<span class="text-lime">'.$status.'</span>)</p>
                          <p class="text-xs p-1 m-0 text-lime">Seat Checked In.</p>
                          <p class="text-xs p-1 m-0">Accepted In ON: '.$used_on.'.</p>
                        </div>
                    </div></div>
                    ';
            }
         } 
    }

    public function getAllPayments(){
        $id=\Auth::user()->id;
        $mypayments=Payments::orderByDesc('id')->where('paid_by',$id)->get();
        $allpaids=$mypayments->count();
        $output='';
        $sno=0;
        foreach ($mypayments as $payments) {
            $sno++;
            $payment_id=$payments->id;
            $status=$payments->status;
            $transaction_id=$payments->transaction_id;
            $paid_by=$payments->paid_by;
            $amount=$payments->amount;
            $ticket_id=$payments->ticket_id;
            $description=$payments->description;
            $paid_on=$payments->paid_on;
            $paid_at=Movie::getTimeInTimezoneString($paid_on);
            $ticket=$this->getTicketNameByID($ticket_id);
            $payer=Movie::getAccountDetailsName($paid_by);
            
            $output.= '
            <div class="col-md-6 col-sm-6 col-12 p-1 m-0">
                <div class="info-box">
                  <span class="info-box-icon bg-info p-1 m-0 text-sm">Shs. '.$amount.' </span>

                  <div class="info-box-content">
                    <span class="info-box-text">'.$sno.'/'.$allpaids.'. <span class="text-bold">'.$transaction_id.'</span> (<span class="text-xs text-olive">'.$payer.'</span>)</span>
                    <span class="info-box-number">'.$ticket.'</span>
                    <span class="info-box-text text-xs" style="white-space:pre-line;">'.$description.'</span>
                    <span class="info-box-number text-xs text-orange">'.$paid_at.'</span>
                  </div>
                </div>
              </div>';
         } 
            echo $output;
    }

    public function getAllWallets(){
        $id=\Auth::user()->id;
        $mywallets=Wallet::orderByDesc('id')->where('owner',$id)->get();
        $allpaids=$mywallets->count();
        $output='';
        $sno=0;
        foreach ($mywallets as $wallets) {
            $sno++;
            $wallet_id=$wallets->id;
            $status=$wallets->status;
            $amount_in=$wallets->amount_in;
            $amount_out=$wallets->amount_out;
            $owner=$wallets->owner;
            
            $ticket_id=$wallets->ticket_id;
            $description=$wallets->description;
            $status_type='';
            if ($amount_in>0) {
                $amount=$amount_in;
                $status_type='IN';
            }
            else if($amount_out>0) {
                $amount=$amount_out;
                $status_type='OUT';
            }
            $created_at=$wallets->created_at;
            $paid_at=Movie::getTimeInTimezoneString($created_at);
            $ticket=$this->getTicketNameByID($ticket_id);
            $payer=Movie::getAccountDetailsName($owner);
            
            $output.= '
            <div class="col-md-6 col-sm-6 col-12 p-1 m-0">
                <div class="info-box">
                  <span class="info-box-icon bg-olive p-1 m-0 text-sm">Shs. '.$amount.' </span>

                  <div class="info-box-content">
                    <span class="info-box-text">'.$sno.'/'.$allpaids.'. <span class="text-bold">'.$status_type.'</span> (<span class="text-xs text-olive">'.$payer.'</span>)</span>
                    <span class="info-box-number">'.$ticket.'</span>
                    <span class="info-box-text text-xs" style="white-space:pre-line;">'.$description.'</span>
                    <span class="info-box-number text-xs text-orange">'.$paid_at.'</span>
                  </div>
                </div>
              </div>';
         } 
            echo $output;
    }

    public function getAllPaymentsAdmin(){
        $mypayments=Payments::orderByDesc('id')->get();
        $allpaids=$mypayments->count();
        $output='';
        $sno=0;
        foreach ($mypayments as $payments) {
            $sno++;
            $payment_id=$payments->id;
            $status=$payments->status;
            $transaction_id=$payments->transaction_id;
            $paid_by=$payments->paid_by;
            $amount=$payments->amount;
            $ticket_id=$payments->ticket_id;
            $description=$payments->description;
            $paid_on=$payments->paid_on;
            $paid_at=Movie::getTimeInTimezoneString($paid_on);
            $ticket=$this->getTicketNameByID($ticket_id);
            $payer=Movie::getAccountDetailsName($paid_by);
            
            $output.= '
            <div class="col-md-6 col-sm-6 col-12 p-1 m-0">
                <div class="info-box">
                  <span class="info-box-icon bg-info p-1 m-0 text-sm">Shs. '.$amount.' </span>

                  <div class="info-box-content">
                    <span class="info-box-text">'.$sno.'/'.$allpaids.'. <span class="text-bold">'.$transaction_id.'</span> (<span class="text-xs text-olive">'.$payer.'</span>)</span>
                    <span class="info-box-number">'.$ticket.'</span>
                    <span class="info-box-text text-xs" style="white-space:pre-line;">'.$description.'</span>
                    <span class="info-box-number text-xs text-orange">'.$paid_at.'</span>
                  </div>
                </div>
              </div>';
         } 
            echo $output;
    }

    public function getAllWalletsAdmin(){
        $mywallets=Wallet::orderByDesc('id')->get();
        $allpaids=$mywallets->count();
        $output='';
        $sno=0;
        foreach ($mywallets as $wallets) {
            $sno++;
            $wallet_id=$wallets->id;
            $status=$wallets->status;
            $amount_in=$wallets->amount_in;
            $amount_out=$wallets->amount_out;
            $owner=$wallets->owner;
            
            $ticket_id=$wallets->ticket_id;
            $description=$wallets->description;
            $status_type='';
            if ($amount_in>0) {
                $amount=$amount_in;
                $status_type='IN';
            }
            else if($amount_out>0) {
                $amount=$amount_out;
                $status_type='OUT';
            }
            $created_at=$wallets->created_at;
            $paid_at=Movie::getTimeInTimezoneString($created_at);
            $ticket=$this->getTicketNameByID($ticket_id);
            $payer=Movie::getAccountDetailsName($owner);
            
            $output.= '
            <div class="col-md-6 col-sm-6 col-12 p-1 m-0">
                <div class="info-box">
                  <span class="info-box-icon bg-olive p-1 m-0 text-sm">Shs. '.$amount.' </span>

                  <div class="info-box-content">
                    <span class="info-box-text">'.$sno.'/'.$allpaids.'. <span class="text-bold">'.$status_type.'</span> (<span class="text-xs text-olive">'.$payer.'</span>)</span>
                    <span class="info-box-number">'.$ticket.'</span>
                    <span class="info-box-text text-xs" style="white-space:pre-line;">'.$description.'</span>
                    <span class="info-box-number text-xs text-orange">'.$paid_at.'</span>
                  </div>
                </div>
              </div>';
         } 
            echo $output;
    }

    public function getAllRequests()
    {   
        $id=\Auth::user()->id;
        $myrequests=Requests::orderByDesc('id')->where('requested_by',$id)->get();
        $allrequests=$myrequests->count();
        $pendingrequests=0;
        $acceptedrequests=0;
        $cancelledrequests=0;
        $output='';
        foreach ($myrequests as $requests) {
            $request_id=$requests->id;
            $status=$requests->status;
            $request=$requests->request;
            $movie=$requests->movie;
            $movie_requested=$requests->movie_requested;
            $comments=$requests->comments;
            $created_at=$requests->created_at;
            $sent_at=Movie::getTimeInTimezone($created_at);
            $movie_name=$this->getMovieName($movie);
            if ($status=='Requested') {
                $pendingrequests++;
            }
            else if ($status=='Resolved') {
                $acceptedrequests++;
            }
            else if ($status=='Canceled') {
                $cancelledrequests++;
            }
            $output.= '
                <div class="col-4 m-0 p-0">
                    <div class="p-1 m-1 callout callout-success requestedmovie" data-id0="'.$request_id.'" data-id1="'.$movie_requested.'" data-id2="'.$movie.'" data-id3="'.$request.'" data-id4="'.$comments.'" data-id5="'.$status.'" data-id6="'.$sent_at.'" style="cursor:pointer;">
                    <div>
                      <p class="text-sm p-1 m-0 bg-olive" style="border-radius:7px;">'.$movie_requested.'(<span class="text-lime">'.$status.'</span>)</p>
                      <p class="text-xs p-1 m-0 text-lime" style="white-space:pre-line;">'.$request.'</p>
                      <p class="text-xs p-1 m-0">Sent ON: <b>'.$sent_at.'.</b></p>
                      <p class="text-xs p-1 m-0">Movie Name: <b>'.$movie_name.'.</b></p>
                      <p class="text-xs p-1 m-0">Comments: <b>'.$comments.'.</b></p>
                    </div>
                </div></div>
                    ';
         } 
         $stats='<div class="col-12 m-0 p-1 bg-warning text-center"> 
                    <span>Accepted:<b>'.$acceptedrequests.'/'.$allrequests.'</b></span>, 
                    <span>Pending:<b>'.$pendingrequests.'/'.$allrequests.'</b></span>, 
                    <span>Canceled:<b>'.$cancelledrequests.'/'.$allrequests.'</b></span>
                </div>';
            echo $stats;
            echo $output;
    }

    public function getMembership()
    {   
        $id=\Auth::user()->id;
        $output='';
        $wallet=Movie::getWalletBal();
        $myplan=Members::orderByDesc('id')->where('member',$id)->get()->first();
        if ($myplan) {
            $member_plan= $myplan->plan;
            $plan=Members_Plan::orderByDesc('id')->where('id',$member_plan)->where('status','Active')->get()->first();
            $output.= '
                    <div class="col-12 m-0 p-0">
                        <div class="p-1 m-1 callout callout-info" data-id0="'.$id.'" data-id1="'.$plan->id.'" data-id2="'.$plan->plan.'" data-id3="'.$plan->days.'" data-id4="'.$plan->amount.'" data-id5="'.$plan->status.'" data-id6="'.$wallet.'" style="cursor:pointer;">
                        <div>
                          <p class="text-sm p-1 m-0 bg-teal" style="border-radius:7px;">'.$plan->plan.'(<span class="text-white">'.$plan->status.'</span>) for a Period of <b>'.$plan->days.'</b> Days, Amount Paid <b>'.$plan->amount.'  </b> Only.</p>
                          <p class="text-xs p-1 m-0 text-dark" style="white-space:pre-line;">'.$plan->description.'</p>
                        </div>
                        </div>
                    </div>
                ';
            $subs=Members_Subs::where('member',$id)->where('member_plan',$member_plan)->where('status','Active')->get();
            $output.= '<h4>Subscription for this Package.</h4>';
            foreach ($subs as $sub) {
                $output.= '
                    <div class="col-12 m-0 p-0">
                          <p class="text-sm p-1 m-0 bg-orange" style="border-radius:7px;">From: <span class="text-white">'.Movie::getTimeInTimezoneString($sub->created_at).'</span> To: <span class="text-white">'.Movie::getTimeInTimezoneString($sub->to).'</span> </p>
                    </div>
                ';
            }
        }
        else{
            $plans=Members_Plan::where('status','Active')->get();
            $output.= '<h4>Choose your Package Here.</h4>';
            foreach ($plans as $plan) {
                $output.= '
                    <div class="col-12 m-0 p-0">
                        <div class="p-1 m-1 callout callout-info subscribeMembership" data-id0="'.$id.'" data-id1="'.$plan->id.'" data-id2="'.$plan->plan.'" data-id3="'.$plan->days.'" data-id4="'.$plan->amount.'" data-id5="'.$plan->status.'" data-id6="'.$wallet.'" style="cursor:pointer;">
                        <div>
                          <p class="text-sm p-1 m-0 bg-purple" style="border-radius:7px;">'.$plan->plan.'(<span class="text-white">'.$plan->status.'</span>) for a Period of <b>'.$plan->days.'</b> Days, Amount to Pay <b>'.$plan->amount.'  </b> Only. Current Wallet is '.$wallet.' Only.</p>
                          <p class="text-xs p-1 m-0 text-dark" style="white-space:pre-line;">'.$plan->description.'</p>
                        </div>
                        </div>
                    </div>
                ';
            }
        }
        // $myrequests=Requests::orderByDesc('id')->where('requested_by',$id)->get();
        // $allrequests=$myrequests->count();
        // $pendingrequests=0;
        // $acceptedrequests=0;
        // $cancelledrequests=0;
        // $output='';
        // foreach ($myrequests as $requests) {
        //     $request_id=$requests->id;
        //     $status=$requests->status;
        //     $request=$requests->request;
        //     $movie=$requests->movie;
        //     $movie_requested=$requests->movie_requested;
        //     $comments=$requests->comments;
        //     $created_at=$requests->created_at;
        //     $sent_at=Movie::getTimeInTimezone($created_at);
        //     $movie_name=$this->getMovieName($movie);
        //     if ($status=='Requested') {
        //         $pendingrequests++;
        //     }
        //     else if ($status=='Resolved') {
        //         $acceptedrequests++;
        //     }
        //     else if ($status=='Canceled') {
        //         $cancelledrequests++;
        //     }
        //     $output.= '
        //         <div class="col-6 m-0 p-0">
        //             <div class="p-1 m-1 callout callout-success requestedmovie" data-id0="'.$request_id.'" data-id1="'.$movie_requested.'" data-id2="'.$movie.'" data-id3="'.$request.'" data-id4="'.$comments.'" data-id5="'.$status.'" data-id6="'.$sent_at.'" style="cursor:pointer;">
        //             <div>
        //               <p class="text-sm p-1 m-0 bg-orange" style="border-radius:7px;">'.$movie_requested.'(<span class="text-lime">'.$status.'</span>)</p>
        //               <p class="text-xs p-1 m-0 text-lime" style="white-space:pre-line;">'.$request.'</p>
        //               <p class="text-xs p-1 m-0">Sent ON: <b>'.$sent_at.'.</b></p>
        //               <p class="text-xs p-1 m-0">Movie Name: <b>'.$movie_name.'.</b></p>
        //               <p class="text-xs p-1 m-0">Comments: <b>'.$comments.'.</b></p>
        //             </div>
        //         </div></div>
        //             ';
        //  } 
        echo $output;
    }

    

    public function getAllRefundRequests()
    {   
        $id=\Auth::user()->id;
        $myrefundrequests=Refunds::orderByDesc('id')->where('by',$id)->get();
        $allrequests=$myrefundrequests->count();
        $pendingrequests=0;
        $acceptedrequests=0;
        $cancelledrequests=0;
        $output='';
        foreach ($myrefundrequests as $refunds) {
            $refund_id=$refunds->id;
            $status=$refunds->status;
            $reason=$refunds->reason;
            $amount_requested=$refunds->amount_requested;
            $amount_refunded=$refunds->amount_refunded;
            $comments=$refunds->comments;
            $created_at=$refunds->created_at;
            $resolved_on=$refunds->resolved_on;
            $resolved=Movie::getTimeInTimezone($resolved_on);
            $sent_at=Movie::getTimeInTimezone($created_at);
            if ($status=='Requested') {
                $pendingrequests++;
            }
            else if ($status=='Resolved') {
                $acceptedrequests++;
            }
            else if ($status=='Declined') {
                $cancelledrequests++;
            }
            $output.='
                <div class="col-4 m-0 p-0">
                    <div class="p-1 m-1 callout callout-success requestedrefund data-id0="'.$refund_id.'" data-id1="'.$amount_requested.'" data-id2="'.$reason.'" data-id3="'.$amount_refunded.'" data-id4="'.$comments.'" data-id5="'.$status.'" data-id6="'.$sent_at.'" data-id7="'.$resolved.'" style="cursor:pointer;">
                    <div>
                      <p class="text-sm p-1 m-0 bg-olive" style="border-radius:7px;">Refund Requested(<span class="text-lime">'.$status.'</span>)</p>
                      <p class="text-xs p-1 m-0 text-lime" style="white-space:pre-line;">'.$reason.'</p>
                      <p class="text-xs p-1 m-0">Sent ON: <b>'.$sent_at.'.</b></p>
                      <p class="text-xs p-1 m-0">Resolved ON: <b>'.$resolved.'.</b></p>
                      <p class="text-xs p-1 m-0">Amount Requested: <b>'.$amount_requested.'.</b></p>
                      <p class="text-xs p-1 m-0">Amount Refunded: <b>'.$amount_refunded.'.</b></p>
                      <p class="text-xs p-1 m-0">Comments: <b>'.$comments.'.</b></p>
                    </div>
                </div></div>
                    ';
         } 
         $stats='<div class="col-12 m-0 p-1 bg-warning text-center"> 
                    <span>Resolved:<b>'.$acceptedrequests.'/'.$allrequests.'</b></span>, 
                    <span>Requested:<b>'.$pendingrequests.'/'.$allrequests.'</b></span>, 
                    <span>Declined:<b>'.$cancelledrequests.'/'.$allrequests.'</b></span>
                </div>';
            echo $stats;
            echo $output;
    }
    
    public function getAllRequestsAdmin()
    {   
        $myrequests=Requests::orderByDesc('id')->get();
        $allrequests=$myrequests->count();
        $pendingrequests=0;
        $acceptedrequests=0;
        $cancelledrequests=0;
        $output='';
        foreach ($myrequests as $requests) {
            $request_id=$requests->id;
            $status=$requests->status;
            $request=$requests->request;
            $movie=$requests->movie;
            $movie_requested=$requests->movie_requested;
            $comments=$requests->comments;
            $created_at=$requests->created_at;
            $requested_by=$requests->requested_by;
            $sender=Movie::getAccountDetailsName($requested_by);
            $sent_at=Movie::getTimeInTimezone($created_at);
            $movie_name=$this->getMovieName($movie);
            if ($status=='Requested') {
                $pendingrequests++;
            }
            else if ($status=='Resolved') {
                $acceptedrequests++;
            }
            else if ($status=='Canceled') {
                $cancelledrequests++;
            }
            $output.= '
                <div class="col-4 m-0 p-0">
                    <div class="p-1 m-1 callout callout-success requestedmovie" data-id0="'.$request_id.'" data-id1="'.$movie_requested.'" data-id2="'.$movie.'" data-id3="'.$request.'" data-id4="'.$comments.'" data-id5="'.$status.'" data-id6="'.$sent_at.'" style="cursor:pointer;">
                    <div>
                      <p class="text-sm p-1 m-0 bg-olive" style="border-radius:7px;">'.$movie_requested.'(<span class="text-lime">'.$status.'</span>)</p>
                      <p class="text-xs p-1 m-0 text-lime" style="white-space:pre-line;">'.$request.'</p>
                      <p class="text-xs p-1 m-0">Sent By: <b>'.$sender.'.</b></p>
                      <p class="text-xs p-1 m-0">Sent ON: <b>'.$sent_at.'.</b></p>
                      <p class="text-xs p-1 m-0">Movie Name: <b>'.$movie_name.'.</b></p>
                      <p class="text-xs p-1 m-0">Comments: <b>'.$comments.'.</b></p>
                    </div>
                </div></div>
                    ';
         } 
         $stats='<div class="col-12 m-0 p-1 bg-warning text-center"> 
                    <span>Accepted:<b>'.$acceptedrequests.'/'.$allrequests.'</b></span>, 
                    <span>Pending:<b>'.$pendingrequests.'/'.$allrequests.'</b></span>, 
                    <span>Canceled:<b>'.$cancelledrequests.'/'.$allrequests.'</b></span>
                </div>';
            echo $stats;
            echo $output;
    }

    public function getAllRefundRequestsAdmin()
    {   
        $myrefundrequests=Refunds::orderByDesc('id')->get();
        $allrequests=$myrefundrequests->count();
        $pendingrequests=0;
        $acceptedrequests=0;
        $cancelledrequests=0;
        $output='';
        foreach ($myrefundrequests as $refunds) {
            $refund_id=$refunds->id;
            $status=$refunds->status;
            $reason=$refunds->reason;
            $amount_requested=$refunds->amount_requested;
            $amount_refunded=$refunds->amount_refunded;
            $comments=$refunds->comments;
            $created_at=$refunds->created_at;
            $resolved_on=$refunds->resolved_on;
            $by=$refunds->by;
            $sender=Movie::getAccountDetailsName($by);
            $resolved=Movie::getTimeInTimezone($resolved_on);
            $sent_at=Movie::getTimeInTimezone($created_at);
            if ($status=='Requested') {
                $pendingrequests++;
            }
            else if ($status=='Resolved') {
                $acceptedrequests++;
            }
            else if ($status=='Declined') {
                $cancelledrequests++;
            }
            $output.='
                <div class="col-4 m-0 p-0">
                    <div class="p-1 m-1 callout callout-success requestedrefund" data-id0="'.$refund_id.'" data-id1="'.$amount_requested.'" data-id2="'.$reason.'" data-id3="'.$amount_refunded.'" data-id4="'.$comments.'" data-id5="'.$status.'" data-id6="'.$sent_at.'" data-id7="'.$resolved.'" style="cursor:pointer;">
                    <div>
                      <p class="text-sm p-1 m-0 bg-olive" style="border-radius:7px;">Refund Requested(<span class="text-lime">'.$status.'</span>)</p>
                      <p class="text-xs p-1 m-0 text-lime" style="white-space:pre-line;">'.$reason.'</p>
                      <p class="text-xs p-1 m-0">Sent By: <b>'.$sender.'.</b></p>
                      <p class="text-xs p-1 m-0">Sent ON: <b>'.$sent_at.'.</b></p>
                      <p class="text-xs p-1 m-0">Resolved ON: <b>'.$resolved.'.</b></p>
                      <p class="text-xs p-1 m-0">Amount Requested: <b>'.$amount_requested.'.</b></p>
                      <p class="text-xs p-1 m-0">Amount Refunded: <b>'.$amount_refunded.'.</b></p>
                      <p class="text-xs p-1 m-0">Comments: <b>'.$comments.'.</b></p>
                    </div>
                </div></div>
                    ';
         } 
         $stats='<div class="col-12 m-0 p-1 bg-warning text-center"> 
                    <span>Resolved:<b>'.$acceptedrequests.'/'.$allrequests.'</b></span>, 
                    <span>Requested:<b>'.$pendingrequests.'/'.$allrequests.'</b></span>, 
                    <span>Declined:<b>'.$cancelledrequests.'/'.$allrequests.'</b></span>
                </div>';
            echo $stats;
            echo $output;
    }


    public function getScreenUsageMovies($id)
    {   
        $allupcomings=Upcoming::orderByDesc('id')->where('screen',$id)->get();
        $allupcoming=$allupcomings->count();
        $output='';
        $sno=1;
        foreach ($allupcomings as $upcomings) {
            $upcoming_id=$upcomings->id;
            $status=$upcomings->status;
            $screen=$upcomings->screen;
            $movie=$upcomings->movie;
            $release_on=$upcomings->release_on;
            $release_off=$upcomings->release_off;
            $VVIP=$upcomings->VVIP;
            $VIP=$upcomings->VIP;
            $Regular=$upcomings->Regular;
            $Terraces=$upcomings->Terraces;
            $start_date=Movie::getTimeInTimezone($release_on);
            $start_end=Movie::getTimeInTimezone($release_off);
            $movie_name=$this->getMovieName($movie);
            $screen_name=$this->getScreenName($screen);

            $ticket=Movie::getTicketUsageAllAdmin($upcoming_id);
            $ticketused=Movie::getTicketUsageUsedAdmin($upcoming_id);
            $ticketreserved=Movie::getTicketUsageReservedAdmin($upcoming_id);
            $ticketexpired=Movie::getTicketUsageExpiredAdmin($upcoming_id);

            $output.= '
                <div class="col-6 m-0 p-0">
                    <div class="p-1 m-1 callout callout-warning">
                    <div>
                      <p class="text-sm p-1 m-0 bg-olive" style="border-radius:7px;">'.$sno.'/'.$allupcoming.'. '.$movie_name.'<span class="badge badge-light text-dark float-right">'.$status.'</span></p>
                      <p class="text-xs p-1 m-0">Airing From: <b>'.$start_date.'.</b></p>
                      <p class="text-xs p-1 m-0">Airing TO: <b>'.$start_end.'.</b></p>
                      <p class="text-xs p-1 m-0">Tickets: <b>Total:<span class="badge badge-light text-olive">'.$ticket.'</span> Used:<span class="badge badge-light text-olive">'.$ticketused.'</span> Reserved:<span class="badge badge-light text-olive">'.$ticketreserved.'</span> Unused:<span class="badge badge-light text-olive">'.$ticketexpired.'</span></b></p>
                      <p class="text-xs p-1 m-0">Price: <b class="text-xs">VVIP:<span class="badge badge-light text-olive">Shs.'.$VVIP.'</span> VIP:<span class="badge badge-light text-olive">Shs.'.$VIP.'</span> Regular:<span class="badge badge-light text-olive">Shs.'.$Regular.'</span> Terraces:<span class="badge badge-light text-olive">Shs.'.$Terraces.'</span></b></p>
                    </div>
                </div></div>
                    ';
            $sno++;
         } 
            echo $output;
    }
    
    
    public function updateScreenSeats(Request $request)
    {   
        $updatestatus=$request->input('updatestatus');
        $screenidmovieid=$request->input('screenidmovieid');
        \DB::beginTransaction();
        try {
            if($newscreen =Screens::find($screenidmovieid)){
                $seatno=$request->input('seatno');

                $allseats=implode(",", $seatno);
                $eachseatid=explode(",", $allseats);
                foreach ($eachseatid as $seat) {
                    $updateseat = Seats::findOrFail($seat);
                    if ($updatestatus=='VVIP' || $updatestatus=='VIP' || $updatestatus=='Regular' || $updatestatus=='Terraces') {
                        $updateseat->section=$updatestatus;
                    }
                    else if ($updatestatus=='Good' || $updatestatus=='Blocked' || $updatestatus=='Maintenance') {
                        $updateseat->status=$updatestatus;
                    }
                    $updateseat->save();
                }
                \DB::commit();
                return redirect('/admin/screens')->with('success', 'Seat Updated');
            }
            else{

                return redirect('/admin/screens')->with('dbErrorSeat', 'Seat Not Found');
            }
        } 
        
        catch(\Illuminate\Database\QueryException $ex){
            \DB::rollback(); 
            return redirect('/admin/screens')->with('dbErrorSeat', 'Seat Not Updated '. $ex->getMessage());
        }
    }


    public function setUpcoming(Request $request)
    {
        $upcomingmovieid=trim($request->input('upcomingmovieid'));
        if ($upcomingmovieid=='') {
            \DB::beginTransaction();
            try {
            $timezone=(\Auth::check())?\Auth::user()->timezone:'UTC'; 
            $start=new Carbon(Carbon::now()->format('Y-m-d H:i:s'));
            $end=new Carbon(Carbon::now()->setTimezone($timezone)->format('Y-m-d H:i:s'));
            $diff=$start->diffInHours($end,false);

            $timed=$request->input('release_on');
            $timed_off=$request->input('release_off');

            $release_on=new Carbon(Carbon::parse($timed)->setTimezone("UTC")->format('Y-m-d H:i:s'));
            $release_on->subHours($diff);

            $release_off=new Carbon(Carbon::parse($timed_off)->setTimezone("UTC")->format('Y-m-d H:i:s'));
            $release_off->subHours($diff);


            $newupcoming = new Upcoming;
            $newupcoming->movie =$request->input('releasedatemovieid');
            $newupcoming->screen =$request->input('screenair');
            $newupcoming->release_on =$release_on;
            $newupcoming->release_off =$release_off;
            $newupcoming->VVIP =$request->input('VVIP');
            $newupcoming->VIP =$request->input('VIP');
            $newupcoming->Regular =$request->input('Regular');
            $newupcoming->Terraces =$request->input('Terraces');
            $newupcoming->status ='Upcoming';
            $newupcoming->save();
            $movie=$request->input('releasedatemovieid');
                Movie::where('id',$movie)->update(['status'=>'Upcoming']);
                \DB::commit();
                return back()->with('success', 'Upcoming Set');
            } 
            
            catch(\Illuminate\Database\QueryException $ex){
                \DB::rollback(); 
                return back()->with('dbErrorUpcoming', 'Upcoming Not Set'. $ex->getMessage());
            }
        }
        else{

            \DB::beginTransaction();
            try {
                
                $timezone=(\Auth::check())?\Auth::user()->timezone:'UTC'; 
                $start=new Carbon(Carbon::now()->format('Y-m-d H:i:s'));
                $end=new Carbon(Carbon::now()->setTimezone($timezone)->format('Y-m-d H:i:s'));
                $diff=$start->diffInHours($end,false);

                $timed=$request->input('release_on');
                $timed_off=$request->input('release_off');

                $release_on=new Carbon(Carbon::parse($timed)->setTimezone("UTC")->format('Y-m-d H:i:s'));
                $release_on->subHours($diff);

                $release_off=new Carbon(Carbon::parse($timed_off)->setTimezone("UTC")->format('Y-m-d H:i:s'));
                $release_off->subHours($diff);

                if($newupcoming =Upcoming::find($upcomingmovieid)){
                    $newupcoming->screen =$request->input('screenair');
                    $newupcoming->release_on =$release_on;
                    $newupcoming->release_off =$release_off;
                    $newupcoming->VVIP =$request->input('VVIP');
                    $newupcoming->VIP =$request->input('VIP');
                    $newupcoming->Regular =$request->input('Regular');
                    $newupcoming->Terraces =$request->input('Terraces');
                    $newupcoming->save();
                    \DB::commit();
                    return back()->with('success', 'Upcoming Updated');
                }
                else{

                    return back()->with('dbErrorUpcoming', 'Upcoming Not Found');
                }
            } 
            
            catch(\Illuminate\Database\QueryException $ex){
                \DB::rollback(); 
                return back()->with('dbErrorUpcoming', 'Upcoming Not Updated '. $ex->getMessage());
            }
        }
    }

    public function setStream(Request $request)
    {
        $upcomingmoviestreamid=trim($request->input('upcomingmoviestreamid'));
        $stream=trim($request->input('stream'));
        if ($stream!='') {
            try{  
                \DB::beginTransaction();
                if($newupcoming =Upcoming::find($upcomingmoviestreamid)){
                    $newupcoming->stream =$stream;
                    $newupcoming->save();
                    \DB::commit();
                    return back()->with('success', 'Stream Link Updated');
                }
                else{
                    \DB::rollback();
                    return back()->with('dbErrorStreaming', 'Upcoming Not Found');
                }
            }
            catch(\Illuminate\Database\QueryException $ex){
                \DB::rollback(); 
                return back()->with('dbErrorStreaming', 'Could not Cancel in. Error.<br>'. $ex->getMessage());
            }   
        }
        else{
            \DB::beginTransaction();
            return back()->with('dbErrorStreaming', 'Please Specify Stream Link');
        }
    }

    public function uploadThriller(Request $request){
        \DB::beginTransaction();
        try{   
            $movieidthriller=$request->input('movieidthriller');
            if($uploadthrillerfile =Movie::find($movieidthriller)){
                $file = $request->file('file');
                $fileExtension=$file->getClientOriginalExtension();
                $originalName= $this->getMovieName($movieidthriller).'.'.$fileExtension;
                // $originalName= $file->getClientOriginalName(); 
                // $fileType= $file->getClientMimeType(); 
                
                $fileName=$movieidthriller.'_'.$originalName;
                    
                $uploadthrillerfile->status ='Thriller';
                $uploadthrillerfile->thriller =$originalName;
                if($uploadthrillerfile->save()){
                    $upload_success=$file->move(public_path('assets/movies/'),$fileName);
                    \DB::commit();
                    return response()->json(['success'=>'Uploaded '.$fileName]);
                }
                else{
                    \DB::rollback();
                    return response()->json(['error'=>'Not Uploaded '.$fileName]);
                }
            }
            else{
                return response()->json(['error'=>'Not Uploaded']);
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            \DB::rollback(); 
            return response()->json(['error'=>$ex->getMessage()]);
        } 
        catch(\Illuminate\Http\Exceptions\PostTooLargeException $ex){
            \DB::rollback();
            return response()->json(['error'=>$ex->getMessage()]);
        }   
    }

    public function uploadCover(Request $request){
        \DB::beginTransaction();
        try{   
            $movieidcover=$request->input('movieidcover');
            if($uploadthrillerfile =Movie::find($movieidcover)){
                $file = $request->file('file');
                $fileExtension=$file->getClientOriginalExtension();
                $originalName= $this->getMovieName($movieidcover).'.'.$fileExtension;
                // $originalName= $file->getClientOriginalName(); 
                // $fileType= $file->getClientMimeType(); 

                $fileName=$movieidcover.'_Cover_'.$originalName;
                    
                $uploadthrillerfile->cover =$originalName;
                if($uploadthrillerfile->save()){
                    $upload_success=$file->move(public_path('assets/movies/'),$fileName);
                    \DB::commit();
                    return response()->json(['success'=>'Uploaded '.$fileName]);
                }
                else{
                    \DB::rollback();
                    return response()->json(['error'=>'Not Uploaded '.$fileName]);
                }
            }
            else{
                return response()->json(['error'=>'Not Uploaded']);
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            \DB::rollback(); 
            return response()->json(['error'=>$ex->getMessage()]);
        } 
        catch(\Illuminate\Http\Exceptions\PostTooLargeException $ex){
            \DB::rollback();
            return response()->json(['error'=>$ex->getMessage()]);
        }   
    }

    public function getScreens(){
        $screens=Screens::orderByDesc('id')->get();
        return json_encode($screens);
    }

    public function getMovies(){
        $movies=Movie::orderByDesc('id')->get();
        return json_encode($movies);
    }


    public function loadAllMoviesAdmin($type){
        if ($type=='all') {
            $movies=Movie::orderByDesc('id')->limit(20)->get();
            $output='';
            foreach ($movies as $movie) {
                $output.='
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-1 m-0 mb-4">
                        <div class="card text-xs">
                            <div class="row p-0 m-0">
                            <div class="card-body p-0 m-0" >';
                                if($movie->thriller==''){
                                    if($movie->cover==''){
                                        $output.='
                                        <div class="bg-warning p-2 text-center text-sm" > 
                                        <span class="text-xs text-danger">('.$movie->genre.')</span> <b>'.$movie->title.'</b>
                                         <p> <span class="fa fa-exclamation-triangle"></span> No Thriller Uploaded</p>';
                                         $output.='
                                            <button class="btn btn-link text-sm p-1 mb-1 addmoviecover" data-id0="'.$movie->id.'" data-id1="'.$movie->title.'" data-id2="'.$movie->film.'" data-id3="'.$movie->director.'" data-id4="'.$movie->description.'" data-id6="'.$movie->thriller.'" data-id7="'.$movie->cover.'"> <span class="fa fa-image"> Add Cover</span></button>';
                                    }
                                    else{
                                        $fileName=$movie->id.'_Cover_'.$movie->cover;
                                        $output.='
                                        <div class="p-2 text-center text-sm"> 
                                        
                                        <div class="carousel-inner" >
                                            <div class="carousel-item active" style="height:120px;overflow-y:auto;">
                                                <img class="img-fluid" src="'.asset('assets/movies/'.$fileName).'" alt="Image" width="500px">
                                                <div class="carousel-caption" style="margin-bottom:0px;cursor:pointer;" >
                                                <div class="" style="position:relative;font-size:20px;"><b>'.$movie->title.'</b></span></div>
                                                </div>
                                              </div>
                                          </div>

                                        <span class="text-xs text-danger">('.$movie->genre.')</span> <b>'.$movie->title.'</b>
                                         <p> <span class="fa fa-exclamation-triangle"></span> No Thriller Uploaded</p>';
                                        $output.='
                                            <button class="btn btn-link text-sm p-1 mb-1 updatemoviecover" data-id0="'.$movie->id.'" data-id1="'.$movie->title.'" data-id2="'.$movie->film.'" data-id3="'.$movie->director.'" data-id4="'.$movie->description.'" data-id6="'.$movie->thriller.'" data-id7="'.$movie->cover.'"> <span class="fa fa-image"> Update Cover</span></button>';
                                    }
                                    $output.='<button class="btn btn-link text-sm p-1 mb-1 addmoviethriller" data-id0="'.$movie->id.'" data-id1="'.$movie->title.'" data-id2="'.$movie->film.'" data-id3="'.$movie->director.'" data-id4="'.$movie->description.'" data-id6="'.$movie->thriller.'"> <span class="fa fa-film"> Add  Thriller</span></button>
                                        </div>';
                                }
                                else{
                                    if($movie->cover){
                                        $fileName=$movie->id.'_Cover_'.$movie->cover;
                                        $output.='
                                        <div class="p-2 text-center text-sm"> 
                                        
                                        <div class="carousel-inner" >
                                            <div class="carousel-item active" style="height:120px;overflow-y:auto;">
                                                <img class="img-fluid" src="'.asset('assets/movies/'.$fileName).'" alt="Image" width="500px">
                                                <div class="carousel-caption" style="margin-bottom:0px;cursor:pointer;" >
                                                <div class="" style="position:relative;font-size:20px;"><b>'.$movie->title.'</b></span></div>
                                                </div>
                                              </div>
                                          </div>
                                            <span class="text-xs text-danger">('.$movie->genre.')</span> <b>'.$movie->title.'</b>
                                                <p>Thriller Available. </p>';
                                        $output.='
                                            <button class="btn btn-link text-sm p-1 mb-1 updatemoviecover" data-id0="'.$movie->id.'" data-id1="'.$movie->title.'" data-id2="'.$movie->film.'" data-id3="'.$movie->director.'" data-id4="'.$movie->description.'" data-id6="'.$movie->thriller.'" data-id7="'.$movie->cover.'"> <span class="fa fa-image"> Update Cover</span></button>
                                            <button class="btn btn-link text-sm p-1 mb-1 addmoviethriller" data-id0="'.$movie->id.'" data-id1="'.$movie->title.'" data-id2="'.$movie->film.'" data-id3="'.$movie->director.'" data-id4="'.$movie->description.'" data-id6="'.$movie->thriller.'"> <span class="fa fa-film"> Update Thriller</span></button>
                                                <button class="btn btn-link text-sm p-1 mb-1 viewthriller" data-id0="'.$movie->id.'" data-id1="'.$movie->title.'" data-id2="'.$movie->film.'" data-id3="'.$movie->director.'" data-id4="'.$movie->description.'" data-id6="'.$movie->thriller.'"> <span class="fa fa-film"> View Thriller Here</span></button>
                                            </div>';
                                    }
                                    else{
                                        $output.='
                                            <div class="bg-light p-2 text-center text-sm"> 
                                                <span class="text-xs text-danger">('.$movie->genre.')</span> <b>'.$movie->title.'</b>
                                                <p>Thriller Available. </p>';
                                        $output.='
                                            <button class="btn btn-link text-sm p-1 mb-1 addmoviecover" data-id0="'.$movie->id.'" data-id1="'.$movie->title.'" data-id2="'.$movie->film.'" data-id3="'.$movie->director.'" data-id4="'.$movie->description.'" data-id6="'.$movie->thriller.'" data-id7="'.$movie->cover.'"> <span class="fa fa-image"> Add Cover</span></button>
                                            <button class="btn btn-link text-sm p-1 mb-1 addmoviethriller" data-id0="'.$movie->id.'" data-id1="'.$movie->title.'" data-id2="'.$movie->film.'" data-id3="'.$movie->director.'" data-id4="'.$movie->description.'" data-id6="'.$movie->thriller.'"> <span class="fa fa-film"> Update Thriller</span></button>
                                            <button class="btn btn-link text-sm p-1 mb-1 viewthriller" data-id0="'.$movie->id.'" data-id1="'.$movie->title.'" data-id2="'.$movie->film.'" data-id3="'.$movie->director.'" data-id4="'.$movie->description.'" data-id6="'.$movie->thriller.'"> <span class="fa fa-film"> View Thriller Here</span></button>
                                            </div>';
                                    }
                                }
                    $output.='  <b>Film : </b> ('.$movie->film.') <br>
                                <b>Directed : </b>'.$movie->director.'<br>
                                <b class="text-olive"><u>Upcoming Dates for Airing: </u></b>';
                                if($movie->thriller!=''){
                                    $results = Upcoming::where('movie',$movie->id)->get();
                                    $sno=0;
                                    foreach ($results as $result) {
                                        $sno++;
                                        $output.='<br><span class="text-sm text-olive">'.$sno.'</span>. <button class="btn btn-link text-sm p-0 m-1 updatemoviereleasedate" data-id0="'.$movie->id.'" data-id1="'.$movie->title.'" data-id2="'.$movie->film.'" data-id3="'.$movie->director.'" data-id4="'.$movie->description.'" data-id5="'.$result->id.'" title="'.Movie::getTimeForHumans($result->release_on).'">'.Movie::getTimeInTimezone($result->release_on).' (<span class="text-orange">'.$result->status.'</span>) on <span class="text-xs text-olive">'.$this->getScreenName($result->screen).'</span></button>';
                                        $output.='<button class="btn btn-secondary text-sm p-0 m-0 getmovieseat" data-id0="'.$movie->id.'" data-id1="'.$movie->title.'" data-id2="'.$movie->film.'" data-id3="'.$movie->director.'" data-id4="'.$movie->description.'" data-id6="'.$movie->thriller.'" data-id7="'.$result->id.'" data-id8="'.$result->screen.'" title="Booking Seats"> <span class="fa fa-wheelchair"> </span></button>
                                        <button class="btn btn-secondary text-sm p-0 m-0 bookedseatdetails" data-id0="'.$movie->id.'" data-id1="'.$movie->title.'" data-id2="'.$movie->film.'" data-id3="'.$movie->director.'" data-id4="'.$movie->description.'" data-id6="'.$movie->thriller.'" data-id7="'.$result->id.'" data-id8="'.$result->screen.'" data-id9="'.$this->getScreenName($result->screen).'" title="View Tickets and Details"> <span class="fa fa-eye"> </span></button>';
                                        
                                    }
                                }
                    $output.='  </div>';
                    $output.='<div class="card-body col-lg-5 col-md-5 col-sm-5 col-xs-5 p-1 m-0 text-xs elevation-1">
                                <b>Description </b> <br>
                                <span class="" style="white-space:pre-line;">
                                    '.$movie->description.'
                                </span>
                            </div></div>';
                    $output.='<div class="bg-light p-1 text-center text-xs elevation-1"> 
                                <button class="btn btn-dark text-sm p-0 pr-1 pl-1 mb-1 updatemovie" data-id0="'.$movie->id.'" data-id1="'.$movie->title.'" data-id2="'.$movie->film.'" data-id3="'.$movie->director.'" data-id4="'.$movie->description.'"><span class="fa fa-edit"></span></button>
                                <button class="btn btn-danger text-sm p-0 pr-1 pl-1 mb-1 deletemovie" data-id0="'.$movie->id.'" data-id1="'.$movie->title.'" data-id2="'.$movie->film.'" data-id3="'.$movie->director.'" data-id4="'.$movie->description.'"><span class="fa fa-trash"></span></button>';

                               if($movie->thriller!=''){
                                    $output.='<button class="btn btn-warning text-sm p-0 pr-1 pl-1 mb-1 m-1 addmoviereleasedate" data-id0="'.$movie->id.'" data-id1="'.$movie->title.'" data-id2="'.$movie->film.'" data-id3="'.$movie->director.'" data-id4="'.$movie->description.'"><span class="fa fa-clock text-orange"> </span> Upcoming On</button>';
                                }
                    $output.='</div>
                </div>
            </div>';
            }
            echo $output;
        }

        else if ($type=='upcoming') {
            $movies=Upcoming::orderByDesc('id')->limit(20)->where('status','Upcoming')->get();
            $output='';
            foreach ($movies as $movie) {
                $output.='
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-1 m-0 mb-4">
                        <div class="card text-xs">
                            <div class="row p-0 m-0">
                            <div class="ribbon-wrapper m-1">
                                <div class="ribbon bg-success text-xs">
                                    <span class="fa fa-clock"></span><br>
                                  <b class="text-light text-xs">Upcoming</b>
                                </div>
                            </div>
                            <div class="card-body p-0 m-0">';
                                if($this->getMovieThriller($movie->movie)==''){
                                    if($this->getMovieCover($movie->movie)){
                                        $fileName=$movie->movie.'_Cover_'.$this->getMovieCover($movie->movie);
                                        $output.='
                                        <div class="p-2 text-center text-sm"> 
                                        
                                        <div class="carousel-inner" >
                                            <div class="carousel-item active" style="height:120px;overflow-y:auto;">
                                                <img class="img-fluid" src="'.asset('assets/movies/'.$fileName).'" alt="Image" width="500px">
                                                <div class="carousel-caption" style="margin-bottom:0px;cursor:pointer;" >
                                                <div class="" style="position:relative;font-size:20px;"><b>'.$movie->title.'</b></span></div>
                                                </div>
                                              </div>
                                          </div>';
                                        
                                    }
                                    else{
                                        $output.='
                                        <div class="bg-warning p-2 text-center text-sm">';
                                    }
                                     $output.='
                                        <span class="text-xs text-danger">('.$this->getMovieGenre($movie->movie).')</span> <b>'.$this->getMovieName($movie->movie).'</b>
                                         <p> <span class="fa fa-exclamation-triangle"></span> No Thriller Uploaded</p>
                                            <button class="btn btn-link text-sm p-1 mb-1 addmoviethriller" data-id0="'.$movie->movie.'" data-id1="'.$this->getMovieName($movie->movie).'" data-id2="'.$this->getMovieFilm($movie->movie).'" data-id3="'.$this->getMovieDirector($movie->movie).'" data-id4="'.$this->getMovieDescription($movie->movie).'" data-id6="'.$this->getMovieThriller($movie->movie).'"> <span class="fa fa-film"> Add  Thriller</span></button>
                                        </div>';
                                }
                                else{
                                    if($this->getMovieCover($movie->movie)){
                                        $fileName=$movie->movie.'_Cover_'.$this->getMovieCover($movie->movie);
                                        $output.='
                                        <div class="p-2 text-center text-sm"> 
                                        
                                        <div class="carousel-inner" >
                                            <div class="carousel-item active" style="height:120px;overflow-y:auto;">
                                                <img class="img-fluid" src="'.asset('assets/movies/'.$fileName).'" alt="Image" width="500px">
                                                <div class="carousel-caption" style="margin-bottom:0px;cursor:pointer;" >
                                                <div class="" style="position:relative;font-size:20px;"><b>'.$movie->title.'</b></span></div>
                                                </div>
                                              </div>
                                          </div>';
                                        
                                    }
                                    else{
                                        $output.='
                                        <div class="bg-light p-2 text-center text-sm">';
                                    }

                                    $output.=' 
                                            <span class="text-xs text-danger">('.$this->getMovieGenre($movie->movie).')</span> <b>'.$this->getMovieName($movie->movie).'</b>
                                            <p>Thriller Available. </p>
                                            <button class="btn btn-link text-sm p-1 mb-1 viewthriller" data-id0="'.$movie->movie.'" data-id1="'.$this->getMovieName($movie->movie).'" data-id2="'.$this->getMovieFilm($movie->movie).'" data-id3="'.$this->getMovieDirector($movie->movie).'" data-id4="'.$this->getMovieDescription($movie->movie).'" data-id6="'.$this->getMovieThriller($movie->movie).'"> <span class="fa fa-film"> View Thriller Here</span></button>
                                        </div>';
                                }
                    $output.='  <b>Film : </b> ('.$this->getMovieFilm($movie->movie).') <br>
                                <b>Directed : </b>'.$this->getMovieDirector($movie->movie).'<br>
                                <b class="text-olive"><u>Upcoming Date for Airing: </u></b>';
                                if($this->getMovieThriller($movie->movie)!=''){
                                    $output.='<br><button class="btn btn-link text-sm p-0 m-1 updatemoviereleasedate" data-id0="'.$movie->movie.'" data-id1="'.$this->getMovieName($movie->movie).'" data-id2="'.$this->getMovieFilm($movie->movie).'" data-id3="'.$this->getMovieDirector($movie->movie).'" data-id4="'.$this->getMovieDescription($movie->movie).'" data-id5="'.$movie->id.'" title="'.Movie::getTimeForHumans($movie->release_on).'">'.Movie::getTimeInTimezone($movie->release_on).' (<span class="text-orange">'.$movie->status.'</span>) on <span class="text-xs text-olive">'.$this->getScreenName($movie->screen).'</span></button>';
                                        $output.='<button class="btn btn-secondary text-sm p-0 m-0 getmovieseat" data-id0="'.$movie->movie.'" data-id1="'.$this->getMovieName($movie->movie).'" data-id2="'.$this->getMovieFilm($movie->movie).'" data-id3="'.$this->getMovieDirector($movie->movie).'" data-id4="'.$this->getMovieDescription($movie->movie).'" data-id6="'.$this->getMovieThriller($movie->movie).'" data-id7="'.$movie->id.'" data-id8="'.$movie->screen.'" title="Booking Seats"> <span class="fa fa-wheelchair"> </span></button>
                                        <button class="btn btn-secondary text-sm p-0 m-0 bookedseatdetails" data-id0="'.$movie->movie.'" data-id1="'.$this->getMovieName($movie->movie).'" data-id2="'.$this->getMovieFilm($movie->movie).'" data-id3="'.$this->getMovieDirector($movie->movie).'" data-id4="'.$this->getMovieDescription($movie->movie).'" data-id6="'.$this->getMovieThriller($movie->movie).'" data-id7="'.$movie->id.'" data-id8="'.$movie->screen.'" data-id9="'.$this->getScreenName($movie->screen).'" title="View Tickets and Details"> <span class="fa fa-eye"> </span></button>';
                                    
                                }
                    $output.='  </div>';
                    $output.='<div class="card-body col-lg-5 col-md-5 col-sm-5 col-xs-5 p-1 m-0 text-xs elevation-1">
                                <b>Description </b> <br>
                                <span class="" style="white-space:pre-line;">
                                    '.$this->getMovieDescription($movie->movie).'
                                </span>
                            </div></div>';
                    
                    $output.='
                </div>
            </div>';
            }
            echo $output;
        }

        else if ($type=='onair') {
            $movies=Upcoming::orderByDesc('id')->limit(20)->where('status','Airing')->orWhere('status','Live')->get();
            $output='';
            foreach ($movies as $movie) {
                $output.='
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-1 m-0 mb-4">
                        <div class="card text-xs">
                            <div class="row p-0 m-0">
                            <div class="ribbon-wrapper m-1">
                                <div class="ribbon bg-orange text-xs">
                                    <span class="fa fa-microphone text-lime"></span><br>
                                  <b class="text-light text-xs">'.$movie->status.'</b>
                                </div>
                            </div>
                            <div class="card-body p-0 m-0">';
                                if($this->getMovieThriller($movie->movie)==''){
                                    if($this->getMovieCover($movie->movie)){
                                        $fileName=$movie->movie.'_Cover_'.$this->getMovieCover($movie->movie);
                                        $output.='
                                        <div class="p-2 text-center text-sm"> 
                                        
                                        <div class="carousel-inner" >
                                            <div class="carousel-item active" style="height:120px;overflow-y:auto;">
                                                <img class="img-fluid" src="'.asset('assets/movies/'.$fileName).'" alt="Image" width="500px">
                                                <div class="carousel-caption" style="margin-bottom:0px;cursor:pointer;" >
                                                <div class="" style="position:relative;font-size:20px;"><b>'.$movie->title.'</b></span></div>
                                                </div>
                                              </div>
                                          </div>';
                                        
                                    }
                                    else{
                                        $output.='
                                        <div class="bg-warning p-2 text-center text-sm">';
                                    }

                                     $output.='
                                        <span class="text-xs text-danger">('.$this->getMovieGenre($movie->movie).')</span> <b>'.$this->getMovieName($movie->movie).'</b>
                                         <p> <span class="fa fa-exclamation-triangle"></span> No Thriller Uploaded</p>
                                            <button class="btn btn-link text-sm p-1 mb-1 addmoviethriller" data-id0="'.$movie->movie.'" data-id1="'.$this->getMovieName($movie->movie).'" data-id2="'.$this->getMovieFilm($movie->movie).'" data-id3="'.$this->getMovieDirector($movie->movie).'" data-id4="'.$this->getMovieDescription($movie->movie).'" data-id6="'.$this->getMovieThriller($movie->movie).'"> <span class="fa fa-film"> Add  Thriller</span></button>
                                        </div>';
                                }
                                else{
                                    if($this->getMovieCover($movie->movie)){
                                        $fileName=$movie->movie.'_Cover_'.$this->getMovieCover($movie->movie);
                                        $output.='
                                        <div class="p-2 text-center text-sm"> 
                                        
                                        <div class="carousel-inner" >
                                            <div class="carousel-item active" style="height:120px;overflow-y:auto;">
                                                <img class="img-fluid" src="'.asset('assets/movies/'.$fileName).'" alt="Image" width="500px">
                                                <div class="carousel-caption" style="margin-bottom:0px;cursor:pointer;" >
                                                <div class="" style="position:relative;font-size:20px;"><b>'.$movie->title.'</b></span></div>
                                                </div>
                                              </div>
                                          </div>';
                                        
                                    }
                                    else{
                                        $output.='
                                        <div class="bg-light p-2 text-center text-sm">';
                                    }
                                    $output.='
                                            <span class="text-xs text-danger">('.$this->getMovieGenre($movie->movie).')</span> <b>'.$this->getMovieName($movie->movie).'</b>
                                            <p>Thriller Available. </p>
                                            <button class="btn btn-link text-sm p-1 mb-1 viewthriller" data-id0="'.$movie->movie.'" data-id1="'.$this->getMovieName($movie->movie).'" data-id2="'.$this->getMovieFilm($movie->movie).'" data-id3="'.$this->getMovieDirector($movie->movie).'" data-id4="'.$this->getMovieDescription($movie->movie).'" data-id6="'.$this->getMovieThriller($movie->movie).'"> <span class="fa fa-film"> View Thriller Here</span></button>
                                        </div>';
                                }
                    $output.='  <b>Film : </b> ('.$this->getMovieFilm($movie->movie).') <br>
                                <b>Directed : </b>'.$this->getMovieDirector($movie->movie).'<br>
                                <b class="text-olive"><u>Upcoming Date for Airing: </u></b>';
                                if($this->getMovieThriller($movie->movie)!=''){
                                    $output.='<br><button class="btn btn-link text-sm p-0 m-1 updatemoviereleasedate" data-id0="'.$movie->movie.'" data-id1="'.$this->getMovieName($movie->movie).'" data-id2="'.$this->getMovieFilm($movie->movie).'" data-id3="'.$this->getMovieDirector($movie->movie).'" data-id4="'.$this->getMovieDescription($movie->movie).'" data-id5="'.$movie->id.'" title="'.Movie::getTimeForHumans($movie->release_on).'">'.Movie::getTimeInTimezone($movie->release_on).' (<span class="text-orange">'.$movie->status.'</span>) on <span class="text-xs text-olive">'.$this->getScreenName($movie->screen).'</span></button>';
                                        $output.='<button class="btn btn-secondary text-sm p-0 m-0 getmovieseat" data-id0="'.$movie->movie.'" data-id1="'.$this->getMovieName($movie->movie).'" data-id2="'.$this->getMovieFilm($movie->movie).'" data-id3="'.$this->getMovieDirector($movie->movie).'" data-id4="'.$this->getMovieDescription($movie->movie).'" data-id6="'.$this->getMovieThriller($movie->movie).'" data-id7="'.$movie->id.'" data-id8="'.$movie->screen.'" title="Booking Seats"> <span class="fa fa-wheelchair"> </span></button>
                                        <button class="btn btn-secondary text-sm p-0 m-0 bookedseatdetails" data-id0="'.$movie->movie.'" data-id1="'.$this->getMovieName($movie->movie).'" data-id2="'.$this->getMovieFilm($movie->movie).'" data-id3="'.$this->getMovieDirector($movie->movie).'" data-id4="'.$this->getMovieDescription($movie->movie).'" data-id6="'.$this->getMovieThriller($movie->movie).'" data-id7="'.$movie->id.'" data-id8="'.$movie->screen.'" data-id9="'.$this->getScreenName($movie->screen).'" title="View Tickets and Details"> <span class="fa fa-eye"> </span></button>';
                                        if($movie->status=='Live' || $movie->status=='Airing'){
                                            if ($movie->stream) {
                                                $output.='<button class="btn btn-secondary text-sm p-0 m-1 updatemoviestream" data-id0="'.$movie->id.'" data-id1="'.$this->getMovieName($movie->movie).'" data-id2="'.$this->getMovieFilm($movie->movie).'" data-id3="'.$this->getMovieDirector($movie->movie).'" data-id4="'.$this->getMovieDescription($movie->movie).'" data-id6="'.$movie->stream.'" data-id5="'.$movie->movie.'"  title="Update Movie Stream Link"> <span class="fa fa-film"> Link </span></button>';
                                            }
                                            else{
                                                $output.='<button class="btn btn-secondary text-sm p-0 m-1 addmoviestream" data-id0="'.$movie->id.'" data-id1="'.$this->getMovieName($movie->movie).'" data-id2="'.$this->getMovieFilm($movie->movie).'" data-id3="'.$this->getMovieDirector($movie->movie).'" data-id4="'.$this->getMovieDescription($movie->movie).'" data-id5="'.$movie->movie.'" title="Add Movie Stream Link"> <span class="fa fa-film"> Add Link </span></button>';
                                            }
                                        }
                                }
                    $output.='  </div>';
                    $output.='<div class="card-body col-lg-5 col-md-5 col-sm-5 col-xs-5 p-1 m-0 text-xs elevation-1">
                                <b>Description </b> <br>
                                <span class="" style="white-space:pre-line;">
                                    '.$this->getMovieDescription($movie->movie).'
                                </span>
                            </div></div>';
                    
                    $output.='
                </div>
            </div>';
            }
            echo $output;
        }

        else if ($type=='ticketsales') {
            $movies=Upcoming::orderByDesc('id')->limit(50)->get();
            $output='';
            foreach ($movies as $movie) {
                $upcoming_id=$movie->id;
                $movie_id=$movie->movie;
                $screen_id=$movie->screen;
                $VVIP=$movie->VVIP;
                $VIP=$movie->VIP;
                $Regular=$movie->Regular;
                $Terraces=$movie->Terraces;
                $movie_name=$this->getMovieName($movie_id);
                $screen_name=$this->getScreenName($screen_id);

                $ticket=Movie::getTicketUsageAllAdmin($upcoming_id);
                $ticketused=Movie::getTicketUsageUsedAdmin($upcoming_id);
                $ticketreserved=Movie::getTicketUsageReservedAdmin($upcoming_id);
                $ticketexpired=Movie::getTicketUsageExpiredAdmin($upcoming_id);

                $totalseats=$this->getScreenCapacity($screen_id);
                $totalseatsactive=$this->getUpcomingSeatsActive($screen_id);
                $totalseatsblocked=$this->getUpcomingSeatsBlocked($screen_id);
                $totalseatsused=$this->getUpcomingSeatsUsed($upcoming_id);

                $seatsVVIP=$this->getUpcomingSeatsVVIP($upcoming_id);
                $seatsVIP=$this->getUpcomingSeatsVIP($upcoming_id);
                $seatsRegular=$this->getUpcomingSeatsRegular($upcoming_id);
                $seatsTerraces=$this->getUpcomingSeatsTerraces($upcoming_id);

                $earningsVVIP=$seatsVVIP*$VVIP;
                $earningsVIP=$seatsVIP*$VIP;
                $earningsRegular=$seatsRegular*$Regular;
                $earningsTerraces=$seatsTerraces*$Terraces;

                $totalearnings=$earningsVVIP+$earningsVIP+$earningsRegular+$earningsTerraces;


                $output.='
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-1 m-0 mb-4">
                        <div class="card text-xs">
                            <div class="row p-0 m-0">
                            <div class="ribbon-wrapper m-1">
                                <div class="ribbon bg-olive text-xs">
                                  <b class="text-light text-xs">'.$movie->status.'</b>
                                </div>
                            </div>
                            <div class="card-body p-0 m-0">';
                                 $output.='
                                    <div class="bg-light p-2 text-sm"> 
                                        <b>Movie : </b><span class="text-xs text-danger">('.$this->getMovieGenre($movie->movie).')</span> <b>'.$this->getMovieName($movie->movie).'</b><br>
                                        <b>Film : </b> ('.$this->getMovieFilm($movie->movie).') <br>
                                        <b>Directed : </b>'.$this->getMovieDirector($movie->movie).'<br>
                                    </div>';
                                    $output.='  ';
                                    $output.='
                                        <p class="text-xs p-1 m-0">On Screen: <b>'.$screen_name.'.</b></p>
                                        <p class="text-xs p-1 m-0">Airing From: <b>'.Movie::getTimeInTimezone($movie->release_on).'.</b></p>
                                        <p class="text-xs p-1 m-0">Airing TO: <b>'.Movie::getTimeInTimezone($movie->release_off).'.</b></p>
                                        <p class="text-xs p-1 m-0">Tickets: <b>Total:<span class="badge badge-light text-olive">'.$ticket.'</span> Used:<span class="badge badge-light text-olive">'.$ticketused.'</span> Reserved:<span class="badge badge-light text-olive">'.$ticketreserved.'</span> Unused:<span class="badge badge-light text-olive">'.$ticketexpired.'</span></b></p>
                                        <p class="text-xs p-1 m-0">Price: <b class="text-xs">VVIP:<span class="badge badge-light text-olive">Shs.'.$VVIP.'</span> VIP:<span class="badge badge-light text-olive">Shs.'.$VIP.'</span> Regular:<span class="badge badge-light text-olive">Shs.'.$Regular.'</span> Terraces:<span class="badge badge-light text-olive">Shs.'.$Terraces.'</span></b></p>';
                                
                    
                                if($this->getMovieThriller($movie->movie)!=''){
                                        $output.='<button class="btn btn-secondary text-sm p-0 m-1 getmovieseat" data-id0="'.$movie->movie.'" data-id1="'.$this->getMovieName($movie->movie).'" data-id2="'.$this->getMovieFilm($movie->movie).'" data-id3="'.$this->getMovieDirector($movie->movie).'" data-id4="'.$this->getMovieDescription($movie->movie).'" data-id6="'.$this->getMovieThriller($movie->movie).'" data-id7="'.$movie->id.'" data-id8="'.$movie->screen.'" title="Booking Seats"> <span class="fa fa-wheelchair"> Booked Seats</span></button>
                                        <button class="btn btn-secondary text-sm p-0 m-1 bookedseatdetails" data-id0="'.$movie->movie.'" data-id1="'.$this->getMovieName($movie->movie).'" data-id2="'.$this->getMovieFilm($movie->movie).'" data-id3="'.$this->getMovieDirector($movie->movie).'" data-id4="'.$this->getMovieDescription($movie->movie).'" data-id6="'.$this->getMovieThriller($movie->movie).'" data-id7="'.$movie->id.'" data-id8="'.$movie->screen.'" data-id9="'.$this->getScreenName($movie->screen).'" title="View Tickets and Details"> <span class="fa fa-eye"> Booked Seats Details </span></button>';
                                    
                                }
                    $output.='  </div>';
                    $output.='<div class="card-body col-lg-5 col-md-5 col-sm-5 col-xs-5 p-1 m-0 text-xs elevation-1">   
                                <p class="text-xs p-1 m-0">Seats: <b>Total:<span class="badge badge-light text-olive">'.$totalseats.'</span> Active:<span class="badge badge-light text-olive">'.$totalseatsactive.'</span> Blocked:<span class="badge badge-light text-olive">'.$totalseatsblocked.'</span> Used:<span class="badge badge-light text-olive">'.$totalseatsused.'</span></b></p>
                                <b class="text-orange p-1">Reserved or Booked Seats per Section:</b>
                                <p class="text-xs p-1 m-0"><b class="text-xs">VVIP:<span class="badge badge-light text-olive">'.$seatsVVIP.'</span> VIP:<span class="badge badge-light text-olive">'.$seatsVIP.'</span> Regular:<span class="badge badge-light text-olive">'.$seatsRegular.'</span> Terraces:<span class="badge badge-light text-olive">'.$seatsTerraces.'</span></b></p>
                                <b class="text-orange p-1">Earnings Per Section:</b>
                                <p class="text-xs p-1 m-0"> <b class="text-xs">VVIP:<span class="badge badge-light float-right text-olive">Shs.'.$earningsVVIP.'</span></b></p>
                                <p class="text-xs p-1 m-0"> <b class="text-xs">VIP:<span class="badge badge-light float-right text-olive">Shs.'.$earningsVIP.'</span></b></p>
                                <p class="text-xs p-1 m-0"> <b class="text-xs">Regular:<span class="badge badge-light float-right text-olive">Shs.'.$earningsRegular.'</span></b></p>
                                <p class="text-xs p-1 m-0"> <b class="text-xs">Terraces:<span class="badge badge-light float-right text-olive">Shs.'.$earningsTerraces.'</span></b></p>
                                <p class="text-xs p-1 m-0"> <b class="text-xs">Total Earnings:<span class="badge badge-light float-right text-olive">Shs.'.$totalearnings.'</span></b></p>
                            </div></div>';
                    
                    $output.='
                </div>
            </div>';
            }
            echo $output;
        }
        
        // return json_encode($movies);
    }

    public function loadAllMovies($type){
        if ($type=='all') {
            $movies=Movie::orderByDesc('id')->limit(20)->get();
            $output='';
            foreach ($movies as $movie) {
                $output.='
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-1 m-0 mb-4">
                        <div class="card text-xs">
                            <div class="row p-0 m-0">
                            <div class="card-body p-0 m-0">';
                                if($movie->thriller==''){
                                    if($movie->cover){
                                        $fileName=$movie->id.'_Cover_'.$movie->cover;
                                        $output.='
                                        <div class="text-danger p-2 text-center text-sm"> 
                                        
                                        <div class="carousel-inner" >
                                            <div class="carousel-item active" style="height:120px;overflow-y:auto;">
                                                <img class="img-fluid" src="'.asset('assets/movies/'.$fileName).'" alt="Image" width="400px">
                                                <div class="carousel-caption" style="margin-bottom:0px;cursor:pointer;" >
                                                <div class="" style="position:relative;font-size:20px;"><b>'.$movie->title.'</b></span></div>
                                                </div>
                                              </div>
                                          </div>';
                                    }
                                    else{
                                        $output.='
                                        <div class="text-danger p-2 text-center text-sm">';
                                    }
                                     $output.='
                                        <span class="text-xs text-danger">('.$movie->genre.')</span> <b>'.$movie->title.'</b>
                                         <p> <span class="fa fa-exclamation-triangle"></span> No Thriller Uploaded</p>
                                            
                                        </div>';
                                }
                                else{
                                    if($movie->cover){
                                        $fileName=$movie->id.'_Cover_'.$movie->cover;
                                        $output.='
                                        <div class="p-2 text-center text-sm"> 
                                        
                                        <div class="carousel-inner" >
                                            <div class="carousel-item active" style="height:120px;overflow-y:auto;">
                                                <img class="img-fluid" src="'.asset('assets/movies/'.$fileName).'" alt="Image" width="400px">
                                                <div class="carousel-caption" style="margin-bottom:0px;cursor:pointer;" >
                                                <div class="" style="position:relative;font-size:20px;"><b>'.$movie->title.'</b></span></div>
                                                </div>
                                              </div>
                                          </div>';
                                    }
                                    else{
                                        $output.='
                                        <div class="bg-light p-2 text-center text-sm"> ';
                                    }
                                    $output.='
                                            <span class="text-xs text-danger">('.$movie->genre.')</span> <b>'.$movie->title.'</b>
                                            <p>Thriller Available. </p>
                                            <button class="btn btn-link text-sm p-1 mb-1 viewthriller" data-id0="'.$movie->id.'" data-id1="'.$movie->title.'" data-id2="'.$movie->film.'" data-id3="'.$movie->director.'" data-id4="'.$movie->description.'" data-id6="'.$movie->thriller.'"> <span class="fa fa-film"> View Thriller Here</span></button>
                                        </div>';
                                }
                    $output.='  <b>Filmed By : </b> ('.$movie->film.') <br>
                                <b>Directed By : </b>'.$movie->director.'<br>
                                <b class="text-olive"><u>Upcoming Dates for Airing: </u></b>';
                                if($movie->thriller!=''){
                                    $results = Upcoming::where('movie',$movie->id)->get();
                                    $sno=0;
                                    foreach ($results as $result) {
                                        $sno++;
                                        $output.='
                                        <p class="text-sm p-1 m-0"> <b class="text-sm">'.Movie::getTimeInTimezoneString($result->release_on).'(<span class="text-orange">'.$result->status.' on '.$this->getScreenName($result->screen).'</span>)<span class="badge badge-light float-right text-dark">'; 
                                        if ($result->status=='Live' || $result->status=='Airing' || $result->status=='Upcoming') {
                                            $output.='<button class="btn btn-link text-sm p-0 m-0 getmovieseat" data-id0="'.$movie->id.'" data-id1="'.$movie->title.'" data-id2="'.$movie->film.'" data-id3="'.$movie->director.'" data-id4="'.$movie->description.'" data-id6="'.$movie->thriller.'" data-id7="'.$result->id.'" data-id8="'.$result->screen.'" title="Booking Seats"> <span class="fa fa-wheelchair"> Book Seat</span></button>';
                                        }
                                        
                                        $output.='</b></p>';
                                    }
                                }
                    $output.='  </div>';
                    $output.='<div class="card-body col-lg-5 col-md-5 col-sm-5 col-xs-5 p-1 m-0 text-xs elevation-1">
                                <b>Description </b> <br>
                                <span class="" style="white-space:pre-line;">
                                    '.$movie->description.'
                                </span>
                            </div></div>';
                    $output.='<div class="bg-light p-1 text-center text-xs elevation-1">';
                                $output.='
                                <button class="btn btn-secondary text-sm p-0 pr-1 pl-1 mb-1 m-1 requestmovie" data-id0="'.$movie->id.'" data-id1="'.$movie->title.'" data-id2="'.$movie->film.'" data-id3="'.$movie->director.'" data-id4="'.$movie->description.'" data-id6="'.$movie->thriller.'"> <span class="fa fa-wheelchair"> Request Movie</span></button>';
                    $output.='</div>
                </div>
            </div>';
            }
            echo $output;
        }

        else if ($type=='upcoming') {
            $movies=Upcoming::orderByDesc('id')->limit(20)->where('status','Upcoming')->get();
            $output='';
            foreach ($movies as $movie) {
                $output.='
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-1 m-0 mb-4">
                        <div class="card text-xs">
                            <div class="row p-0 m-0">
                            <div class="ribbon-wrapper m-1">
                                <div class="ribbon bg-success text-xs">
                                    <span class="fa fa-clock"></span><br>
                                  <b class="text-light text-xs">Upcoming</b>
                                </div>
                            </div>
                            <div class="card-body p-0 m-0">';
                                if($this->getMovieThriller($movie->movie)==''){
                                    if($this->getMovieCover($movie->movie)){
                                        $fileName=$movie->movie.'_Cover_'.$this->getMovieCover($movie->movie);
                                        $output.='
                                        <div class="text-danger p-2 text-center text-sm"> 
                                        
                                        <div class="carousel-inner" >
                                            <div class="carousel-item active" style="height:120px;overflow-y:auto;">
                                                <img class="img-fluid" src="'.asset('assets/movies/'.$fileName).'" alt="Image" width="400px">
                                                <div class="carousel-caption" style="margin-bottom:0px;cursor:pointer;" >
                                                <div class="" style="position:relative;font-size:20px;"><b>'.$movie->title.'</b></span></div>
                                                </div>
                                              </div>
                                          </div>';
                                        
                                    }
                                    else{
                                        $output.='
                                        <div class="text-danger p-2 text-center text-sm">';
                                    }

                                     $output.='
                                        <span class="text-xs text-danger">('.$this->getMovieGenre($movie->movie).')</span> <b>'.$this->getMovieName($movie->movie).'</b>
                                         <p> <span class="fa fa-exclamation-triangle"></span> No Thriller Uploaded</p>
                                            
                                        </div>';
                                }
                                else{
                                    if($this->getMovieCover($movie->movie)){
                                        $fileName=$movie->movie.'_Cover_'.$this->getMovieCover($movie->movie);
                                        $output.='
                                        <div class="p-2 text-sm"> 
                                        
                                        <div class="carousel-inner" >
                                            <div class="carousel-item active" style="height:120px;overflow-y:auto;">
                                                <img class="img-fluid" src="'.asset('assets/movies/'.$fileName).'" alt="Image" width="400px">
                                                <div class="carousel-caption" style="margin-bottom:0px;cursor:pointer;" >
                                                <div class="" style="position:relative;font-size:20px;"><b>'.$movie->title.'</b></span></div>
                                                </div>
                                              </div>
                                          </div>';
                                        
                                    }
                                    else{
                                        $output.='
                                        <div class="bg-light p-2 text-sm">';
                                    }
                                    $output.='
                                            <p class="text-sm p-1 m-0"> <b class="text-sm">Movie: <span class="text-sm  text-danger">('.$this->getMovieGenre($movie->movie).')</span><span class="badge badge-light float-right text-dark"> <b class="text-sm">'.$this->getMovieName($movie->movie).'</b></b></p>
                                            <p class="text-sm p-1 m-0"> <b class="text-sm">Filmed By:<span class="badge badge-light float-right text-dark"> <b class="text-sm">'.$this->getMovieFilm($movie->movie).'</b></b></p>
                                            <p class="text-sm p-1 m-0"> <b class="text-sm">Directed By:<span class="badge badge-light float-right text-dark"> <b class="text-sm">'.$this->getMovieDirector($movie->movie).'</b></b></p>
                                            <button class="btn btn-link text-sm p-1 mb-1 viewthriller" data-id0="'.$movie->movie.'" data-id1="'.$this->getMovieName($movie->movie).'" data-id2="'.$this->getMovieFilm($movie->movie).'" data-id3="'.$this->getMovieDirector($movie->movie).'" data-id4="'.$this->getMovieDescription($movie->movie).'" data-id6="'.$this->getMovieThriller($movie->movie).'"> <span class="fa fa-film"> View Thriller Here</span></button>
                                        </div>';
                                }
                                if($this->getMovieThriller($movie->movie)!=''){
                                    $output.='
                                        <p class="text-sm p-1 m-0"> <b class="text-sm">Airing FROM: <span class="badge badge-light float-right text-olive">'.Movie::getTimeInTimezoneString($movie->release_on).'</span></b></p>
                                        <p class="text-sm p-1 m-0"> <b class="text-sm">Airing TO <span class="badge badge-light float-right text-olive">'.Movie::getTimeInTimezoneString($movie->release_off).'</span></b></p>
                                        <p class="text-sm p-1 m-0"> <b class="text-sm">ON Screen <span class="badge badge-light float-right text-olive">'.$this->getScreenName($movie->screen).'</span></b></p>
                                        <p class="text-sm p-1 m-0">Price: <b class="text-sm">VVIP:<span class="badge badge-light text-olive">Shs.'.$movie->VVIP.'</span> VIP:<span class="badge badge-light text-olive">Shs.'.$movie->VIP.'</span> Regular:<span class="badge badge-light text-olive">Shs.'.$movie->Regular.'</span> Terraces:<span class="badge badge-light text-olive">Shs.'.$movie->Terraces.'</span></b></p>';
                                    
                                }
                    $output.='  </div>';
                    $output.='<div class="card-body col-lg-5 col-md-5 col-sm-5 col-xs-5 p-1 m-0 text-xs elevation-1">
                                <b>Description </b> <br>
                                <span class="" style="white-space:pre-line;">
                                    '.$this->getMovieDescription($movie->movie).'
                                </span>
                            </div></div>';
                    
                    $output.='<div class="bg-light p-1 text-center text-xs elevation-1"> ';
                                if($this->getMovieThriller($movie->movie)!=''){
                                        $output.='
                                        <button class="btn btn-secondary text-sm p-0 pr-1 pl-1 mb-1 m-1 getmovieseat" data-id0="'.$movie->movie.'" data-id1="'.$this->getMovieName($movie->movie).'" data-id2="'.$this->getMovieFilm($movie->movie).'" data-id3="'.$this->getMovieDirector($movie->movie).'" data-id4="'.$this->getMovieDescription($movie->movie).'" data-id6="'.$this->getMovieThriller($movie->movie).'" data-id7="'.$movie->id.'" data-id8="'.$movie->screen.'" title="Booking Seats"> <span class="fa fa-wheelchair"> Book Seat </span></button>
                                        ';
                                    
                                }
                    $output.='</div>
                </div>
            </div>';
            }
            echo $output;
        }

        else if ($type=='onair') {
            $movies=Upcoming::orderByDesc('id')->limit(20)->where('status','Airing')->orWhere('status','Live')->get();
            $output='';
            foreach ($movies as $movie) {
                $output.='
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-1 m-0 mb-4">
                        <div class="card text-xs">
                            <div class="row p-0 m-0">
                            <div class="ribbon-wrapper m-1">
                                <div class="ribbon bg-orange text-xs">
                                    <span class="fa fa-microphone text-lime"></span><br>
                                  <b class="text-light text-xs">'.$movie->status.'</b>
                                </div>
                            </div>
                            <div class="card-body p-0 m-0">';
                                if($this->getMovieThriller($movie->movie)==''){
                                    if($this->getMovieCover($movie->movie)){
                                        $fileName=$movie->movie.'_Cover_'.$this->getMovieCover($movie->movie);
                                        $output.='
                                        <div class="text-danger p-2 text-center text-sm"> 
                                        
                                        <div class="carousel-inner" >
                                            <div class="carousel-item active" style="height:120px;overflow-y:auto;">
                                                <img class="img-fluid" src="'.asset('assets/movies/'.$fileName).'" alt="Image" width="400px">
                                                <div class="carousel-caption" style="margin-bottom:0px;cursor:pointer;" >
                                                <div class="" style="position:relative;font-size:20px;"><b>'.$movie->title.'</b></span></div>
                                                </div>
                                              </div>
                                          </div>';
                                        
                                    }
                                    else{
                                        $output.='
                                        <div class="text-danger p-2 text-center text-sm">';
                                    }
                                     $output.='
                                        <span class="text-xs text-danger">('.$this->getMovieGenre($movie->movie).')</span> <b>'.$this->getMovieName($movie->movie).'</b>
                                         <p> <span class="fa fa-exclamation-triangle"></span> No Thriller Uploaded</p>
                                            
                                        </div>';
                                }
                                else{
                                    if($this->getMovieCover($movie->movie)){
                                        $fileName=$movie->movie.'_Cover_'.$this->getMovieCover($movie->movie);
                                        $output.='
                                        <div class="p-2 text-center text-sm"> 
                                        
                                        <div class="carousel-inner" >
                                            <div class="carousel-item active" style="height:120px;overflow-y:auto;">
                                                <img class="img-fluid" src="'.asset('assets/movies/'.$fileName).'" alt="Image" width="400px">
                                                <div class="carousel-caption" style="margin-bottom:0px;cursor:pointer;" >
                                                <div class="" style="position:relative;font-size:20px;"><b>'.$movie->title.'</b></span></div>
                                                </div>
                                              </div>
                                          </div>';
                                        
                                    }
                                    else{
                                        $output.='
                                        <div class="bg-light p-2 text-sm">';
                                    }
                                    $output.='
                                            <p class="text-sm p-1 m-0"> <b class="text-sm">Movie: <span class="text-sm  text-danger">('.$this->getMovieGenre($movie->movie).')</span><span class="badge badge-light float-right text-dark"> <b class="text-sm">'.$this->getMovieName($movie->movie).'</b></b></p>
                                            <p class="text-sm p-1 m-0"> <b class="text-sm">Filmed By:<span class="badge badge-light float-right text-dark"> <b class="text-sm">'.$this->getMovieFilm($movie->movie).'</b></b></p>
                                            <p class="text-sm p-1 m-0"> <b class="text-sm">Directed By:<span class="badge badge-light float-right text-dark"> <b class="text-sm">'.$this->getMovieDirector($movie->movie).'</b></b></p>
                                            <button class="btn btn-link text-sm p-1 mb-1 viewthriller" data-id0="'.$movie->movie.'" data-id1="'.$this->getMovieName($movie->movie).'" data-id2="'.$this->getMovieFilm($movie->movie).'" data-id3="'.$this->getMovieDirector($movie->movie).'" data-id4="'.$this->getMovieDescription($movie->movie).'" data-id6="'.$this->getMovieThriller($movie->movie).'"> <span class="fa fa-film"> View Thriller Here</span></button>';
                                            if ($movie->stream) {
                                                $output.='<button class="btn btn-link  text-sm p-1 mb-1" data-id0="'.$movie->movie.'" data-id1="'.$this->getMovieName($movie->movie).'" data-id2="'.$this->getMovieFilm($movie->movie).'" data-id3="'.$this->getMovieDirector($movie->movie).'" data-id4="'.$this->getMovieDescription($movie->movie).'" data-id6="'.$this->getMovieThriller($movie->movie).'" data-id7="'.$movie->stream.'"> <span class="fa fa-film text-orange"> Stream Available</span></button>';
                                            }
                                    
                                    $output.='</div>';
                                }
                                if($this->getMovieThriller($movie->movie)!=''){
                                    $output.='
                                        <p class="text-sm p-1 m-0"> <b class="text-sm">Airing FROM: <span class="badge badge-light float-right text-olive">'.Movie::getTimeInTimezoneString($movie->release_on).'</span></b></p>
                                        <p class="text-sm p-1 m-0"> <b class="text-sm">Airing TO <span class="badge badge-light float-right text-olive">'.Movie::getTimeInTimezoneString($movie->release_off).'</span></b></p>
                                        <p class="text-sm p-1 m-0"> <b class="text-sm">ON Screen <span class="badge badge-light float-right text-olive">'.$this->getScreenName($movie->screen).'</span></b></p>
                                        <p class="text-sm p-1 m-0">Price: <b class="text-sm">VVIP:<span class="badge badge-light text-olive">Shs.'.$movie->VVIP.'</span> VIP:<span class="badge badge-light text-olive">Shs.'.$movie->VIP.'</span> Regular:<span class="badge badge-light text-olive">Shs.'.$movie->Regular.'</span> Terraces:<span class="badge badge-light text-olive">Shs.'.$movie->Terraces.'</span></b></p>';
                                    
                                }
                    $output.='  </div>';
                    $output.='<div class="card-body col-lg-5 col-md-5 col-sm-5 col-xs-5 p-1 m-0 text-xs elevation-1">
                                <b>Description </b> <br>
                                <span class="" style="white-space:pre-line;">
                                    '.$this->getMovieDescription($movie->movie).'
                                </span>
                            </div></div>';
                    
                    $output.='<div class="bg-light p-1 text-center text-xs elevation-1"> ';
                                if($this->getMovieThriller($movie->movie)!=''){
                                        $output.='
                                        <button class="btn btn-secondary text-sm p-0 pr-1 pl-1 mb-1 m-1 getmovieseat" data-id0="'.$movie->movie.'" data-id1="'.$this->getMovieName($movie->movie).'" data-id2="'.$this->getMovieFilm($movie->movie).'" data-id3="'.$this->getMovieDirector($movie->movie).'" data-id4="'.$this->getMovieDescription($movie->movie).'" data-id6="'.$this->getMovieThriller($movie->movie).'" data-id7="'.$movie->id.'" data-id8="'.$movie->screen.'" title="Booking Seats"> <span class="fa fa-wheelchair"> Book Seat </span></button>
                                        ';
                                    
                                }
                    $output.='</div>
                </div>
            </div>';
            }
            echo $output;
        }
    }

    public static function getScreenUsage($screen){
        return$screenusage=Upcoming::where('screen',$screen)->count();
    }

    public static function setSeats($id){
        $screens=Screens::orderByDesc('id')->where('id',$id)->get();
        $capacity=$screens[0]->capacity;
        $rowsleft=$screens[0]->rowsleft;
        $rowscenter=$screens[0]->rowscenter;
        $rowsright=$screens[0]->rowsright;
        $rowseats=$rowsleft+$rowscenter+$rowsright;
        $rows=intdiv($capacity,$rowseats);
        $tsrow=1;
        $rowlen=1;
        $output='';
        for ($i=1; $i <= $capacity; $i++) { 
            $seat='';
            if ($tsrow<=$rowsleft) {
                $seat=$id.'_R'.$rowlen.'L'.$tsrow;
            }
            else if ($tsrow<=($rowsleft+$rowscenter)) {
                $seat=$id.'_R'.$rowlen.'C'.$tsrow;
            }
            else if ($tsrow<=($rowsleft+$rowscenter+$rowsright)) {
                $seat=$id.'_R'.$rowlen.'R'.$tsrow;
            }
            if($seat!=''){
                $newseat = new Seats;
                $newseat->seat =$seat;
                $newseat->screen =$id;
                $newseat->section ='Regular';
                $newseat->status ='Good';
                $newseat->save();
            }

            if ($tsrow<$rowseats) {
                $tsrow++;
            }
            else{
                $tsrow=1;
                $rowlen++;
                continue;
            }
        }
    }

    public function getSeats($id){
        $this->updateExpiredUnpaid();
        $screens=Screens::orderByDesc('id')->where('id',$id)->get();
        $capacity=$screens[0]->capacity;
        $rowsleft=$screens[0]->rowsleft;
        $rowscenter=$screens[0]->rowscenter;
        $rowsright=$screens[0]->rowsright;
        $rowseats=$rowsleft+$rowscenter+$rowsright;
        $rows=intdiv($capacity,$rowseats);
        $seatsextra=($capacity%$rowseats);
        $tsrow=1;
        $rowlen=1;
        $output='';
        $data='';
        $datalen=$capacity-$seatsextra;
        $output.='<table border="1" class="table text-xs">';
        for ($i=1; $i <= $capacity; $i++) { 
            //check for Good(Available),Not Available(Maintenamce), Blocked(), VVIP,VIP,Regular,Terraces
            if ($tsrow<=$rowsleft) {
                $leftcolumn=$id.'_R'.$rowlen.'L'.$tsrow;
                $condition=$this->getSeatCondition($leftcolumn);
                $section=$this->getSeatStatus($leftcolumn);
                if ($condition=='Blocked' || $condition=='Maintenance') {
                    if ($section=='VVIP') {
                        $data.='<td class="ticket-div p-1 text-xs bg-danger text-lime" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                    }
                    else if ($section=='VIP') {
                        $data.='<td class="ticket-div p-1 text-xs bg-danger text-pink" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                    }
                    else if ($section=='Terraces') {
                        $data.='<td class="ticket-div p-1 text-xs bg-danger text-warning" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                    }
                    else{
                        $data.='<td class="ticket-div p-1 text-xs bg-danger text-dark" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                    }
                }
                else{
                    if ($section=='VVIP') {
                        $data.='<td class="ticket-div p-1 text-xs bg-light text-lime" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                    }
                    else if ($section=='VIP') {
                        $data.='<td class="ticket-div p-1 text-xs bg-light text-pink" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                    }
                    else if ($section=='Terraces') {
                        $data.='<td class="ticket-div p-1 text-xs bg-light text-warning" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                    }
                    else{
                        $data.='<td class="ticket-div p-1 text-xs bg-light text-dark" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                    }
                }
            }
            else if ($tsrow<=($rowsleft+$rowscenter)) {
                $centercolumn=$id.'_R'.$rowlen.'C'.$tsrow;
                $condition=$this->getSeatCondition($centercolumn);
                $section=$this->getSeatStatus($centercolumn);
                if ($condition=='Blocked' || $condition=='Maintenance') {
                    if ($section=='VVIP') {
                        $data.='<td class="ticket-div p-1 text-xs bg-danger text-lime" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                    }
                    else if ($section=='VIP') {
                        $data.='<td class="ticket-div p-1 text-xs bg-danger text-pink" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                    }
                    else if ($section=='Terraces') {
                        $data.='<td class="ticket-div p-1 text-xs bg-danger text-warning" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                    }
                    else{
                        $data.='<td class="ticket-div p-1 text-xs bg-danger text-dark" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                    }
                }
                else{
                    if ($section=='VVIP') {
                        $data.='<td class="ticket-div p-1 text-xs bg-light text-lime" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                    }
                    else if ($section=='VIP') {
                        $data.='<td class="ticket-div p-1 text-xs bg-light text-pink" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                    }
                    else if ($section=='Terraces') {
                        $data.='<td class="ticket-div p-1 text-xs bg-light text-warning" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                    }
                    else{
                        $data.='<td class="ticket-div p-1 text-xs bg-light text-dark" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                    }
                }
            }
            else if ($tsrow<=($rowsleft+$rowscenter+$rowsright)) {
                $rightcolumn=$id.'_R'.$rowlen.'R'.$tsrow;
                $condition=$this->getSeatCondition($rightcolumn);
                $section=$this->getSeatStatus($rightcolumn);
                if ($condition=='Blocked' || $condition=='Maintenance') {
                    if ($section=='VVIP') {
                        $data.='<td class="ticket-div p-1 text-xs bg-danger text-lime" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                    }
                    else if ($section=='VIP') {
                        $data.='<td class="ticket-div p-1 text-xs bg-danger text-pink" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                    }
                    else if ($section=='Terraces') {
                        $data.='<td class="ticket-div p-1 text-xs bg-danger text-warning" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                    }
                    else{
                        $data.='<td class="ticket-div p-1 text-xs bg-danger text-dark" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                    }
                }
                else{
                    if ($section=='VVIP') {
                        $data.='<td class="ticket-div p-1 text-xs bg-light text-lime" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                    }
                    else if ($section=='VIP') {
                        $data.='<td class="ticket-div p-1 text-xs bg-light text-pink" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                    }
                    else if ($section=='Terraces') {
                        $data.='<td class="ticket-div p-1 text-xs bg-light text-warning" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                    }
                    else{
                        $data.='<td class="ticket-div p-1 text-xs bg-light text-dark" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                    }
                }
            }

            if ($tsrow==$rowsleft) {
                $data.='<td style="min-width:40px;border:none;"></td>';
            }
            else if ($tsrow==($rowsleft+$rowscenter)) {
                $data.='<td style="min-width:40px;border:none;"></td>';
            }
            
            if ($tsrow<$rowseats) {
                $tsrow++;
            }
            else{
                $tsrow=1;
                $rowlen++;
                $output.='<tr>';
                $output.=$data;
                $output.='</tr>';
                $data='';
                continue;
            }
        }

        $extradata='<tr>';
        $rowlen=$rows+1;
        for ($i=1; $i <= $seatsextra; $i++) { 
            if ($i<=$rowsleft) {
                $leftcolumn=$id.'_R'.$rowlen.'L'.($i);
                $condition=$this->getSeatCondition($leftcolumn);
                $section=$this->getSeatStatus($leftcolumn);
                if ($condition=='Blocked' || $condition=='Maintenance') {
                    if ($section=='VVIP') {
                        $extradata.='<td class="ticket-div p-1 text-xs bg-danger text-lime" style="cursor:pointer">'.'R'.$rowlen.'L'.($i).'</td>';
                    }
                    else if ($section=='VIP') {
                        $extradata.='<td class="ticket-div p-1 text-xs bg-danger text-pink" style="cursor:pointer">'.'R'.$rowlen.'L'.($i).'</td>';
                    }
                    else if ($section=='Terraces') {
                        $extradata.='<td class="ticket-div p-1 text-xs bg-danger text-warning" style="cursor:pointer">'.'R'.$rowlen.'L'.($i).'</td>';
                    }
                    else{
                        $extradata.='<td class="ticket-div p-1 text-xs bg-danger text-dark" style="cursor:pointer">'.'R'.$rowlen.'L'.($i).'</td>';
                    }
                }
                else{
                    if ($section=='VVIP') {
                        $extradata.='<td class="ticket-div p-1 text-xs bg-light text-lime" style="cursor:pointer">'.'R'.$rowlen.'L'.($i).'</td>';
                    }
                    else if ($section=='VIP') {
                        $extradata.='<td class="ticket-div p-1 text-xs bg-light text-pink" style="cursor:pointer">'.'R'.$rowlen.'L'.($i).'</td>';
                    }
                    else if ($section=='Terraces') {
                        $extradata.='<td class="ticket-div p-1 text-xs bg-light text-warning" style="cursor:pointer">'.'R'.$rowlen.'L'.($i).'</td>';
                    }
                    else{
                        $extradata.='<td class="ticket-div p-1 text-xs bg-light text-dark" style="cursor:pointer">'.'R'.$rowlen.'L'.($i).'</td>';
                    }
                }
            }
            else if ($i<=($rowsleft+$rowscenter)) {
                $centercolumn=$id.'_R'.$rowlen.'C'.($i);
                $condition=$this->getSeatCondition($centercolumn);
                $section=$this->getSeatStatus($centercolumn);
                if ($condition=='Blocked' || $condition=='Maintenance') {
                    if ($section=='VVIP') {
                        $extradata.='<td class="ticket-div p-1 text-xs bg-danger text-lime" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                    }
                    else if ($section=='VIP') {
                        $extradata.='<td class="ticket-div p-1 text-xs bg-danger text-pink" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                    }
                    else if ($section=='Terraces') {
                        $extradata.='<td class="ticket-div p-1 text-xs bg-danger text-warning" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                    }
                    else{
                        $extradata.='<td class="ticket-div p-1 text-xs bg-danger text-dark" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                    }
                }
                else{
                    if ($section=='VVIP') {
                        $extradata.='<td class="ticket-div p-1 text-xs bg-light text-lime" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                    }
                    else if ($section=='VIP') {
                        $extradata.='<td class="ticket-div p-1 text-xs bg-light text-pink" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                    }
                    else if ($section=='Terraces') {
                        $extradata.='<td class="ticket-div p-1 text-xs bg-light text-warning" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                    }
                    else{
                        $extradata.='<td class="ticket-div p-1 text-xs bg-light text-dark" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                    }
                }
            }
            else if ($i<=($rowsleft+$rowscenter+$rowsright)) {
                $rightcolumn=$id.'_R'.$rowlen.'R'.($i);
                $condition=$this->getSeatCondition($rightcolumn);
                $section=$this->getSeatStatus($rightcolumn);
                if ($condition=='Blocked' || $condition=='Maintenance') {
                    if ($section=='VVIP') {
                        $extradata.='<td class="ticket-div p-1 text-xs bg-danger text-lime" style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'</td>';
                    }
                    else if ($section=='VIP') {
                        $extradata.='<td class="ticket-div p-1 text-xs bg-danger text-pink" style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'</td>';
                    }
                    else if ($section=='Terraces') {
                        $extradata.='<td class="ticket-div p-1 text-xs bg-danger text-warning" style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'</td>';
                    }
                    else{
                        $extradata.='<td class="ticket-div p-1 text-xs bg-danger text-dark" style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'</td>';
                    }
                }
                else{
                    if ($section=='VVIP') {
                        $extradata.='<td class="ticket-div p-1 text-xs bg-light text-lime" style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'</td>';
                    }
                    else if ($section=='VIP') {
                        $extradata.='<td class="ticket-div p-1 text-xs bg-light text-pink" style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'</td>';
                    }
                    else if ($section=='Terraces') {
                        $extradata.='<td class="ticket-div p-1 text-xs bg-light text-warning" style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'</td>';
                    }
                    else{
                        $extradata.='<td class="ticket-div p-1 text-xs bg-light text-dark" style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'</td>';
                    }
                }
            }

            if ($i==$rowsleft) {
                $extradata.='<td style="min-width:40px;border:none;"></td>';
            }
            else if ($i==($rowsleft+$rowscenter)) {
                $extradata.='<td style="min-width:40px;border:none;"></td>';
            }
        }
        $extradata.='</tr>';
        $output.=$extradata;
        $output.='</table>';
        echo $output;
    }

    public function getClientSeats($id,$upcoming){
        if (!Auth::check()) {
            return redirect('login');
        }
        $holder=\Auth::user()->id;
        $this->updateExpiredUnpaid();
        $wallet=Movie::getWalletBal();
        $screens=Screens::orderByDesc('id')->where('id',$id)->get();
        $movie_id=$this->getMovieId($upcoming);
        $movie_name=$this->getMovieName($movie_id);
        $screen_name=$screens[0]->screen;
        $capacity=$screens[0]->capacity;
        $rowsleft=$screens[0]->rowsleft;    
        $rowscenter=$screens[0]->rowscenter;
        $rowsright=$screens[0]->rowsright;
        $rowseats=$rowsleft+$rowscenter+$rowsright;
        $rows=intdiv($capacity,$rowseats);
        $seatsextra=($capacity%$rowseats);
        $tsrow=1;
        $rowlen=1;
        $output='';
        $data='';
        $datalen=$capacity-$seatsextra;
        $output.='<table border="1" class="table seatTable text-xs">';
        for ($i=1; $i <= $capacity; $i++) { 
            //check for Good(Available),Not Available(Maintenamce), Blocked(), VVIP,VIP,Regular,Terraces
            if ($tsrow<=$rowsleft) {
                $leftcolumn=$id.'_R'.$rowlen.'L'.$tsrow;
                $seat_id=$this->getSeatId($leftcolumn);
                $condition=$this->getSeatCondition($leftcolumn);
                $section=$this->getSeatStatus($leftcolumn);
                $availability=$this->getSeatAvailability($seat_id,$upcoming);
                $ticket_amount=$this->getSeatAmount($section,$upcoming);
                $seat_holder=$this->getSeatHolder($seat_id,$upcoming);
                $start_date=$this->getStartDate($upcoming);
                $end_date=$this->getEndDate($upcoming);
                if ($condition=='Blocked' || $condition=='Maintenance') {
                    if ($section=='VVIP') {
                        $data.='<td class="p-1 tdHover text-xs bg-danger text-lime" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                    }
                    else if ($section=='VIP') {
                        $data.='<td class="p-1 tdHover text-xs bg-danger text-pink" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                    }
                    else if ($section=='Terraces') {
                        $data.='<td class="p-1 tdHover text-xs bg-danger text-warning" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                    }
                    else{
                        $data.='<td class="p-1 tdHover text-xs bg-danger text-dark" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                    }
                }
                else{
                    if ($availability=='Available'  || $availability=='UnPaid' || $availability=='' || $availability=='Canceled') {
                        if ($section=='VVIP') {
                            $data.='<td class="p-1 tdHover text-xs text-lime bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'L'.$tsrow.'" data-id7="VVIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'"  data-id11="'.$wallet.'" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                        }
                        else if ($section=='VIP') {
                            $data.='<td class="p-1 tdHover text-xs text-pink bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'L'.$tsrow.'" data-id7="VIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'"  data-id11="'.$wallet.'" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                        }
                        else if ($section=='Terraces') {
                            $data.='<td class="p-1 tdHover text-xs text-warning bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'L'.$tsrow.'" data-id7="Terraces" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'"  data-id11="'.$wallet.'" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                        }
                        else{
                            $data.='<td class="p-1 tdHover text-xs text-dark bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'L'.$tsrow.'" data-id7="Regular" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'"  data-id11="'.$wallet.'" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                        }
                    }
                    else if ($availability=='Booked' || $availability=='Reserved' || $availability=='Checked') {
                        if ($seat_holder==$holder) {
                            if ($section=='VVIP') {
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-lime" style="cursor:pointer">ME</td>';
                            }
                            else if ($section=='VIP') {
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-pink" style="cursor:pointer">ME</td>';
                            }
                            else if ($section=='Terraces') {
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-warning" style="cursor:pointer">ME</td>';
                            }
                            else{
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-dark" style="cursor:pointer">ME</td>';
                            }
                        }
                        else{
                            if ($section=='VVIP') {
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-lime" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                            }
                            else if ($section=='VIP') {
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-pink" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                            }
                            else if ($section=='Terraces') {
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-warning" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                            }
                            else{
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-dark" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                            }
                        }
                        
                    }
                }
            }
            else if ($tsrow<=($rowsleft+$rowscenter)) {
                $centercolumn=$id.'_R'.$rowlen.'C'.$tsrow;
                $seat_id=$this->getSeatId($centercolumn);
                $condition=$this->getSeatCondition($centercolumn);
                $section=$this->getSeatStatus($centercolumn);
                $availability=$this->getSeatAvailability($seat_id,$upcoming);
                $ticket_amount=$this->getSeatAmount($section,$upcoming);
                $seat_holder=$this->getSeatHolder($seat_id,$upcoming);
                $start_date=$this->getStartDate($upcoming);
                $end_date=$this->getEndDate($upcoming);
                if ($condition=='Blocked' || $condition=='Maintenance') {
                    if ($section=='VVIP') {
                        $data.='<td class="p-1 tdHover text-xs bg-danger text-lime" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                    }
                    else if ($section=='VIP') {
                        $data.='<td class="p-1 tdHover text-xs bg-danger text-pink" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                    }
                    else if ($section=='Terraces') {
                        $data.='<td class="p-1 tdHover text-xs bg-danger text-warning" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                    }
                    else{
                        $data.='<td class="p-1 tdHover text-xs bg-danger text-dark" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                    }
                }
                else{
                    if ($availability=='Available' || $availability=='UnPaid' || $availability=='' || $availability=='Canceled') {
                        if ($section=='VVIP') {
                            $data.='<td class="p-1 tdHover text-xs text-lime bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.$tsrow.'" data-id7="VVIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'"  data-id11="'.$wallet.'" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                        }
                        else if ($section=='VIP') {
                            $data.='<td class="p-1 tdHover text-xs text-pink bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.$tsrow.'" data-id7="VIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'"  data-id11="'.$wallet.'" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                        }
                        else if ($section=='Terraces') {
                            $data.='<td class="p-1 tdHover text-xs text-warning bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.$tsrow.'" data-id7="Terraces" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'"  data-id11="'.$wallet.'" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                        }
                        else{
                            $data.='<td class="p-1 tdHover text-xs text-dark bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.$tsrow.'" data-id7="Regular" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'"  data-id11="'.$wallet.'" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                        }
                    }
                    else if ($availability=='Booked' || $availability=='Reserved' || $availability=='Checked') {
                        if ($seat_holder==$holder) {
                            if ($section=='VVIP') {
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-lime" style="cursor:pointer">ME</td>';
                            }
                            else if ($section=='VIP') {
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-pink" style="cursor:pointer">ME</td>';
                            }
                            else if ($section=='Terraces') {
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-warning" style="cursor:pointer">ME</td>';
                            }
                            else{
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-dark" style="cursor:pointer">ME</td>';
                            }
                        }
                        else{
                            if ($section=='VVIP') {
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-lime" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                            }
                            else if ($section=='VIP') {
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-pink" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                            }
                            else if ($section=='Terraces') {
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-warning" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                            }
                            else{
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-dark" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                            }
                        }
                    }
                }
            }
            else if ($tsrow<=($rowsleft+$rowscenter+$rowsright)) {
                $rightcolumn=$id.'_R'.$rowlen.'R'.$tsrow;
                $seat_id=$this->getSeatId($rightcolumn);
                $condition=$this->getSeatCondition($rightcolumn);
                $section=$this->getSeatStatus($rightcolumn);
                $availability=$this->getSeatAvailability($seat_id,$upcoming);
                $ticket_amount=$this->getSeatAmount($section,$upcoming);
                $seat_holder=$this->getSeatHolder($seat_id,$upcoming);
                $start_date=$this->getStartDate($upcoming);
                $end_date=$this->getEndDate($upcoming);
                if ($condition=='Blocked' || $condition=='Maintenance') {
                    if ($section=='VVIP') {
                        $data.='<td class="p-1 tdHover text-xs bg-danger text-lime" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                    }
                    else if ($section=='VIP') {
                        $data.='<td class="p-1 tdHover text-xs bg-danger text-pink" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                    }
                    else if ($section=='Terraces') {
                        $data.='<td class="p-1 tdHover text-xs bg-danger text-warning" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                    }
                    else{
                        $data.='<td class="p-1 tdHover text-xs bg-danger text-dark" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                    }
                }
                else{
                    if ($availability=='Available'  || $availability=='UnPaid' || $availability=='' || $availability=='Canceled') {
                        if ($section=='VVIP') {
                            $data.='<td class="p-1 tdHover text-xs text-lime bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.$tsrow.'" data-id7="VVIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'"  data-id11="'.$wallet.'" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                        }
                        else if ($section=='VIP') {
                            $data.='<td class="p-1 tdHover text-xs text-pink bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.$tsrow.'" data-id7="VIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'"  data-id11="'.$wallet.'" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                        }
                        else if ($section=='Terraces') {
                            $data.='<td class="p-1 tdHover text-xs text-warning bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.$tsrow.'" data-id7="Terraces" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'"  data-id11="'.$wallet.'" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                        }
                        else{
                            $data.='<td class="p-1 tdHover text-xs text-dark bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.$tsrow.'" data-id7="Regular" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'"  data-id11="'.$wallet.'" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                        }
                    }
                    else if ($availability=='Booked' || $availability=='Reserved' || $availability=='Checked') {
                        if ($seat_holder==$holder) {
                            if ($section=='VVIP') {
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-lime" style="cursor:pointer">ME</td>';
                            }
                            else if ($section=='VIP') {
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-pink" style="cursor:pointer">ME</td>';
                            }
                            else if ($section=='Terraces') {
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-warning" style="cursor:pointer">ME</td>';
                            }
                            else{
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-dark" style="cursor:pointer">ME</td>';
                            }
                        }
                        else{
                            if ($section=='VVIP') {
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-lime" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                            }
                            else if ($section=='VIP') {
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-pink" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                            }
                            else if ($section=='Terraces') {
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-warning" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                            }
                            else{
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-dark" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                            }
                        }
                    }
                }
            }

            if ($tsrow==$rowsleft) {
                $data.='<td style="min-width:40px;border:none;"></td>';
            }
            else if ($tsrow==($rowsleft+$rowscenter)) {
                $data.='<td style="min-width:40px;border:none;"></td>';
            }
            
            if ($tsrow<$rowseats) {
                $tsrow++;
            }
            else{
                $tsrow=1;
                $rowlen++;
                $output.='<tr>';
                $output.=$data;
                $output.='</tr>';
                $data='';
                continue;
            }
        }

        $extradata='<tr>';
        $rowlen=$rows+1;
        for ($i=1; $i <= $seatsextra; $i++) { 
            if ($i<=$rowsleft) {
                $leftcolumn=$id.'_R'.$rowlen.'L'.($i);
                $seat_id=$this->getSeatId($leftcolumn);
                $condition=$this->getSeatCondition($leftcolumn);
                $section=$this->getSeatStatus($leftcolumn);
                $availability=$this->getSeatAvailability($seat_id,$upcoming);
                $ticket_amount=$this->getSeatAmount($section,$upcoming);
                $seat_holder=$this->getSeatHolder($seat_id,$upcoming);
                $start_date=$this->getStartDate($upcoming);
                $end_date=$this->getEndDate($upcoming);
                if ($condition=='Blocked' || $condition=='Maintenance') {
                    if ($section=='VVIP') {
                        $extradata.='<td class="p-1 tdHover text-xs bg-danger text-lime" style="cursor:pointer">'.'R'.$rowlen.'L'.($i).'</td>';
                    }
                    else if ($section=='VIP') {
                        $extradata.='<td class="p-1 tdHover text-xs bg-danger text-pink" style="cursor:pointer">'.'R'.$rowlen.'L'.($i).'</td>';
                    }
                    else if ($section=='Terraces') {
                        $extradata.='<td class="p-1 tdHover text-xs bg-danger text-warning" style="cursor:pointer">'.'R'.$rowlen.'L'.($i).'</td>';
                    }
                    else{
                        $extradata.='<td class="p-1 tdHover text-xs bg-danger text-dark" style="cursor:pointer">'.'R'.$rowlen.'L'.($i).'</td>';
                    }
                }
                else{
                    if ($availability=='Available'  || $availability=='UnPaid' || $availability=='' || $availability=='Canceled') {
                        if ($section=='VVIP') {
                            $extradata.='<td class="p-1 tdHover text-xs text-lime bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.($i).'" data-id7="VVIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'"  data-id11="'.$wallet.'" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                        }
                        else if ($section=='VIP') {
                            $extradata.='<td class="p-1 tdHover text-xs text-pink bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.($i).'" data-id7="VIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'"  data-id11="'.$wallet.'" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                        }
                        else if ($section=='Terraces') {
                            $extradata.='<td class="p-1 tdHover text-xs text-warning bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.($i).'" data-id7="Terraces" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'"  data-id11="'.$wallet.'" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                        }
                        else{
                            $extradata.='<td class="p-1 tdHover text-xs text-dark bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.($i).'" data-id7="Regular" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'"  data-id11="'.$wallet.'" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                        }
                    }
                    else if ($availability=='Booked' || $availability=='Reserved' || $availability=='Checked') {
                        if ($seat_holder==$holder) {
                            if ($section=='VVIP') {
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-lime" style="cursor:pointer">ME</td>';
                            }
                            else if ($section=='VIP') {
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-pink" style="cursor:pointer">ME</td>';
                            }
                            else if ($section=='Terraces') {
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-warning" style="cursor:pointer">ME</td>';
                            }
                            else{
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-dark" style="cursor:pointer">ME</td>';
                            }
                        }
                        else{
                            if ($section=='VVIP') {
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-lime" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                            }
                            else if ($section=='VIP') {
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-pink" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                            }
                            else if ($section=='Terraces') {
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-warning" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                            }
                            else{
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-dark" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                            }
                        }
                    }
                }
            }
            else if ($i<=($rowsleft+$rowscenter)) {
                $centercolumn=$id.'_R'.$rowlen.'C'.($i);
                $seat_id=$this->getSeatId($centercolumn);
                $condition=$this->getSeatCondition($centercolumn);
                $section=$this->getSeatStatus($centercolumn);
                $availability=$this->getSeatAvailability($seat_id,$upcoming);
                $ticket_amount=$this->getSeatAmount($section,$upcoming);
                $seat_holder=$this->getSeatHolder($seat_id,$upcoming);
                $start_date=$this->getStartDate($upcoming);
                $end_date=$this->getEndDate($upcoming);
                if ($condition=='Blocked' || $condition=='Maintenance') {
                    if ($section=='VVIP') {
                        $extradata.='<td class="p-1 tdHover text-xs bg-danger text-lime" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                    }
                    else if ($section=='VIP') {
                        $extradata.='<td class="p-1 tdHover text-xs bg-danger text-pink" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                    }
                    else if ($section=='Terraces') {
                        $extradata.='<td class="p-1 tdHover text-xs bg-danger text-warning" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                    }
                    else{
                        $extradata.='<td class="p-1 tdHover text-xs bg-danger text-dark" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                    }
                }
                else{
                    if ($availability=='Available'  || $availability=='UnPaid' || $availability=='' || $availability=='Canceled') {
                        if ($section=='VVIP') {
                            $extradata.='<td class="p-1 tdHover text-xs text-lime bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.($i).'" data-id7="VVIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'"  data-id11="'.$wallet.'" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                        }
                        else if ($section=='VIP') {
                            $extradata.='<td class="p-1 tdHover text-xs text-pink bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.($i).'" data-id7="VIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'"  data-id11="'.$wallet.'" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                        }
                        else if ($section=='Terraces') {
                            $extradata.='<td class="p-1 tdHover text-xs text-warning bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.($i).'" data-id7="Terraces" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'"  data-id11="'.$wallet.'" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                        }
                        else{
                            $extradata.='<td class="p-1 tdHover text-xs text-dark bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.($i).'" data-id7="Regular" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'"  data-id11="'.$wallet.'" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                        }
                    }
                    else if ($availability=='Booked' || $availability=='Reserved' || $availability=='Checked') {
                        if ($seat_holder==$holder) {
                            if ($section=='VVIP') {
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-lime" style="cursor:pointer">ME</td>';
                            }
                            else if ($section=='VIP') {
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-pink" style="cursor:pointer">ME</td>';
                            }
                            else if ($section=='Terraces') {
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-warning" style="cursor:pointer">ME</td>';
                            }
                            else{
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-dark" style="cursor:pointer">ME</td>';
                            }
                        }
                        else{
                            if ($section=='VVIP') {
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-lime" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                            }
                            else if ($section=='VIP') {
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-pink" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                            }
                            else if ($section=='Terraces') {
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-warning" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                            }
                            else{
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-dark" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                            }
                        }
                    }
                }
            }
            else if ($i<=($rowsleft+$rowscenter+$rowsright)) {
                $rightcolumn=$id.'_R'.$rowlen.'R'.($i);
                $seat_id=$this->getSeatId($rightcolumn);
                $condition=$this->getSeatCondition($rightcolumn);
                $section=$this->getSeatStatus($rightcolumn);
                $availability=$this->getSeatAvailability($seat_id,$upcoming);
                $ticket_amount=$this->getSeatAmount($section,$upcoming);
                $seat_holder=$this->getSeatHolder($seat_id,$upcoming);
                $start_date=$this->getStartDate($upcoming);
                $end_date=$this->getEndDate($upcoming);
                if ($condition=='Blocked' || $condition=='Maintenance') {
                    if ($section=='VVIP') {
                        $extradata.='<td class="p-1 tdHover text-xs bg-danger text-lime" style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'</td>';
                    }
                    else if ($section=='VIP') {
                        $extradata.='<td class="p-1 tdHover text-xs bg-danger text-pink" style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'</td>';
                    }
                    else if ($section=='Terraces') {
                        $extradata.='<td class="p-1 tdHover text-xs bg-danger text-warning" style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'</td>';
                    }
                    else{
                        $extradata.='<td class="p-1 tdHover text-xs bg-danger text-dark" style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'</td>';
                    }
                }
                else{
                    if ($availability=='Available'  || $availability=='UnPaid' || $availability=='' || $availability=='Canceled') {
                        if ($section=='VVIP') {
                            $extradata.='<td class="p-1 tdHover text-xs text-lime bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.($i).'" data-id7="VVIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'"  data-id11="'.$wallet.'" style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'</td>';
                        }
                        else if ($section=='VIP') {
                            $extradata.='<td class="p-1 tdHover text-xs text-pink bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.($i).'" data-id7="VIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'"  data-id11="'.$wallet.'" style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'</td>';
                        }
                        else if ($section=='Terraces') {
                            $extradata.='<td class="p-1 tdHover text-xs text-warning bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.($i).'" data-id7="Terraces" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'"  data-id11="'.$wallet.'" style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'</td>';
                        }
                        else{
                            $extradata.='<td class="p-1 tdHover text-xs text-dark bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.($i).'" data-id7="Regular" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'"  data-id11="'.$wallet.'" style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'</td>';
                        }
                    }
                    else if ($availability=='Booked' || $availability=='Reserved' || $availability=='Checked') {
                        if ($seat_holder==$holder) {
                            if ($section=='VVIP') {
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-lime" style="cursor:pointer">ME</td>';
                            }
                            else if ($section=='VIP') {
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-pink" style="cursor:pointer">ME</td>';
                            }
                            else if ($section=='Terraces') {
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-warning" style="cursor:pointer">ME</td>';
                            }
                            else{
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-dark" style="cursor:pointer">ME</td>';
                            }
                        }
                        else{
                            if ($section=='VVIP') {
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-lime" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                            }
                            else if ($section=='VIP') {
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-pink" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                            }
                            else if ($section=='Terraces') {
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-warning" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                            }
                            else{
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-dark" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                            }
                        }
                    }
                }
            }

            if ($i==$rowsleft) {
                $extradata.='<td style="min-width:40px;border:none;"></td>';
            }
            else if ($i==($rowsleft+$rowscenter)) {
                $extradata.='<td style="min-width:40px;border:none;"></td>';
            }
        }
        $extradata.='</tr>';
        $output.=$extradata;
        $output.='</table>';
        echo $output;
    }

    public function getMovieSeats($id,$upcoming){
        if (!Auth::check()) {
            return redirect('login');
        }
        $holder=-1;
        $this->updateExpiredUnpaidAdmin();
        $wallet=Movie::getWalletBal();
        $screens=Screens::orderByDesc('id')->where('id',$id)->get();
        $movie_id=$this->getMovieId($upcoming);
        $movie_name=$this->getMovieName($movie_id);
        $screen_name=$screens[0]->screen;
        $capacity=$screens[0]->capacity;
        $rowsleft=$screens[0]->rowsleft;    
        $rowscenter=$screens[0]->rowscenter;
        $rowsright=$screens[0]->rowsright;
        $rowseats=$rowsleft+$rowscenter+$rowsright;
        $rows=intdiv($capacity,$rowseats);
        $seatsextra=($capacity%$rowseats);
        $tsrow=1;
        $rowlen=1;
        $output='';
        $data='';
        $datalen=$capacity-$seatsextra;
        $output.='<table border="1" class="table seatTable text-xs">';
        for ($i=1; $i <= $capacity; $i++) { 
            //check for Good(Available),Not Available(Maintenamce), Blocked(), VVIP,VIP,Regular,Terraces
            if ($tsrow<=$rowsleft) {
                $leftcolumn=$id.'_R'.$rowlen.'L'.$tsrow;
                $seat_id=$this->getSeatId($leftcolumn);
                $condition=$this->getSeatCondition($leftcolumn);
                $section=$this->getSeatStatus($leftcolumn);
                $availability=$this->getSeatAvailability($seat_id,$upcoming);
                $ticket_amount=$this->getSeatAmount($section,$upcoming);
                $seat_holder=$this->getSeatHolder($seat_id,$upcoming);
                $seat_holder_name=$this->getSeatHolderName($seat_holder);
                $seat_holder_phone=$this->getSeatHolderPhone($seat_holder);
                $sold_on_date=Movie::getTimeInTimezone($this->getSeatSoldOn($seat_id,$upcoming));
                $used_on_date=Movie::getTimeInTimezone($this->getSeatUsedOn($seat_id,$upcoming));
                $ticket_id=$this->getTicketId($seat_id,$upcoming);
                $thisticket=$this->getTicketName($seat_id,$upcoming);
                $status=$this->getTicketStatus($seat_id,$upcoming);
                $sold_on=Movie::getTimeInTimezone($sold_on_date);
                $used_on=Movie::getTimeInTimezone($used_on_date);
                $start_date=$this->getStartDate($upcoming);
                $end_date=$this->getEndDate($upcoming);
                $status_data='';
                
                if ($condition=='Blocked' || $condition=='Maintenance') {
                    if ($section=='VVIP') {
                        $data.='<td class="p-1 tdHover text-xs bg-danger text-lime" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                    }
                    else if ($section=='VIP') {
                        $data.='<td class="p-1 tdHover text-xs bg-danger text-pink" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                    }
                    else if ($section=='Terraces') {
                        $data.='<td class="p-1 tdHover text-xs bg-danger text-warning" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                    }
                    else{
                        $data.='<td class="p-1 tdHover text-xs bg-danger text-dark" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                    }
                }
                else{
                    if ($availability=='Available'  || $availability=='UnPaid' || $availability=='' || $availability=='Canceled') {
                        if ($section=='VVIP') {
                            $data.='<td class="p-1 tdHover text-xs text-lime" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                        }
                        else if ($section=='VIP') {
                            $data.='<td class="p-1 tdHover text-xs text-pink" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                        }
                        else if ($section=='Terraces') {
                            $data.='<td class="p-1 tdHover text-xs text-warning" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                        }
                        else{
                            $data.='<td class="p-1 tdHover text-xs text-dark" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                        }
                    }
                    else if ($availability=='Booked' || $availability=='Reserved' || $availability=='Checked') {
                        if ($availability=='Checked') {
                            if ($used_on!='') {
                                if ($section=='VVIP') {
                                    $data.='<td class="p-1 tdHover text-xs bg-purple text-lime reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'L'.$tsrow.'" data-id7="VVIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'<i class="p-0 m-0 fa fa-check text-success text-bold"></i></td>';
                                }
                                else if ($section=='VIP') {
                                    $data.='<td class="p-1 tdHover text-xs bg-purple text-pink reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'L'.$tsrow.'" data-id7="VIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'<i class="p-0 m-0 fa fa-check text-success text-bold"></i></td>';
                                }
                                else if ($section=='Terraces') {
                                    $data.='<td class="p-1 tdHover text-xs bg-purple text-warning reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'L'.$tsrow.'" data-id7="Terraces" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'<i class="p-0 m-0 fa fa-check text-success text-bold"></i></td>';
                                }
                                else{
                                    $data.='<td class="p-1 tdHover text-xs bg-purple text-dark reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'L'.$tsrow.'" data-id7="Regular" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'<i class="p-0 m-0 fa fa-check text-success text-bold"></i></td>';
                                }
                            }
                            else{
                                if ($section=='VVIP') {
                                    $data.='<td class="p-1 tdHover text-xs bg-purple text-lime reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'L'.$tsrow.'" data-id7="VVIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'<i class="p-0 m-0 fa fa-check text-danger text-bold"></i></td>';
                                }
                                else if ($section=='VIP') {
                                    $data.='<td class="p-1 tdHover text-xs bg-purple text-pink reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'L'.$tsrow.'" data-id7="VIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'<i class="p-0 m-0 fa fa-check text-danger text-bold"></i></td>';
                                }
                                else if ($section=='Terraces') {
                                    $data.='<td class="p-1 tdHover text-xs bg-purple text-warning reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'L'.$tsrow.'" data-id7="Terraces" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'<i class="p-0 m-0 fa fa-check text-danger text-bold"></i></td>';
                                }
                                else{
                                    $data.='<td class="p-1 tdHover text-xs bg-purple text-dark reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'L'.$tsrow.'" data-id7="Regular" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'<i class="p-0 m-0 fa fa-check text-danger text-bold"></i></td>';
                                }
                            }
                        }
                        else{
                            if ($section=='VVIP') {
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-lime reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'L'.$tsrow.'" data-id7="VVIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                            }
                            else if ($section=='VIP') {
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-pink reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'L'.$tsrow.'" data-id7="VIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                            }
                            else if ($section=='Terraces') {
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-warning reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'L'.$tsrow.'" data-id7="Terraces" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                            }
                            else{
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-dark reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'L'.$tsrow.'" data-id7="Regular" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                            }
                        }
                        
                    }
                }
            }
            else if ($tsrow<=($rowsleft+$rowscenter)) {
                $centercolumn=$id.'_R'.$rowlen.'C'.$tsrow;
                $seat_id=$this->getSeatId($centercolumn);
                $condition=$this->getSeatCondition($centercolumn);
                $section=$this->getSeatStatus($centercolumn);
                $availability=$this->getSeatAvailability($seat_id,$upcoming);
                $ticket_amount=$this->getSeatAmount($section,$upcoming);
                $seat_holder=$this->getSeatHolder($seat_id,$upcoming);
                $seat_holder_name=$this->getSeatHolderName($seat_holder);
                $seat_holder_phone=$this->getSeatHolderPhone($seat_holder);
                $sold_on_date=Movie::getTimeInTimezone($this->getSeatSoldOn($seat_id,$upcoming));
                $used_on_date=Movie::getTimeInTimezone($this->getSeatUsedOn($seat_id,$upcoming));
                $ticket_id=$this->getTicketId($seat_id,$upcoming);
                $thisticket=$this->getTicketName($seat_id,$upcoming);
                $status=$this->getTicketStatus($seat_id,$upcoming);
                $sold_on=Movie::getTimeInTimezone($sold_on_date);
                $used_on=Movie::getTimeInTimezone($used_on_date);
                $start_date=$this->getStartDate($upcoming);
                $end_date=$this->getEndDate($upcoming);
                if ($condition=='Blocked' || $condition=='Maintenance') {
                    if ($section=='VVIP') {
                        $data.='<td class="p-1 tdHover text-xs bg-danger text-lime" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                    }
                    else if ($section=='VIP') {
                        $data.='<td class="p-1 tdHover text-xs bg-danger text-pink" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                    }
                    else if ($section=='Terraces') {
                        $data.='<td class="p-1 tdHover text-xs bg-danger text-warning" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                    }
                    else{
                        $data.='<td class="p-1 tdHover text-xs bg-danger text-dark" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                    }
                }
                else{
                    if ($availability=='Available' || $availability=='UnPaid' || $availability=='' || $availability=='Canceled') {
                        if ($section=='VVIP') {
                            $data.='<td class="p-1 tdHover text-xs text-lime" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                        }
                        else if ($section=='VIP') {
                            $data.='<td class="p-1 tdHover text-xs text-pink" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                        }
                        else if ($section=='Terraces') {
                            $data.='<td class="p-1 tdHover text-xs text-warning" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                        }
                        else{
                            $data.='<td class="p-1 tdHover text-xs text-dark" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                        }
                    }
                    else if ($availability=='Booked' || $availability=='Reserved' || $availability=='Checked') {
                        if ($availability=='Checked') {
                            if ($used_on!='') {
                                if ($section=='VVIP') {
                                    $data.='<td class="p-1 tdHover text-xs bg-purple text-lime reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.$tsrow.'" data-id7="VVIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'<i class="p-0 m-0 fa fa-check text-success text-bold"></i></td>';
                                }
                                else if ($section=='VIP') {
                                    $data.='<td class="p-1 tdHover text-xs bg-purple text-pink reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.$tsrow.'" data-id7="VIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'<i class="p-0 m-0 fa fa-check text-success text-bold"></i></td>';
                                }
                                else if ($section=='Terraces') {
                                    $data.='<td class="p-1 tdHover text-xs bg-purple text-warning reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.$tsrow.'" data-id7="Terraces" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'<i class="p-0 m-0 fa fa-check text-success text-bold"></i></td>';
                                }
                                else{
                                    $data.='<td class="p-1 tdHover text-xs bg-purple text-dark reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.$tsrow.'" data-id7="Regular" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'<i class="p-0 m-0 fa fa-check text-success text-bold"></i></td>';
                                }
                            }
                            else{
                                if ($section=='VVIP') {
                                    $data.='<td class="p-1 tdHover text-xs bg-purple text-lime reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.$tsrow.'" data-id7="VVIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'<i class="p-0 m-0 fa fa-check text-danger text-bold"></i></td>';
                                }
                                else if ($section=='VIP') {
                                    $data.='<td class="p-1 tdHover text-xs bg-purple text-pink reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.$tsrow.'" data-id7="VIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'<i class="p-0 m-0 fa fa-check text-danger text-bold"></i></td>';
                                }
                                else if ($section=='Terraces') {
                                    $data.='<td class="p-1 tdHover text-xs bg-purple text-warning reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.$tsrow.'" data-id7="Terraces" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'<i class="p-0 m-0 fa fa-check text-danger text-bold"></i></td>';
                                }
                                else{
                                    $data.='<td class="p-1 tdHover text-xs bg-purple text-dark reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.$tsrow.'" data-id7="Regular" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'<i class="p-0 m-0 fa fa-check text-danger text-bold"></i></td>';
                                }
                            }
                        }
                        else{
                            if ($section=='VVIP') {
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-lime reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.$tsrow.'" data-id7="VVIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                            }
                            else if ($section=='VIP') {
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-pink reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.$tsrow.'" data-id7="VIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                            }
                            else if ($section=='Terraces') {
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-warning reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.$tsrow.'" data-id7="Terraces" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                            }
                            else{
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-dark reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.$tsrow.'" data-id7="Regular" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                            }
                        }
                    }
                }
            }
            else if ($tsrow<=($rowsleft+$rowscenter+$rowsright)) {
                $rightcolumn=$id.'_R'.$rowlen.'R'.$tsrow;
                $seat_id=$this->getSeatId($rightcolumn);
                $condition=$this->getSeatCondition($rightcolumn);
                $section=$this->getSeatStatus($rightcolumn);
                $availability=$this->getSeatAvailability($seat_id,$upcoming);
                $ticket_amount=$this->getSeatAmount($section,$upcoming);
                $seat_holder=$this->getSeatHolder($seat_id,$upcoming);
                $seat_holder_name=$this->getSeatHolderName($seat_holder);
                $seat_holder_phone=$this->getSeatHolderPhone($seat_holder);
                $sold_on_date=Movie::getTimeInTimezone($this->getSeatSoldOn($seat_id,$upcoming));
                $used_on_date=Movie::getTimeInTimezone($this->getSeatUsedOn($seat_id,$upcoming));
                $ticket_id=$this->getTicketId($seat_id,$upcoming);
                $thisticket=$this->getTicketName($seat_id,$upcoming);
                $status=$this->getTicketStatus($seat_id,$upcoming);
                $sold_on=Movie::getTimeInTimezone($sold_on_date);
                $used_on=Movie::getTimeInTimezone($used_on_date);
                $start_date=$this->getStartDate($upcoming);
                $end_date=$this->getEndDate($upcoming);
                if ($condition=='Blocked' || $condition=='Maintenance') {
                    if ($section=='VVIP') {
                        $data.='<td class="p-1 tdHover text-xs bg-danger text-lime" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                    }
                    else if ($section=='VIP') {
                        $data.='<td class="p-1 tdHover text-xs bg-danger text-pink" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                    }
                    else if ($section=='Terraces') {
                        $data.='<td class="p-1 tdHover text-xs bg-danger text-warning" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                    }
                    else{
                        $data.='<td class="p-1 tdHover text-xs bg-danger text-dark" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                    }
                }
                else{
                    if ($availability=='Available'  || $availability=='UnPaid' || $availability=='' || $availability=='Canceled') {
                        if ($section=='VVIP') {
                            $data.='<td class="p-1 tdHover text-xs text-lime" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                        }
                        else if ($section=='VIP') {
                            $data.='<td class="p-1 tdHover text-xs text-pink" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                        }
                        else if ($section=='Terraces') {
                            $data.='<td class="p-1 tdHover text-xs text-warning" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                        }
                        else{
                            $data.='<td class="p-1 tdHover text-xs text-dark" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                        }
                    }
                    else if ($availability=='Booked' || $availability=='Reserved' || $availability=='Checked') {
                        if ($availability=='Checked') {
                            if ($used_on!='') {
                                if ($section=='VVIP') {
                                    $data.='<td class="p-1 tdHover text-xs bg-purple text-lime reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.$tsrow.'" data-id7="VVIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'<i class="p-0 m-0 fa fa-check text-success text-bold"></i></td>';
                                }
                                else if ($section=='VIP') {
                                    $data.='<td class="p-1 tdHover text-xs bg-purple text-pink reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.$tsrow.'" data-id7="VIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'<i class="p-0 m-0 fa fa-check text-success text-bold"></i></td>';
                                }
                                else if ($section=='Terraces') {
                                    $data.='<td class="p-1 tdHover text-xs bg-purple text-warning reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.$tsrow.'" data-id7="Terraces" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'<i class="p-0 m-0 fa fa-check text-success text-bold"></i></td>';
                                }
                                else{
                                    $data.='<td class="p-1 tdHover text-xs bg-purple text-dark reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.$tsrow.'" data-id7="Regular" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'<i class="p-0 m-0 fa fa-check text-success text-bold"></i></td>';
                                }
                            }
                            else{
                                if ($section=='VVIP') {
                                    $data.='<td class="p-1 tdHover text-xs bg-purple text-lime reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.$tsrow.'" data-id7="VVIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'<i class="p-0 m-0 fa fa-check text-danger text-bold"></i></td>';
                                }
                                else if ($section=='VIP') {
                                    $data.='<td class="p-1 tdHover text-xs bg-purple text-pink reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.$tsrow.'" data-id7="VIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'<i class="p-0 m-0 fa fa-check text-danger text-bold"></i></td>';
                                }
                                else if ($section=='Terraces') {
                                    $data.='<td class="p-1 tdHover text-xs bg-purple text-warning reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.$tsrow.'" data-id7="Terraces" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'<i class="p-0 m-0 fa fa-check text-danger text-bold"></i></td>';
                                }
                                else{
                                    $data.='<td class="p-1 tdHover text-xs bg-purple text-dark reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'L'.$tsrow.'" data-id7="Regular" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'<i class="p-0 m-0 fa fa-check text-danger text-bold"></i></td>';
                                }
                            }
                        }
                        else{
                            if ($section=='VVIP') {
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-lime reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.$tsrow.'" data-id7="VVIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                            }
                            else if ($section=='VIP') {
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-pink reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.$tsrow.'" data-id7="VIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                            }
                            else if ($section=='Terraces') {
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-warning reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.$tsrow.'" data-id7="Terraces" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                            }
                            else{
                                $data.='<td class="p-1 tdHover text-xs bg-purple text-dark reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.$tsrow.'" data-id7="Regular" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                            }
                        }
                    }
                }
            }

            if ($tsrow==$rowsleft) {
                $data.='<td style="min-width:40px;border:none;"></td>';
            }
            else if ($tsrow==($rowsleft+$rowscenter)) {
                $data.='<td style="min-width:40px;border:none;"></td>';
            }
            
            if ($tsrow<$rowseats) {
                $tsrow++;
            }
            else{
                $tsrow=1;
                $rowlen++;
                $output.='<tr>';
                $output.=$data;
                $output.='</tr>';
                $data='';
                continue;
            }
        }

        $extradata='<tr>';
        $rowlen=$rows+1;
        for ($i=1; $i <= $seatsextra; $i++) { 
            if ($i<=$rowsleft) {
                $leftcolumn=$id.'_R'.$rowlen.'L'.($i);
                $seat_id=$this->getSeatId($leftcolumn);
                $condition=$this->getSeatCondition($leftcolumn);
                $section=$this->getSeatStatus($leftcolumn);
                $availability=$this->getSeatAvailability($seat_id,$upcoming);
                $ticket_amount=$this->getSeatAmount($section,$upcoming);
                $seat_holder=$this->getSeatHolder($seat_id,$upcoming);
                $seat_holder_name=$this->getSeatHolderName($seat_holder);
                $seat_holder_phone=$this->getSeatHolderPhone($seat_holder);
                $sold_on_date=Movie::getTimeInTimezone($this->getSeatSoldOn($seat_id,$upcoming));
                $used_on_date=Movie::getTimeInTimezone($this->getSeatUsedOn($seat_id,$upcoming));
                $ticket_id=$this->getTicketId($seat_id,$upcoming);
                $thisticket=$this->getTicketName($seat_id,$upcoming);
                $status=$this->getTicketStatus($seat_id,$upcoming);
                $sold_on=Movie::getTimeInTimezone($sold_on_date);
                $used_on=Movie::getTimeInTimezone($used_on_date);
                $start_date=$this->getStartDate($upcoming);
                $end_date=$this->getEndDate($upcoming);
                if ($condition=='Blocked' || $condition=='Maintenance') {
                    if ($section=='VVIP') {
                        $extradata.='<td class="p-1 tdHover text-xs bg-danger text-lime" style="cursor:pointer">'.'R'.$rowlen.'L'.($i).'</td>';
                    }
                    else if ($section=='VIP') {
                        $extradata.='<td class="p-1 tdHover text-xs bg-danger text-pink" style="cursor:pointer">'.'R'.$rowlen.'L'.($i).'</td>';
                    }
                    else if ($section=='Terraces') {
                        $extradata.='<td class="p-1 tdHover text-xs bg-danger text-warning" style="cursor:pointer">'.'R'.$rowlen.'L'.($i).'</td>';
                    }
                    else{
                        $extradata.='<td class="p-1 tdHover text-xs bg-danger text-dark" style="cursor:pointer">'.'R'.$rowlen.'L'.($i).'</td>';
                    }
                }
                else{
                    if ($availability=='Available'  || $availability=='UnPaid' || $availability=='' || $availability=='Canceled') {
                        if ($section=='VVIP') {
                            $extradata.='<td class="p-1 tdHover text-xs text-lime " style="cursor:pointer">'.'R'.$rowlen.'L'.($i).'</td>';
                        }
                        else if ($section=='VIP') {
                            $extradata.='<td class="p-1 tdHover text-xs text-pink " style="cursor:pointer">'.'R'.$rowlen.'L'.($i).'</td>';
                        }
                        else if ($section=='Terraces') {
                            $extradata.='<td class="p-1 tdHover text-xs text-warning " style="cursor:pointer">'.'R'.$rowlen.'L'.($i).'</td>';
                        }
                        else{
                            $extradata.='<td class="p-1 tdHover text-xs text-dark " style="cursor:pointer">'.'R'.$rowlen.'L'.($i).'</td>';
                        }
                    }
                    else if ($availability=='Booked' || $availability=='Reserved' || $availability=='Checked') {
                        if ($availability=='Checked') {
                            if ($used_on!='') {
                                if ($section=='VVIP') {
                                    $extradata.='<td class="p-1 tdHover text-xs bg-purple text-lime reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'L'.($i).'" data-id7="VVIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'" style="cursor:pointer">'.'R'.$rowlen.'L'.($i).'<i class="p-0 m-0 fa fa-check text-success text-bold"></i></td>';
                                }
                                else if ($section=='VIP') {
                                    $extradata.='<td class="p-1 tdHover text-xs bg-purple text-pink reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'L'.($i).'" data-id7="VIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'" style="cursor:pointer">'.'R'.$rowlen.'L'.($i).'<i class="p-0 m-0 fa fa-check text-success text-bold"></i></td>';
                                }
                                else if ($section=='Terraces') {
                                    $extradata.='<td class="p-1 tdHover text-xs bg-purple text-warning reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'L'.($i).'" data-id7="Terraces" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'L'.($i).'<i class="p-0 m-0 fa fa-check text-success text-bold"></i></td>';
                                }
                                else{
                                    $extradata.='<td class="p-1 tdHover text-xs bg-purple text-dark reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'L'.($i).'" data-id7="Regular" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'L'.($i).'<i class="p-0 m-0 fa fa-check text-success text-bold"></i></td>';
                                }
                            }
                            else{
                                if ($section=='VVIP') {
                                    $extradata.='<td class="p-1 tdHover text-xs bg-purple text-lime reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'L'.($i).'" data-id7="VVIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'" style="cursor:pointer">'.'R'.$rowlen.'L'.($i).'<i class="p-0 m-0 fa fa-check text-danger text-bold"></i></td>';
                                }
                                else if ($section=='VIP') {
                                    $extradata.='<td class="p-1 tdHover text-xs bg-purple text-pink reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'L'.($i).'" data-id7="VIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'" style="cursor:pointer">'.'R'.$rowlen.'L'.($i).'<i class="p-0 m-0 fa fa-check text-danger text-bold"></i></td>';
                                }
                                else if ($section=='Terraces') {
                                    $extradata.='<td class="p-1 tdHover text-xs bg-purple text-warning reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'L'.($i).'" data-id7="Terraces" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'L'.($i).'<i class="p-0 m-0 fa fa-check text-danger text-bold"></i></td>';
                                }
                                else{
                                    $extradata.='<td class="p-1 tdHover text-xs bg-purple text-dark reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'L'.($i).'" data-id7="Regular" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'L'.($i).'<i class="p-0 m-0 fa fa-check text-danger text-bold"></i></td>';
                                }
                            }
                        }
                        else{
                            if ($section=='VVIP') {
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-lime reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'L'.($i).'" data-id7="VVIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'L'.($i).'</td>';
                            }
                            else if ($section=='VIP') {
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-pink reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'L'.($i).'" data-id7="VIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'L'.($i).'</td>';
                            }
                            else if ($section=='Terraces') {
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-warning reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'L'.($i).'" data-id7="Terraces" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'L'.($i).'</td>';
                            }
                            else{
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-dark reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'L'.($i).'" data-id7="Regular" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'L'.($i).'</td>';
                            }
                        }
                    }
                }
            }
            else if ($i<=($rowsleft+$rowscenter)) {
                $centercolumn=$id.'_R'.$rowlen.'C'.($i);
                $seat_id=$this->getSeatId($centercolumn);
                $condition=$this->getSeatCondition($centercolumn);
                $section=$this->getSeatStatus($centercolumn);
                $availability=$this->getSeatAvailability($seat_id,$upcoming);
                $ticket_amount=$this->getSeatAmount($section,$upcoming);
                $seat_holder=$this->getSeatHolder($seat_id,$upcoming);
                $seat_holder_name=$this->getSeatHolderName($seat_holder);
                $seat_holder_phone=$this->getSeatHolderPhone($seat_holder);
                $sold_on_date=Movie::getTimeInTimezone($this->getSeatSoldOn($seat_id,$upcoming));
                $used_on_date=Movie::getTimeInTimezone($this->getSeatUsedOn($seat_id,$upcoming));
                $ticket_id=$this->getTicketId($seat_id,$upcoming);
                $thisticket=$this->getTicketName($seat_id,$upcoming);
                $status=$this->getTicketStatus($seat_id,$upcoming);
                $sold_on=Movie::getTimeInTimezone($sold_on_date);
                $used_on=Movie::getTimeInTimezone($used_on_date);
                $start_date=$this->getStartDate($upcoming);
                $end_date=$this->getEndDate($upcoming);
                if ($condition=='Blocked' || $condition=='Maintenance') {
                    if ($section=='VVIP') {
                        $extradata.='<td class="p-1 tdHover text-xs bg-danger text-lime" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                    }
                    else if ($section=='VIP') {
                        $extradata.='<td class="p-1 tdHover text-xs bg-danger text-pink" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                    }
                    else if ($section=='Terraces') {
                        $extradata.='<td class="p-1 tdHover text-xs bg-danger text-warning" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                    }
                    else{
                        $extradata.='<td class="p-1 tdHover text-xs bg-danger text-dark" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                    }
                }
                else{
                    if ($availability=='Available'  || $availability=='UnPaid' || $availability=='' || $availability=='Canceled') {
                        if ($section=='VVIP') {
                            $extradata.='<td class="p-1 tdHover text-xs text-lime " style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                        }
                        else if ($section=='VIP') {
                            $extradata.='<td class="p-1 tdHover text-xs text-pink " style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                        }
                        else if ($section=='Terraces') {
                            $extradata.='<td class="p-1 tdHover text-xs text-warning " style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                        }
                        else{
                            $extradata.='<td class="p-1 tdHover text-xs text-dark " style="cursor:pointer">'.'C'.$rowlen.'C'.($i).'</td>';
                        }
                    }
                    else if ($availability=='Booked' || $availability=='Reserved' || $availability=='Checked') {
                        if ($availability=='Checked') {
                            if ($used_on!='') {
                                if ($section=='VVIP') {
                                    $extradata.='<td class="p-1 tdHover text-xs bg-purple text-lime reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.($i).'" data-id7="VVIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'<i class="p-0 m-0 fa fa-check text-success text-bold"></i></td>';
                                }
                                else if ($section=='VIP') {
                                    $extradata.='<td class="p-1 tdHover text-xs bg-purple text-pink reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.($i).'" data-id7="VIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'<i class="p-0 m-0 fa fa-check text-success text-bold"></i></td>';
                                }
                                else if ($section=='Terraces') {
                                    $extradata.='<td class="p-1 tdHover text-xs bg-purple text-warning reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.($i).'" data-id7="Terraces" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'<i class="p-0 m-0 fa fa-check text-success text-bold"></i></td>';
                                }
                                else{
                                    $extradata.='<td class="p-1 tdHover text-xs bg-purple text-dark reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.($i).'" data-id7="Regular" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'<i class="p-0 m-0 fa fa-check text-success text-bold"></i></td>';
                                }
                            }
                            else{
                                if ($section=='VVIP') {
                                    $extradata.='<td class="p-1 tdHover text-xs bg-purple text-lime reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.($i).'" data-id7="VVIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'<i class="p-0 m-0 fa fa-check text-danger text-bold"></i></td>';
                                }
                                else if ($section=='VIP') {
                                    $extradata.='<td class="p-1 tdHover text-xs bg-purple text-pink reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.($i).'" data-id7="VIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'<i class="p-0 m-0 fa fa-check text-danger text-bold"></i></td>';
                                }
                                else if ($section=='Terraces') {
                                    $extradata.='<td class="p-1 tdHover text-xs bg-purple text-warning reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.($i).'" data-id7="Terraces" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'<i class="p-0 m-0 fa fa-check text-danger text-bold"></i></td>';
                                }
                                else{
                                    $extradata.='<td class="p-1 tdHover text-xs bg-purple text-dark reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'L'.($i).'" data-id7="Regular" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'L'.($i).'<i class="p-0 m-0 fa fa-check text-danger text-bold"></i></td>';
                                }
                            }
                        }
                        else{
                            if ($section=='VVIP') {
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-lime reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.($i).'" data-id7="VVIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                            }
                            else if ($section=='VIP') {
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-pink reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.($i).'" data-id7="VIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                            }
                            else if ($section=='Terraces') {
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-warning reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.($i).'" data-id7="Terraces" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                            }
                            else{
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-dark reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.($i).'" data-id7="Regular" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                            }
                        }
                    }
                }
            }
            else if ($i<=($rowsleft+$rowscenter+$rowsright)) {
                $rightcolumn=$id.'_R'.$rowlen.'R'.($i);
                $seat_id=$this->getSeatId($rightcolumn);
                $condition=$this->getSeatCondition($rightcolumn);
                $section=$this->getSeatStatus($rightcolumn);
                $availability=$this->getSeatAvailability($seat_id,$upcoming);
                $ticket_amount=$this->getSeatAmount($section,$upcoming);
                $seat_holder=$this->getSeatHolder($seat_id,$upcoming);
                $seat_holder_name=$this->getSeatHolderName($seat_holder);
                $seat_holder_phone=$this->getSeatHolderPhone($seat_holder);
                $sold_on_date=Movie::getTimeInTimezone($this->getSeatSoldOn($seat_id,$upcoming));
                $used_on_date=Movie::getTimeInTimezone($this->getSeatUsedOn($seat_id,$upcoming));
                $ticket_id=$this->getTicketId($seat_id,$upcoming);
                $thisticket=$this->getTicketName($seat_id,$upcoming);
                $status=$this->getTicketStatus($seat_id,$upcoming);
                $sold_on=Movie::getTimeInTimezone($sold_on_date);
                $used_on=Movie::getTimeInTimezone($used_on_date);
                $start_date=$this->getStartDate($upcoming);
                $end_date=$this->getEndDate($upcoming);
                if ($condition=='Blocked' || $condition=='Maintenance') {
                    if ($section=='VVIP') {
                        $extradata.='<td class="p-1 tdHover text-xs bg-danger text-lime" style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'</td>';
                    }
                    else if ($section=='VIP') {
                        $extradata.='<td class="p-1 tdHover text-xs bg-danger text-pink" style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'</td>';
                    }
                    else if ($section=='Terraces') {
                        $extradata.='<td class="p-1 tdHover text-xs bg-danger text-warning" style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'</td>';
                    }
                    else{
                        $extradata.='<td class="p-1 tdHover text-xs bg-danger text-dark" style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'</td>';
                    }
                }
                else{
                    if ($availability=='Available'  || $availability=='UnPaid' || $availability=='' || $availability=='Canceled') {
                        if ($section=='VVIP') {
                            $extradata.='<td class="p-1 tdHover text-xs text-lime " style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'</td>';
                        }
                        else if ($section=='VIP') {
                            $extradata.='<td class="p-1 tdHover text-xs text-pink" style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'</td>';
                        }
                        else if ($section=='Terraces') {
                            $extradata.='<td class="p-1 tdHover text-xs text-warning" style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'</td>';
                        }
                        else{
                            $extradata.='<td class="p-1 tdHover text-xs text-dark" style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'</td>';
                        }
                    }
                    else if ($availability=='Booked' || $availability=='Reserved' || $availability=='Checked') {
                        if ($availability=='Checked') {
                            if ($used_on!='') {
                                if ($section=='VVIP') {
                                    $extradata.='<td class="p-1 tdHover text-xs bg-purple text-lime reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.($i).'" data-id7="VVIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'" style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'<i class="p-0 m-0 fa fa-check text-success text-bold"></i></td>';
                                }
                                else if ($section=='VIP') {
                                    $extradata.='<td class="p-1 tdHover text-xs bg-purple text-pink reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.($i).'" data-id7="VIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'" style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'<i class="p-0 m-0 fa fa-check text-success text-bold"></i></td>';
                                }
                                else if ($section=='Terraces') {
                                    $extradata.='<td class="p-1 tdHover text-xs bg-purple text-warning reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.($i).'" data-id7="Terraces" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'<i class="p-0 m-0 fa fa-check text-success text-bold"></i></td>';
                                }
                                else{
                                    $extradata.='<td class="p-1 tdHover text-xs bg-purple text-dark reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.($i).'" data-id7="Regular" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'<i class="p-0 m-0 fa fa-check text-success text-bold"></i></td>';
                                }
                            }
                            else{
                                if ($section=='VVIP') {
                                    $extradata.='<td class="p-1 tdHover text-xs bg-purple text-lime reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.($i).'" data-id7="VVIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'" style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'<i class="p-0 m-0 fa fa-check text-danger text-bold"></i></td>';
                                }
                                else if ($section=='VIP') {
                                    $extradata.='<td class="p-1 tdHover text-xs bg-purple text-pink reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.($i).'" data-id7="VIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'" style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'<i class="p-0 m-0 fa fa-check text-danger text-bold"></i></td>';
                                }
                                else if ($section=='Terraces') {
                                    $extradata.='<td class="p-1 tdHover text-xs bg-purple text-warning reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.($i).'" data-id7="Terraces" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'<i class="p-0 m-0 fa fa-check text-danger text-bold"></i></td>';
                                }
                                else{
                                    $extradata.='<td class="p-1 tdHover text-xs bg-purple text-dark reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'L'.($i).'" data-id7="Regular" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'L'.($i).'<i class="p-0 m-0 fa fa-check text-danger text-bold"></i></td>';
                                }
                            }
                        }
                        else{
                            if ($section=='VVIP') {
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-lime reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.($i).'" data-id7="VVIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'</td>';
                            }
                            else if ($section=='VIP') {
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-pink reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.($i).'" data-id7="VIP" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'</td>';
                            }
                            else if ($section=='Terraces') {
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-warning reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.($i).'" data-id7="Terraces" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'</td>';
                            }
                            else{
                                $extradata.='<td class="p-1 tdHover text-xs bg-purple text-dark reservedticket" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.($i).'" data-id7="Regular" data-id8="'.$ticket_amount.'" data-id9="'.$start_date.'" data-id10="'.$end_date.'" data-id11="'.$ticket_id.'" data-id12="'.$thisticket.'" data-id13="'.$status.'" data-id14="'.$wallet.'" data-id15="'.$sold_on.'" data-id16="'.$used_on.'" data-id17="'.$seat_holder_name.'" data-id18="'.$seat_holder_phone.'" data-id19="'.$status_data.'"  style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'</td>';
                            }
                        }
                    }
                }
            }

            if ($i==$rowsleft) {
                $extradata.='<td style="min-width:40px;border:none;"></td>';
            }
            else if ($i==($rowsleft+$rowscenter)) {
                $extradata.='<td style="min-width:40px;border:none;"></td>';
            }
        }
        $extradata.='</tr>';
        $output.=$extradata;
        $output.='</table>';
        echo $output;
    }


    public function getBookedTickets($id){
        $screen_id=$this->getScreenId($id);
        $seats=Seats::orderBy('id')->where('screen',$screen_id)->get();
        $data='';
        $sno=0;
        foreach ($seats as $seat) {
            $seat_id=$seat->id;
            $ticket_id='';
            $status='Available';
            $thisticket='';
            $sold_on='';
            $used_on='';
            $holder='Empty';
            $ticket=Tickets::where('upcoming',$id)->where('seat_no',$seat_id)->get()->first();
            if ($ticket!='') {
                $ticket_id=$ticket->id;
                $status=$ticket->status;
                $thisticket=$ticket->ticket;
                $holder=Movie::getAccountDetailsName($ticket->holder);
                $sold_on=Movie::getTimeInTimezone($ticket->sold_on);
                $used_on=Movie::getTimeInTimezone($ticket->used_on);
            }
            
            $sno++;
            $data.='<tr class="seatvaluesdiv" style="">
                    <td class="p-1">'.$seat->seat.'('.$seat->section.')</td>
                    <td class="p-1">'.$thisticket.'</td>
                    <td class="p-1">'.$holder.'</td>
                    <td class="p-1">'.$sold_on.'</td>
                    <td class="p-1">'.$used_on.'</td>
                    <td class="p-1">'.$status.'</td>
                </tr>';
        }
        echo $data;
    }

    public static function getSeatStatus($seat){
        $results = Seats::where('seat',$seat)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $result['section'];
            }
        return $resultname;
    }

    public static function getSeatCondition($seat){
        $results = Seats::where('seat',$seat)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $result['status'];
            }
        return $resultname;
    }

    public static function getSeatStatusID($seat){
        $results = Seats::where('id',$seat)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $result['section'];
            }
        return $resultname;
    }

    public static function getSeatConditionID($seat){
        $results = Seats::where('id',$seat)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $result['status'];
            }
        return $resultname;
    }

    public static function getSeatId($seat){
        $results = Seats::where('seat',$seat)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $result['id'];
            }
        return $resultname;
    }

    public static function getSeatName($id){
        $results = Seats::where('id',$id)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $result['seat'];
            }
        return $resultname;
    }

    public static function getSeatAvailability($seat,$upcoming){
        $results = Tickets::where('seat_no',$seat)->where('upcoming',$upcoming)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $result['status'];
            }
        return $resultname;
    }

    public static function getSeatHolder($seat,$upcoming){
        $results = Tickets::where('seat_no',$seat)->where('upcoming',$upcoming)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $result['holder'];
            }
        return $resultname;
    }

    public static function getSeatHolderName($holder){
        $results = User::where('id',$holder)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $result['fname'].' '.$result['lname'];
            }
        return $resultname;
    }

    public static function getSeatHolderPhone($holder){
        $results = User::where('id',$holder)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $result['phone'];
            }
        return $resultname;
    }

    public static function getSeatSoldOn($seat,$upcoming){
        $results = Tickets::where('seat_no',$seat)->where('upcoming',$upcoming)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $result['sold_on'];
            }
        return $resultname;
    }

    public static function getSeatUsedOn($seat,$upcoming){
        $results = Tickets::where('seat_no',$seat)->where('upcoming',$upcoming)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $result['used_on'];
            }
        return $resultname;
    }

    public static function getMovieId($upcoming){
        $results = Upcoming::where('id',$upcoming)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $result['movie'];
            }
        return $resultname;
    }

    public static function getEmail($id){
        $results = User::where('id',$id)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $result['email'];
            }
        return $resultname;
    }

    public static function getTicketId($seat,$upcoming){
        $results = Tickets::where('seat_no',$seat)->where('upcoming',$upcoming)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $result['id'];
            }
        return $resultname;
    }

    public static function getTicketName($seat,$upcoming){
        $results = Tickets::where('seat_no',$seat)->where('upcoming',$upcoming)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $result['ticket'];
            }
        return $resultname;
    }

    public static function getTicketNameByID($ticketid){
        $results = Tickets::where('id',$ticketid)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $result['ticket'];
            }
        return $resultname;
    }

    public static function getTicketStatus($seat,$upcoming){
        $results = Tickets::where('seat_no',$seat)->where('upcoming',$upcoming)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $result['status'];
            }
        return $resultname;
    }

    public static function getMovieName($id){
        $results = Movie::where('id',$id)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $result['title'];
            }
        return $resultname;
    }

    public static function getMovieFilm($id){
        $results = Movie::where('id',$id)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $result['film'];
            }
        return $resultname;
    }
    public static function getMovieGenre($id){
        $results = Movie::where('id',$id)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $result['genre'];
            }
        return $resultname;
    }

    public static function getMovieDirector($id){
        $results = Movie::where('id',$id)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $result['director'];
            }
        return $resultname;
    }

    public static function getMovieThriller($id){
        $results = Movie::where('id',$id)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $result['thriller'];
            }
        return $resultname;
    }

    public static function getMovieCover($id){
        $results = Movie::where('id',$id)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $result['cover'];
            }
        return $resultname;
    }

    public static function getMovieDescription($id){
        $results = Movie::where('id',$id)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $result['description'];
            }
        return $resultname;
    }

    public static function getMovieStatus($id){
        $results = Movie::where('id',$id)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $result['status'];
            }
        return $resultname;
    }

    public static function getScreenId($upcoming){
        $results = Upcoming::where('id',$upcoming)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $result['screen'];
            }
        return $resultname;
    }

    public static function getScreenName($id){
        $results = Screens::where('id',$id)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $result['screen'];
            }
        return $resultname;
    }

    public static function getScreenCapacity($id){
        $results = Screens::where('id',$id)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $result['capacity'];
            }
        return $resultname;
    }

    public static function getUpcomingSeatsActive($id){
        $results = Seats::where('screen',$id)->where('status','Good')->count();
        return $results;
    }

    public static function getUpcomingSeatsBlocked($id){
        $blocked = Seats::where('screen',$id)->where('status','Blocked')->count();
        $maintenance = Seats::where('screen',$id)->where('status','Maintenance')->count();
        return $blocked+$maintenance;
    }

    public static function getUpcomingSeatsUsed($id){
        $reserved = Tickets::where('upcoming',$id)->where('status','Reserved')->count();
        $checked = Tickets::where('upcoming',$id)->where('status','Checked')->count();
        return $reserved+$checked;
    }

    public static function getUpcomingSeatsVVIP($id){
        $reserved = Tickets::where('upcoming',$id)->where('status','Reserved')->get();
        $seatsVVIP=0;
        foreach ($reserved as $reservedT) {
            $seat_id=$reservedT->seat_no;
            $VVIP=Seats::where('id',$seat_id)->where('section','VVIP')->count();
            $seatsVVIP=$seatsVVIP+$VVIP;
        }
        $checked = Tickets::where('upcoming',$id)->where('status','Checked')->get();
        foreach ($checked as $checkedT) {
            $seat_id_c=$checkedT->seat_no;
            $VVIPs=Seats::where('id',$seat_id_c)->where('section','VVIP')->count();
            $seatsVVIP=$seatsVVIP+$VVIPs;
        }
        return $seatsVVIP;
    }

    public static function getUpcomingSeatsVIP($id){
        $reserved = Tickets::where('upcoming',$id)->where('status','Reserved')->get();
        $seatsVIP=0;
        foreach ($reserved as $reservedT) {
            $seat_id=$reservedT->seat_no;
            $VIP=Seats::where('id',$seat_id)->where('section','VIP')->count();
            $seatsVIP=$seatsVIP+$VIP;
        }
        $checked = Tickets::where('upcoming',$id)->where('status','Checked')->get();
        foreach ($checked as $checkedT) {
            $seat_id_c=$checkedT->seat_no;
            $VIPs=Seats::where('id',$seat_id_c)->where('section','VIP')->count();
            $seatsVIP=$seatsVIP+$VIPs;
        }
        return $seatsVIP;
    }

    public static function getUpcomingSeatsRegular($id){
        $reserved = Tickets::where('upcoming',$id)->where('status','Reserved')->get();
        $seatsRegular=0;
        foreach ($reserved as $reservedT) {
            $seat_id=$reservedT->seat_no;
            $Regular=Seats::where('id',$seat_id)->where('section','Regular')->count();
            $seatsRegular=$seatsRegular+$Regular;
        }
        $checked = Tickets::where('upcoming',$id)->where('status','Checked')->get();
        foreach ($checked as $checkedT) {
            $seat_id_c=$checkedT->seat_no;
            $Regulars=Seats::where('id',$seat_id_c)->where('section','Regular')->count();
            $seatsRegular=$seatsRegular+$Regulars;
        }
        return $seatsRegular;
    }

    public static function getUpcomingSeatsTerraces($id){
        $reserved = Tickets::where('upcoming',$id)->where('status','Reserved')->get();
        $seatsTerraces=0;
        foreach ($reserved as $reservedT) {
            $seat_id=$reservedT->seat_no;
            $Terraces=Seats::where('id',$seat_id)->where('section','Terraces')->count();
            $seatsTerraces=$seatsTerraces+$Terraces;
        }
        $checked = Tickets::where('upcoming',$id)->where('status','Checked')->get();
        foreach ($checked as $checkedT) {
            $seat_id_c=$checkedT->seat_no;
            $Terracess=Seats::where('id',$seat_id_c)->where('section','Terraces')->count();
            $seatsTerraces=$seatsTerraces+$Terracess;
        }
        return $seatsTerraces;
    }
    

    public static function getSeatAmount($section,$upcoming){
        $results = Upcoming::where('id',$upcoming)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $result["$section"];
            }
        return $resultname;
    }

    public static function getStartDate($upcoming){
        $results = Upcoming::where('id',$upcoming)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $result['release_on'];
            }
        return $resultname;
    }

    public static function getEndDate($upcoming){
        $results = Upcoming::where('id',$upcoming)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $result['release_off'];
            }
        return $resultname;
    }

    public static function checkRefundSentforCanceled($ticket){
        $all=Refunds::query()
            ->where('reason','LIKE',"%{$ticket}%")->count();
        return $all;
    }

    public function getSeatsSections($id){
        $seats=Seats::orderBy('id')->where('screen',$id)->get();
        $data='';
        $sno=0;
        foreach ($seats as $seat) {
            $sno++;
            $data.='<tr class="seatvaluesdiv" style="padding:0;padding-top:0;padding-bottom:0;" data-id1="seatno'.$sno.'">
                        <td class="p-1">
                            <label class="col-md-12 p-0 m-0"><input type="checkbox"  name="seatno[]" id="seatno'.$sno.'" class="selectedseatforupdate"  value="'.$seat->id.'"> '.$sno.'</label>
                        </td>
                        <td class="p-1">'.$seat->seat.'</td>
                        <td class="p-1">'.$seat->section.'</td>
                        <td class="p-1">'.$seat->status.'</td>
                    </tr>';
        }
        echo $data;
    }

    public function updateExpiredUnpaid(){
        $id=\Auth::user()->id;
        $latesttickets=Tickets::orderByDesc('id')->where('holder',$id)->where('status','Booked')->where('sold_on',null)->get();
        foreach ($latesttickets as $ticket) {
            $created_at=$ticket->created_at;
            $ticket_id=$ticket->id;
            $end=new Carbon(Carbon::now()->format('Y-m-d H:i:s'));
            $diff=$created_at->diffInMinutes($end,false);

            if ($diff>=10) {
                Tickets::where('id',$ticket_id)->update(['status'=>'UnPaid']); 
            }
        }
    }

    public function updateExpiredUnpaidAdmin(){
        $latesttickets=Tickets::orderByDesc('id')->where('status','Booked')->where('sold_on',null)->get();
        foreach ($latesttickets as $ticket) {
            $created_at=$ticket->created_at;
            $ticket_id=$ticket->id;
            $end=new Carbon(Carbon::now()->format('Y-m-d H:i:s'));
            $diff=$created_at->diffInMinutes($end,false);

            if ($diff>=10) {
                Tickets::where('id',$ticket_id)->update(['status'=>'UnPaid']); 
            }
        }
    }

    public function getBookedTimeRemained($id){
        $diff=0;
        $latesttickets=Tickets::where('id',$id)->get();
        foreach ($latesttickets as $ticket) {
            $created_at=$ticket->created_at;
            $end=new Carbon(Carbon::now()->format('Y-m-d H:i:s'));
            $diff=$created_at->diffInMinutes($end,false);
        }
        return $diff;
    }

    public function getRefundTimeRemained($id){
        $diff=0;
        $latesttickets=Tickets::where('id',$id)->get();
        foreach ($latesttickets as $ticket) {
            $created_at=$ticket->created_at;
            $end=new Carbon(Carbon::now()->format('Y-m-d H:i:s'));
            $diff=$created_at->diffInHours($end,false);
        }
        return $diff;
    }

    

    public function getAiringTimeRemained($id){
        $diff=0;
        $upcomingtime=Upcoming::where('id',$id)->get();
        foreach ($upcomingtime as $upcomingon) {
            $release_on=$upcomingon->release_on;
            $start=new Carbon(Carbon::now()->format('Y-m-d H:i:s'));
            $diff=$start->diffInHours($release_on,false);
        }
        return $diff;
    }

    public function getStreamDetails(){
        $streams=Upcoming::orderByDesc('id')->limit(20)->where('status','Airing')->orWhere('status','Live')->get();

        $output='';
        $id=\Auth::user()->id;
        $myplan=Members::orderByDesc('id')->where('member',$id)->where('status','Active')->get()->first();
        if ($myplan) {
            foreach ($streams as $stream) {
                $id=$stream->movie;
                $screen=$stream->screen;
                $screens=Screens::where('id',$screen)->get()->first()->screen;
                if ($stream->stream) {
                    $output.='<div class="dropdown-divider"></div><h4 class="text-muted text-sm p-1" id="'.$stream->id.'" title="From '.Movie::getTimeInTimezoneString($stream->release_on).' To '.Movie::getTimeInTimezoneString($stream->release_off).'"><span><button class="btn btn-link text-xs p-0 streammovie" data-id0="'.$id.'" data-id1="'.$this->getMovieName($id).'" data-id2="'.$this->getMovieFilm($id).'" data-id3="'.$this->getMovieDirector($id).'" data-id4="'.$this->getMovieDescription($id).'" data-id6="'.$this->getMovieThriller($id).'" data-id7="'.$stream->stream.'"> <span class="text-xs">'.$this->getMovieName($id).'(On '.$screens.')</span></button></span> <span class="float-right text-muted text-sm">'.Movie::getTimeInTimezoneForHumans($stream->release_on).'</span></h4>';
                }
                else{
                    $output.='<div class="dropdown-divider"></div><h4 class="text-muted text-sm p-1" id="'.$stream->id.'" title="From '.Movie::getTimeInTimezoneString($stream->release_on).' To '.Movie::getTimeInTimezoneString($stream->release_off).'"><span><button class="btn btn-small text-xs p-0" data-id0="'.$id.'" data-id1="'.$this->getMovieName($id).'" data-id2="'.$this->getMovieFilm($id).'" data-id3="'.$this->getMovieDirector($id).'" data-id4="'.$this->getMovieDescription($id).'" data-id6="'.$this->getMovieThriller($id).'"> <span class="text-xs text-dark">'.$this->getMovieName($id).'(On '.$screens.')</span></button></span> <span class="float-right text-muted text-sm">'.Movie::getTimeInTimezoneForHumans($stream->release_on).'</span></h4>';
                }
            }
        }
        else{
            $output.='<div class="dropdown-divider"></div><h4 class="text-muted text-sm p-1"> <span class="float-right text-orange text-sm">Your not Subscribed to Any Package</span></h4>';
        }
        
        echo $output;
    }

    public function getBookedHolderStatus($seat_id,$upcoming,$ticket_id,$availability){
        $sold_on_date=Movie::getTimeInTimezone($this->getSeatSoldOn($seat_id,$upcoming));
        $used_on_date=Movie::getTimeInTimezone($this->getSeatUsedOn($seat_id,$upcoming));
        $sold_on=Movie::getTimeInTimezone($sold_on_date);
        $used_on=Movie::getTimeInTimezone($used_on_date);
        //seat_id,upcoming,ticketid,
        if ($availability=='Booked') {
            //calc time remained
            $timeleft=$this->getBookedTimeRemained($ticket_id);
            if($timeleft<=10){
                $timeleft=10-$timeleft;
            }
            else{
                $timeleft='Zero';
            }
            echo '
                <input type="text" title="Time Remained to Pay" value="Time Remained: '.$timeleft.' Min(s)" class="form-control bg-light p-1 m-1" readonly>
                <p class="p-1 text-danger"> Waiting for Client Payment</p>';
        }
        else if ($availability=='Reserved') {
            //display placed on information
            echo '
                <input type="text" title="Placed on/ Time Paid" value="Placed On: '.$sold_on.'" class="form-control bg-light p-1 m-1" readonly>
                <p class="p-1 text-success"> Payment Done. Waiting for Client Check In</p>';
        }
        else if ($availability=='Checked') {
            //if checked but not allowed
                //allow in btn, placed on
            if ($used_on==null) {
                echo '
                    <input type="text" title="Placed on/ Time Paid" value="Placed On: '.$sold_on.'" class="form-control bg-light p-1 m-1" readonly>
                    <p class="p-1 text-orange"> Client has Checked In. Please Accept in the button below.</p>
                    <button type="button" class="btn btn-success acceptcheckinclient" data-id1="'.$ticket_id.'" data-id2="'.$upcoming.'" data-id3="'.$seat_id.'" > Accept Check In </button>';
            }
            else{
                //if checked but and allowed
                // placed on, used on
                echo '
                    <input type="text" title="Placed on/ Time Paid" value="Placed On: '.$sold_on.'" class="form-control bg-light p-1 m-1" readonly>
                    <input type="text" title="Used on/ Time accepted Check In" value="Used On: '.$used_on.' Min(s)" class="form-control p-1 m-1" readonly>
                    <p class="p-1 text-success"> Client has Checked In Successful.</p>';
            }
        }
    }


    public function getPackageStatus($amount,$wallet){
        $id=\Auth::user()->id;
        $output='';
        $phone=$this->getSeatHolderPhone($id);
        $output.='<div class="col-12">
            <label class="col-md-12 col-form-label text-md-center">Confirm Amount And Transaction ID</label>
              <div class="form-group row m-1">
                  <label for="unpaidwallet_balance" class="col-md-4 col-form-label text-md-right">Wallet Bal</label>

                  <div class="col-md-8">
                      <input id="unpaidwallet_balance" type="text" class="form-control" name="unpaidwallet_balance" readonly placeholder="Wallet Bal" value="'.$wallet.'" required autocomplete="wallet_balance" autofocus>
                  </div>
              </div>
              <div class="form-group row m-1">
                  <label for="unpaidpaybill" class="col-md-4 col-form-label text-md-right">Paybill Number</label>

                  <div class="col-md-8">
                      <input id="unpaidpaybill" type="text" class="form-control" name="unpaidpaybill"  readonly placeholder="Paybill" value="123412" required autocomplete="paybill" autofocus>
                  </div>
              </div>
              <div class="form-group row m-1">
                  <label for="unpaidaccountno" class="col-md-4 col-form-label text-md-right">Account Number</label>

                  <div class="col-md-8">
                      <input id="unpaidaccountno" type="text" class="form-control" name="unpaidaccountno"  readonly placeholder="Account Number" value="254'.$phone.'" required autocomplete="accountno" autofocus>
                  </div>
              </div>
              <div class="form-group row m-1">
                  <label for="packagetransactionid" class="col-md-4 col-form-label text-md-right">Transaction ID</label>
                  <div class="col-md-8">
                      <input id="packagetransactionid" type="text" class="form-control" name="packagetransactionid" maxlength="10" minlength="10" placeholder="Transaction ID" required autocomplete="packagetransactionid" style="text-transform: uppercase;" autofocus>
                  </div>
              </div>
              <div class="form-group row m-1">
                  <label for="amountpaid" class="col-md-4 col-form-label text-md-right">Amount to Pay</label>

                  <div class="col-md-8">
                      <input id="amountpaid" type="text" class="form-control" name="amountpaid" placeholder="Amount Paid" required autocomplete="amountpaid" autofocus>
                  </div>
              </div>
              <div class="form-group row m-1 mb-0 text-center">
                  <div class="col-md-12 justify-content-center">
                      <button type="button" class="btn btn-success" id="packagepaysubmitbtn">
                          Confirm Transaction (MPESA)
                      </button>
                  </div>
              </div>
              <div class="form-group row m-1">
                  <div class="col-md-12" id="statusmembershippackage">
                      
                  </div>
              </div>
          </div>';
        echo  $output;
    }
    

    public function getBookedHolderStatusClient($seat_id,$upcoming,$ticket_id,$availability){
        $sold_on_date=Movie::getTimeInTimezone($this->getSeatSoldOn($seat_id,$upcoming));
        $used_on_date=Movie::getTimeInTimezone($this->getSeatUsedOn($seat_id,$upcoming));
        $sold_on=Movie::getTimeInTimezone($sold_on_date);
        $used_on=Movie::getTimeInTimezone($used_on_date);
        //seat_id,upcoming,ticketid,
        if ($availability=='Booked') {
            //calc time remained
            $timeleft=$this->getBookedTimeRemained($ticket_id);
            if($timeleft<=10){
                $timeleft=10-$timeleft;
            }
            else{
                $timeleft='Zero';
            }
            echo '
                <input type="text" title="Time Remained to Pay" value="Time Remained: '.$timeleft.' Min(s)" class="form-control bg-light p-1 m-1" readonly>
                <p class="p-1 text-danger"> Please Pay to Reserve Seat</p>';
        }
        else if ($availability=='Reserved') {
            //display placed on information
            $timelefttoair=$this->getAiringTimeRemained($upcoming);
            echo '<p class="p-1">Airing in: '.$timelefttoair.' Hours</p>';
            echo '
                <input type="text" title="Placed on/ Time Paid" value="Placed On: '.$sold_on.'" class="form-control bg-light p-1 m-1" readonly>
                <button type="button" class="p-1 m-1 btn btn-success checkiinnow" data-id1="'.$ticket_id.'" data-id2="'.$upcoming.'" data-id3="'.$seat_id.'" > Check In Now </button>';

            if($timelefttoair>=1){
               echo '<button type="button" class="p-1 m-1 btn btn-danger cancelnow" data-id1="'.$ticket_id.'" data-id2="'.$upcoming.'" data-id3="'.$seat_id.'" > Cancel Now </button>';
            } 
        }

        else if ($availability=='Canceled') {
            //display placed on information
            $timelefttorefund=$this->getRefundTimeRemained($ticket_id);
            // echo $timelefttorefund;
            if($timelefttorefund<=48){
                $timelefttorefund=48-$timelefttorefund;
                echo '<p class="p-1">Refund in: '.$timelefttorefund.' Hours</p>';
                $thisticket=$this->getTicketName($seat_id,$upcoming);
                if($this->checkRefundSentforCanceled($thisticket)==0){
                echo '
                    <input type="text" title="Placed on/ Time Paid" value="Placed On: '.$sold_on.'" class="form-control bg-light p-1 m-1" readonly>
                    <button type="button" class="p-1 m-1 btn btn-success requetrefundnow" data-id1="'.$ticket_id.'" data-id2="'.$upcoming.'" data-id3="'.$seat_id.'" > Request Refund Now </button>';
                }
                else{
                    echo '<p class="p-1">Request for Refund has Already been Submitted</p>';
                }
            }
            else{
                $timelefttorefund='Zero';
                echo '<p class="p-1">Refund in: '.$timelefttorefund.' Hours</p>';
                echo '<p class="p-1">Time To Request Refund has Expired.<br>(More than 48 Hours Since Booking)</p>';
            }
        }

        else if ($availability=='Checked') {
            //if checked but not allowed
                //allow in btn, placed on
            if ($used_on==null) {
                echo '
                    <input type="text" title="Placed on/ Time Paid" value="Placed On: '.$sold_on.'" class="form-control bg-light p-1 m-1" readonly>
                    <p class="p-1 text-orange">Checked In. Waiting for Acceptance.</p>';
                    
            }
            else{
                //if checked but and allowed
                // placed on, used on
                echo '
                    <input type="text" title="Placed on/ Time Paid" value="Placed On: '.$sold_on.'" class="form-control bg-light p-1 m-1" readonly>
                    <input type="text" title="Used on/ Time accepted Check In" value="Used On: '.$used_on.' Min(s)" class="form-control p-1 m-1" readonly>
                    <p class="p-1 text-success">Checked In Successful.</p>';
            }
        }
    }

    public function getClientSearch($searchitem){
        $id=\Auth::user()->id;
        $searchterms=explode(' ', $searchitem);
        $msgerror="";
        foreach ($searchterms as $term) {
            if (strlen($term)<3 || $term=='and' || $term=='an' || $term=='a' || $term=='the' || $term=='is' || $term=='not' || $term=='in' || $term=='on' || $term=='at' || $term==',' || $term=='.' || $term=='?' || $term=='or' || $term=='-')  {
                //not searchable clauses
            }
            else{
                $movies=Movie::query()
                    ->where('title','LIKE',"%{$term}%")
                    ->orWhere('description','LIKE',"%{$term}%")->get();
                foreach ($movies as $movie) {
                    echo $movie->title.':  By::'.$movie->film.'<br>';
                }

                $tickets=Tickets::query()
                    ->where('holder','=',$id)
                    ->where('ticket','LIKE',"%{$term}%")
                    ->orWhere('status','LIKE',"%{$term}%")->get();
                foreach ($tickets as $ticket) {
                    echo $ticket->ticket.':  '.$ticket->status.'<br>';
                }
            }
        }
    }

    public function streamnow(Request $request){
        $filePath=$request->input('path');
        $stream= new StreamController($filePath);
        $stream->start();
     }

     public function deleteMovie($id){
        \DB::beginTransaction();
            try {
                if(Movie::find($id)){
                    Movie::where('id',$id)->delete();
                    \DB::commit();
                    return 'Movie Deleted Success';
                }
                else{
                    return 'Movie Not Found';
                }
            } 
            
            catch(\Illuminate\Database\QueryException $ex){
                \DB::rollback(); 
                return 'Movie Not Deleted: '.$ex->getMessage();
            }
     }

     public function newPlan(Request $request){
        \DB::beginTransaction();
        try {
        $saveData = $request->validate([
            'plan' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'days' => 'required|numeric|between:0,999999999',
            'amount' => 'required|numeric|between:1,999999999',
        ]);
        $newwriter = new Members_Plan;
        $newwriter->plan =$request->input('plan');
        $newwriter->days =$request->input('days');
        $newwriter->amount =$request->input('amount');
        $newwriter->description =$request->input('description');
        $newwriter->status ='Active';
        $newwriter->save();
            \DB::commit();
            return back()->with('success', 'Plan Created Successfully');
        } 
        
        catch(\Illuminate\Database\QueryException $ex){
            \DB::rollback(); 
            return back()->with('dbError', 'Could not Create Plan '. $ex->getMessage());
        }
    }
    
}
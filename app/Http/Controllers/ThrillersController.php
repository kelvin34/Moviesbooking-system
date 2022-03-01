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
use Illuminate\Support\Facades\Validator;

class ThrillersController extends Controller
{
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

    public function clientAccount(){
        return view('client.newclient');
    }

    

    public function newMember(Request $request){
        \DB::beginTransaction();
        try {
        $saveData = $request->validate([
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:255'],
            'roles' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => 'required|numeric|between:0,9999999999',
            'idno' => ['required', 'string', 'max:8','min:8'],
            'password' => ['required', 'string', 'min:5', 'confirmed'],
        ]);
        $newwriter = new User;
        $newwriter->fname =$request->input('fname');
        $newwriter->lname =$request->input('lname');
        $newwriter->email =$request->input('email');
        $newwriter->phone =$request->input('phone');
        $newwriter->idno =$request->input('idno');
        $newwriter->gender =$request->input('gender');
        $newwriter->timezone =$request->input('timezone');
        $newwriter->roles =$request->input('roles');
        $newwriter->status ="Active";
        $newwriter->password =Hash::make($request->input('password'));
        $newwriter->save();
        $id=$newwriter->id;
        if($newwriter instanceof MustVerifyEmail && !$newwriter->hasVerifiedEmail()){
            $newwriter->sendEmailVerificationNotification();
        } 
            $fullname=$request->input('fname').' '.$request->input('lname');
            $phone=$request->input('phone');
            $email =$request->input('email');
            $newwriter->notify(new ClientNotification('New Client',$id,$email,$fullname,$phone,'No Movie ID','No Movie Name','No Screen ID','No Screen Name','No Upcoming ID','No Seat ID','No Seat Name','No Seat Section','No Ticket Amount','No Start Date','No End Date','No Ticket ID','No Ticket','No Status','No Wallet','No Sold On','No Used On','New Account Created Successfully'));
            $admins=User::where('roles','Admin')->where('status','Active')->get();
            foreach ($admins as $admin) {
                $admin->notify(new ClientNotificationAdmin('New Client',$id,$email,$fullname,$phone,'No Movie ID','No Movie Name','No Screen ID','No Screen Name','No Upcoming ID','No Seat ID','No Seat Name','No Seat Section','No Ticket Amount','No Start Date','No End Date','No Ticket ID','No Ticket','No Status','No Wallet','No Sold On','No Used On','New Account Created Successfully'));
            }
            \DB::commit();
            return back()->with('success', 'Account Created Successfully');
        } 
        
        catch(\Illuminate\Database\QueryException $ex){
            \DB::rollback(); 
            return back()->with('dbError', 'Could not Create Account '. $ex->getMessage());
        }
        catch(\Swift_TransportException $ex){ 
            \DB::rollback();
            return back()->with('dbError', 'Could not Create Account. Please check your Connection.');
        }
    }

    public function createClientAccount(Request $request){
        \DB::beginTransaction();
        try {
        $saveData = $request->validate([
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => 'required|numeric|between:0,9999999999',
            'idno' => ['required', 'string', 'max:8','min:8'],
            'password' => ['required', 'string', 'min:5', 'confirmed'],
        ]);
        $newwriter = new User;
        $newwriter->fname =$request->input('fname');
        $newwriter->lname =$request->input('lname');
        $newwriter->email =$request->input('email');
        $newwriter->phone =$request->input('phone');
        $newwriter->idno =$request->input('idno');
        $newwriter->gender =$request->input('gender');
        $newwriter->timezone =$request->input('timezone');
        $newwriter->roles ="Client";
        $newwriter->status ="Active";
        $newwriter->password =Hash::make($request->input('password'));
        $newwriter->save();
        $id=$newwriter->id;
        if($newwriter instanceof MustVerifyEmail && !$newwriter->hasVerifiedEmail()){
            $newwriter->sendEmailVerificationNotification();
        } 
            $fullname=$request->input('fname').' '.$request->input('lname');
            $phone=$request->input('phone');
            $email =$request->input('email');
            $newwriter->notify(new ClientNotification('New Client',$id,$email,$fullname,$phone,'No Movie ID','No Movie Name','No Screen ID','No Screen Name','No Upcoming ID','No Seat ID','No Seat Name','No Seat Section','No Ticket Amount','No Start Date','No End Date','No Ticket ID','No Ticket','No Status','No Wallet','No Sold On','No Used On','New Account Created Successfully'));
            $admins=User::where('roles','Admin')->where('status','Active')->get();
            foreach ($admins as $admin) {
                $admin->notify(new ClientNotificationAdmin('New Client',$id,$email,$fullname,$phone,'No Movie ID','No Movie Name','No Screen ID','No Screen Name','No Upcoming ID','No Seat ID','No Seat Name','No Seat Section','No Ticket Amount','No Start Date','No End Date','No Ticket ID','No Ticket','No Status','No Wallet','No Sold On','No Used On','New Account Created Successfully'));
            }
            \DB::commit();
            return redirect('/create-client-account')->with('success', 'Client Account Created Successfully');
        } 
        
        catch(\Illuminate\Database\QueryException $ex){
            \DB::rollback(); 
            return redirect('/create-client-account')->with('dbError', 'Could not Create Account '. $ex->getMessage());
        }
        catch(\Swift_TransportException $ex){ 
            \DB::rollback();
            return redirect('/create-client-account')->with('dbError', 'Could not Create Account. Please check your Connection.');
        }
    }

    public function getSeats($id,$upcoming){
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
                    if ($availability=='Available' || $availability=='') {
                        if ($section=='VVIP') {
                            $data.='<td class="p-1 tdHover text-xs text-lime bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'L'.$tsrow.'" data-id7="VVIP" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                        }
                        else if ($section=='VIP') {
                            $data.='<td class="p-1 tdHover text-xs text-pink bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'L'.$tsrow.'" data-id7="VIP" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                        }
                        else if ($section=='Terraces') {
                            $data.='<td class="p-1 tdHover text-xs text-warning bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'L'.$tsrow.'" data-id7="Terraces" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                        }
                        else{
                            $data.='<td class="p-1 tdHover text-xs text-dark bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'L'.$tsrow.'" data-id7="Regular" style="cursor:pointer">'.'R'.$rowlen.'L'.$tsrow.'</td>';
                        }
                    }
                    else if ($availability=='Booked') {
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
            else if ($tsrow<=($rowsleft+$rowscenter)) {
                $centercolumn=$id.'_R'.$rowlen.'C'.$tsrow;
                $seat_id=$this->getSeatId($centercolumn);
                $condition=$this->getSeatCondition($centercolumn);
                $section=$this->getSeatStatus($centercolumn);
                $availability=$this->getSeatAvailability($seat_id,$upcoming);
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
                    if ($availability=='Available' || $availability=='') {
                        if ($section=='VVIP') {
                            $data.='<td class="p-1 tdHover text-xs text-lime bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.$tsrow.'" data-id7="VVIP" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                        }
                        else if ($section=='VIP') {
                            $data.='<td class="p-1 tdHover text-xs text-pink bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.$tsrow.'" data-id7="VIP" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                        }
                        else if ($section=='Terraces') {
                            $data.='<td class="p-1 tdHover text-xs text-warning bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.$tsrow.'" data-id7="Terraces" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                        }
                        else{
                            $data.='<td class="p-1 tdHover text-xs text-dark bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.$tsrow.'" data-id7="Regular" style="cursor:pointer">'.'R'.$rowlen.'C'.$tsrow.'</td>';
                        }
                    }
                    else if ($availability=='Booked') {
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
            else if ($tsrow<=($rowsleft+$rowscenter+$rowsright)) {
                $rightcolumn=$id.'_R'.$rowlen.'R'.$tsrow;
                $seat_id=$this->getSeatId($rightcolumn);
                $condition=$this->getSeatCondition($rightcolumn);
                $section=$this->getSeatStatus($rightcolumn);
                $availability=$this->getSeatAvailability($seat_id,$upcoming);
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
                    if ($availability=='Available' || $availability=='') {
                        if ($section=='VVIP') {
                            $data.='<td class="p-1 tdHover text-xs text-lime bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.$tsrow.'" data-id7="VVIP" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                        }
                        else if ($section=='VIP') {
                            $data.='<td class="p-1 tdHover text-xs text-pink bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.$tsrow.'" data-id7="VIP" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                        }
                        else if ($section=='Terraces') {
                            $data.='<td class="p-1 tdHover text-xs text-warning bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.$tsrow.'" data-id7="Terraces" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                        }
                        else{
                            $data.='<td class="p-1 tdHover text-xs text-dark bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.$tsrow.'" data-id7="Regular" style="cursor:pointer">'.'R'.$rowlen.'R'.$tsrow.'</td>';
                        }
                    }
                    else if ($availability=='Booked') {
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
                    if ($availability=='Available' || $availability=='') {
                        if ($section=='VVIP') {
                            $extradata.='<td class="p-1 tdHover text-xs text-lime bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.($i).'" data-id7="VVIP" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                        }
                        else if ($section=='VIP') {
                            $extradata.='<td class="p-1 tdHover text-xs text-pink bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.($i).'" data-id7="VIP" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                        }
                        else if ($section=='Terraces') {
                            $extradata.='<td class="p-1 tdHover text-xs text-warning bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.($i).'" data-id7="Terraces" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                        }
                        else{
                            $extradata.='<td class="p-1 tdHover text-xs text-dark bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.($i).'" data-id7="Regular" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                        }
                    }
                    else if ($availability=='Booked') {
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
            else if ($i<=($rowsleft+$rowscenter)) {
                $centercolumn=$id.'_R'.$rowlen.'C'.($i);
                $seat_id=$this->getSeatId($centercolumn);
                $condition=$this->getSeatCondition($centercolumn);
                $section=$this->getSeatStatus($centercolumn);
                $availability=$this->getSeatAvailability($seat_id,$upcoming);
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
                    if ($availability=='Available' || $availability=='') {
                        if ($section=='VVIP') {
                            $extradata.='<td class="p-1 tdHover text-xs text-lime bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.($i).'" data-id7="VVIP" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                        }
                        else if ($section=='VIP') {
                            $extradata.='<td class="p-1 tdHover text-xs text-pink bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.($i).'" data-id7="VIP" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                        }
                        else if ($section=='Terraces') {
                            $extradata.='<td class="p-1 tdHover text-xs text-warning bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.($i).'" data-id7="Terraces" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                        }
                        else{
                            $extradata.='<td class="p-1 tdHover text-xs text-dark bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'C'.($i).'" data-id7="Regular" style="cursor:pointer">'.'R'.$rowlen.'C'.($i).'</td>';
                        }
                    }
                    else if ($availability=='Booked') {
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
            else if ($i<=($rowsleft+$rowscenter+$rowsright)) {
                $rightcolumn=$id.'_R'.$rowlen.'R'.($i);
                $seat_id=$this->getSeatId($rightcolumn);
                $condition=$this->getSeatCondition($rightcolumn);
                $section=$this->getSeatStatus($rightcolumn);
                $availability=$this->getSeatAvailability($seat_id,$upcoming);
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
                    if ($availability=='Available' || $availability=='') {
                        if ($section=='VVIP') {
                            $extradata.='<td class="p-1 tdHover text-xs text-lime bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.($i).'" data-id7="VVIP" style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'</td>';
                        }
                        else if ($section=='VIP') {
                            $extradata.='<td class="p-1 tdHover text-xs text-pink bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.($i).'" data-id7="VIP" style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'</td>';
                        }
                        else if ($section=='Terraces') {
                            $extradata.='<td class="p-1 tdHover text-xs text-warning bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.($i).'" data-id7="Terraces" style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'</td>';
                        }
                        else{
                            $extradata.='<td class="p-1 tdHover text-xs text-dark bookmovieseat" data-id0="'.$movie_id.'" data-id1="'.$movie_name.'" data-id2="'.$screen_name.'" data-id3="'.$id.'" data-id4="'.$upcoming.'" data-id5="'.$seat_id.'" data-id6="R'.$rowlen.'R'.($i).'" data-id7="Regular" style="cursor:pointer">'.'R'.$rowlen.'R'.($i).'</td>';
                        }
                    }
                    else if ($availability=='Booked') {
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

    public static function getSeatId($seat){
        $results = Seats::where('seat',$seat)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $result['id'];
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

    public static function getMovieId($upcoming){
        $results = Upcoming::where('id',$upcoming)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $result['movie'];
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
    
}

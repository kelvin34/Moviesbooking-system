<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Movie;
use App\Models\Upcoming;
use App\Models\Screens;
use App\Models\Wallet;
use App\Models\Requests;
use Carbon\Carbon;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'film',
        'director',
        'thriller',
        'cover', 
        'genre',
        'description',
        'status',
    ];

    public static function getMonthDate($yearmonth){
        $explomonth=explode(' ', $yearmonth);
        $years=$explomonth[0];
        $months=$explomonth[1];
        $yearmonthday=$years.'-'.$months.'-1';
        $month=date_format(date_create($yearmonthday),'Y, M');
        return $month;
    }

    public static function getMonthDateDash($yearmonth){
        $explomonth=explode(' ', $yearmonth);
        $years=$explomonth[0];
        $months=$explomonth[1];
        $yearmonthday=$years.'-'.$months.'-1';
        $month=date_format(date_create($yearmonthday),'M');
        return $month;
    }
    
    public static function getYearDateDash($yearmonth){
        $explomonth=explode(' ', $yearmonth);
        $years=$explomonth[0];
        $months=$explomonth[1];
        $yearmonthday=$years.'-'.$months.'-1';
        $month=date_format(date_create($yearmonthday),'Y');
        return $month;
    }

    public static function getThriller($id){
        $results = Movie::where('id',$id)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $id.'_'.$result['thriller'];
            }
        return $resultname;
    }

    public static function getOnAirDate($id){
        $results = Upcoming::where('movie',$id)->get();
        $resultname='';
            foreach($results as $result){
                $resultname= $result['release_on'];
                $timezone= (\Auth::check())?\Auth::user()->timezone:'UTC';
                $resultname= Carbon::parse($resultname)->setTimezone($timezone);
            }
        return $resultname;
    }

    public static function getOffAirDate($id){
        $results = Upcoming::where('movie',$id)->get();
        $resultname='';
            foreach($results as $result){
                $resultname= $result['release_off'];
                $timezone= (\Auth::check())?\Auth::user()->timezone:'UTC'; 
                $resultname= Carbon::parse($resultname)->setTimezone($timezone);
            }
        return $resultname;
    }

    public static function getOnAirDateScheduled($id){
        $results = Upcoming::where('id',$id)->get();
        $resultname='';
            foreach($results as $result){
                $resultname= $result['release_on'];
                $timezone= (\Auth::check())?\Auth::user()->timezone:'UTC';
                $resultname= Carbon::parse($resultname)->setTimezone($timezone);
            }
        return $resultname;
    }

    public static function getOffAirDateScheduled($id){
        $results = Upcoming::where('id',$id)->get();
        $resultname='';
            foreach($results as $result){
                $resultname= $result['release_off'];
                $timezone= (\Auth::check())?\Auth::user()->timezone:'UTC'; 
                $resultname= Carbon::parse($resultname)->setTimezone($timezone);
            }
        return $resultname;
    }

    public static function getTimeForHumans($datetimestring){
        $timezone= (\Auth::check())?\Auth::user()->timezone:'UTC'; 
        $resultname= Carbon::parse($datetimestring)->setTimezone($timezone)->diffForHumans();
        $resultname=str_replace("second from now", '+sec', $resultname);
        $resultname=str_replace("minute from now", '+min', $resultname);
        $resultname=str_replace("hour from now", '+hr', $resultname);
        $resultname=str_replace("day from now", '+day', $resultname);
        $resultname=str_replace("week from now", '+wk', $resultname);
        $resultname=str_replace("month from now", '+month', $resultname);
        $resultname=str_replace("year from now", '+yr', $resultname);
        $resultname=str_replace("seconds from now", '+secs', $resultname);
        $resultname=str_replace("minutes from now", '+mins', $resultname);
        $resultname=str_replace("hours from now", '+hrs', $resultname);
        $resultname=str_replace("days from now", '+days', $resultname);
        $resultname=str_replace("weeks from now", '+wks', $resultname);
        $resultname=str_replace("months from now", '+months', $resultname);
        $resultname=str_replace("years from now", '+yrs', $resultname);
        $resultname=str_replace("second ago", '-sec', $resultname);
        $resultname=str_replace("minute ago", '-min', $resultname);
        $resultname=str_replace("hour ago", '-hr', $resultname);
        $resultname=str_replace("day ago", '-day', $resultname);
        $resultname=str_replace("week ago", '-wk', $resultname);
        $resultname=str_replace("month ago", '-month', $resultname);
        $resultname=str_replace("year ago", '-yr', $resultname);
        $resultname=str_replace("seconds ago", '-secs', $resultname);
        $resultname=str_replace("minutes ago", '-mins', $resultname);
        $resultname=str_replace("hours ago", '-hrs', $resultname);
        $resultname=str_replace("days ago", '-days', $resultname);
        $resultname=str_replace("weeks ago", '-wks', $resultname);
        $resultname=str_replace("months ago", '-months', $resultname);
        $resultname=str_replace("years ago", '-yrs', $resultname);
        return $resultname;
    }

    public static function getTimeInTimezone($datetimestring){
        if ($datetimestring=='') {
            return '';
        }
        $timezone= (\Auth::check())?\Auth::user()->timezone:'UTC'; 
        $resultname= Carbon::parse($datetimestring)->setTimezone($timezone);
        return $resultname;
    }

    public static function getTimeInTimezoneString($datetimestring){
        if ($datetimestring=='') {
            return '';
        }
        $timezone= (\Auth::check())?\Auth::user()->timezone:'UTC'; 
        $resultname= Carbon::parse($datetimestring)->setTimezone($timezone)->format('D, M d, Y, H:i:s');
        return $resultname;
    }


    public static function getTimeInTimezoneForHumans($datetimestring){
        if ($datetimestring=='') {
            return '';
        }
        $timezone= (\Auth::check())?\Auth::user()->timezone:'UTC'; 
        $resultname= Carbon::parse($datetimestring)->setTimezone($timezone)->diffForHumans();
        return $resultname;
    }

    public static function get24HoursfromNow(){
        $timezone= (\Auth::check())?\Auth::user()->timezone:'UTC'; 
        $resultname= Carbon::now()->setTimezone($timezone);
        $resultname->addHours(24);
        return $resultname;
    }

    public static function getNow(){
        $timezone= (\Auth::check())?\Auth::user()->timezone:'UTC'; 
        $resultname= Carbon::now()->setTimezone($timezone);
        return $resultname;
    }

    public static function checkScheduledStatus(){
        $timezone= (\Auth::check())?\Auth::user()->timezone:'UTC'; 
        $results = Upcoming::orderByDesc('id')->get();
        foreach ($results as $result) {
            $id=$result->id;
            $rele_on=$result->release_on;
            $rele_off=$result->release_off;
            $currentTime= Carbon::now()->setTimezone($timezone);
            $release_on=Movie::getOnAirDateScheduled($id);
            $release_off=Movie::getOffAirDateScheduled($id);
            $airingin24Hrs=Movie::get24HoursfromNow();

            if (($currentTime>=$release_off) && $release_off!=''){
                Upcoming::where('id',$id)->update(['status'=>'Aired','release_on'=>$rele_on]); 
            }
            else if ((($currentTime<$release_off) || ($currentTime<$release_on)) && $release_on!='' && $release_off!=''){
                if ($airingin24Hrs>=$release_on) {
                    if (($currentTime>=$release_on) && ($currentTime<$release_off )) {
                        Upcoming::where('id',$id)->update(['status'=>'Live','release_on'=>$rele_on]); 
                    }
                    else{
                        Upcoming::where('id',$id)->update(['status'=>'Airing','release_on'=>$rele_on]); 
                    }
                }
                else{
                    Upcoming::where('id',$id)->update(['status'=>'Upcoming','release_on'=>$rele_on]); 
                }
            }
            
        }
    }

    public static function getScheduledforMovie($id){
        $results = Upcoming::where('movie',$id)->where('status','Upcoming')->get();
        foreach ($results as $result) {
            return $result->id.' <br>';
        }
    }

    public static function getUpcomingId($id){
        $results = Upcoming::where('movie',$id)->get()->first();
        return $results->id;
    }

    public static function getUpcomingIdScreen($id){
        $results = Upcoming::where('id',$id)->get()->first();
        return $results->screen;
    }

    public static function getUpcomingIdScreenName($id){
        $results = Screens::where('id',$id)->get()->first();
        return $results->screen;
    }

    public static function getAccountDetailsName($id){
        $results = User::where('id',$id)->get()->first();
        return $results->fname.' '.$results->lname;
    }

    public static function getWalletBal(){
        $id=\Auth::user()->id;
        $in=\DB::table('wallets')->where([
            'owner'=>$id
        ])->sum('amount_in');
        $out=\DB::table('wallets')->where([
            'owner'=>$id
        ])->sum('amount_out');
        return $in-$out;
    }

    public static function getWalletBals($month){
        $id=\Auth::user()->id;
        $in=Wallet::query()
            ->where('owner','=',$id)
            ->where('created_at','LIKE',"{$month}%")->sum('amount_in');
        $out=Wallet::query()
            ->where('owner','=',$id)
            ->where('created_at','LIKE',"{$month}%")->sum('amount_out');
        return $in-$out;
    }

    public static function getWalletTotal($month){
        $id=\Auth::user()->id;
        $in=Wallet::query()
            ->where('owner','=',$id)
            ->where('created_at','LIKE',"{$month}%")->sum('amount_in');
        return $in;
    }

    public static function getWalletUsed($month){
        $id=\Auth::user()->id;
        $out=Wallet::query()
            ->where('owner','=',$id)
            ->where('created_at','LIKE',"{$month}%")->sum('amount_out');
        return $out;
    }

    public static function getWalletRefunded($month){
        $id=\Auth::user()->id;
        $in=Wallet::query()
            ->where('owner','=',$id)
            ->where('description','LIKE',"Amount Refunded")
            ->where('created_at','LIKE',"{$month}%")->sum('amount_in');
        return $in;
    }

    public static function getTicketAll($month){
        $id=\Auth::user()->id;
        $all=Tickets::query()
            ->where('holder','=',$id)
            ->where('created_at','LIKE',"{$month}%")->count();
        return $all;
    }

    public static function getTicketUsed($month){
        $id=\Auth::user()->id;
        $all=Tickets::query()
            ->where('holder','=',$id)
            ->where('status','LIKE',"Checked")
            ->where('created_at','LIKE',"{$month}%")->count();
        return $all;
    }

    public static function getTicketReserved($month){
        $id=\Auth::user()->id;
        $all=Tickets::query()
            ->where('holder','=',$id)
            ->where('status','LIKE',"Reserved")
            ->where('created_at','LIKE',"{$month}%")->count();
        $alls=Tickets::query()
            ->where('holder','=',$id)
            ->where('status','LIKE',"Checked")
            ->where('created_at','LIKE',"{$month}%")->count();
        return $all+$alls;
    }

    public static function getTicketExpired($month){
        $id=\Auth::user()->id;
        $all=Tickets::query()
            ->where('holder','=',$id)
            ->where('status','LIKE',"UnPaid")
            ->where('created_at','LIKE',"{$month}%")->count();
        return $all;
    }

    public static function getRequestsAll($month){
        $id=\Auth::user()->id;
        $all=Requests::query()
            ->where('requested_by','=',$id)
            ->where('created_at','LIKE',"{$month}%")->count();
        return $all;
    }

    public static function getRequestsRequested($month){
        $id=\Auth::user()->id;
        $all=Requests::query()
            ->where('requested_by','=',$id)
            ->where('status','LIKE',"Requested")
            ->where('created_at','LIKE',"{$month}%")->count();
        return $all;
    }

    public static function getRequestsResolved($month){
        $id=\Auth::user()->id;
        $all=Requests::query()
            ->where('requested_by','=',$id)
            ->where('status','LIKE',"Resolved")
            ->where('created_at','LIKE',"{$month}%")->count();
        return $all;
    }

    public static function getRequestsCanceled($month){
        $id=\Auth::user()->id;
        $all=Requests::query()
            ->where('requested_by','=',$id)
            ->where('status','LIKE',"Canceled")
            ->where('created_at','LIKE',"{$month}%")->count();
        return $all;
    }

    public static function getWalletBalAdmin(){
        $in=Wallet::query()->sum('amount_in');
        $out=Wallet::query()->sum('amount_out');
        return $in-$out;
    }

    public static function getWalletTotalAdmin($month){
        $in=Wallet::query()
            ->where('created_at','LIKE',"{$month}%")->sum('amount_in');
        return $in;
    }

    public static function getWalletUsedAdmin($month){
        $out=Wallet::query()
            ->where('created_at','LIKE',"{$month}%")->sum('amount_out');
        return $out;
    }

    public static function getWalletRefundedAdmin($month){
        $in=Wallet::query()
            ->where('description','LIKE',"Amount Refunded")
            ->where('created_at','LIKE',"{$month}%")->sum('amount_in');
        return $in;
    }

    public static function getTicketAllAdmin($month){
        $all=Tickets::query()
            ->where('created_at','LIKE',"{$month}%")->count();
        return $all;
    }

    public static function getTicketUsedAdmin($month){
        $all=Tickets::query()
            ->where('status','LIKE',"Checked")
            ->where('created_at','LIKE',"{$month}%")->count();
        return $all;
    }

    public static function getTicketReservedAdmin($month){
        $all=Tickets::query()
            ->where('status','LIKE',"Reserved")
            ->where('created_at','LIKE',"{$month}%")->count();
        $alls=Tickets::query()
            ->where('status','LIKE',"Checked")
            ->where('created_at','LIKE',"{$month}%")->count();
        return $all+$alls;
    }

    public static function getTicketExpiredAdmin($month){
        $all=Tickets::query()
            ->where('status','LIKE',"UnPaid")
            ->where('created_at','LIKE',"{$month}%")->count();
        return $all;
    }

    public static function getRequestsAllAdmin($month){
        $all=Requests::query()
            ->where('created_at','LIKE',"{$month}%")->count();
        return $all;
    }

    public static function getRequestsRequestedAdmin($month){
        $all=Requests::query()
            ->where('status','LIKE',"Requested")
            ->where('created_at','LIKE',"{$month}%")->count();
        return $all;
    }

    public static function getRequestsResolvedAdmin($month){
        $all=Requests::query()
            ->where('status','LIKE',"Resolved")
            ->where('created_at','LIKE',"{$month}%")->count();
        return $all;
    }

    public static function getRequestsCanceledAdmin($month){
        $all=Requests::query()
            ->where('status','LIKE',"Canceled")
            ->where('created_at','LIKE',"{$month}%")->count();
        return $all;
    }


    public static function getTicketUsageAllAdmin($upcoming){
        $all=Tickets::query()
            ->where('upcoming','=',$upcoming)->count();
        return $all;
    }

    public static function getTicketUsageUsedAdmin($upcoming){
        $all=Tickets::query()
            ->where('status','LIKE',"Checked")
            ->where('upcoming','=',$upcoming)->count();
        return $all;
    }

    public static function getTicketUsageReservedAdmin($upcoming){
        $all=Tickets::query()
            ->where('status','LIKE',"Reserved")
            ->where('upcoming','=',$upcoming)->count();
        return $all;
    }

    public static function getTicketUsageExpiredAdmin($upcoming){
        $all=Tickets::query()
            ->where('status','LIKE',"UnPaid")
            ->where('upcoming','=',$upcoming)->count();
        $alls=Tickets::query()
            ->where('status','LIKE',"Canceled")
            ->where('upcoming','=',$upcoming)->count();
        return $all+$alls;
    }

    public static function getSubscribedMembers($id){
        $results = Members::where('plan',$id)->get()->count();
        return $results;
    }
    
    public static function getNames($holder){
        $results = User::where('id',$holder)->get();
        $resultname='';
            foreach($results as $result){
               $resultname= $result['fname'].' '.$result['lname'];
            }
        return $resultname;
    }

    public static function getPlan($id){
        $results = Members_Plan::where('id',$id)->get()->first();
        return $results->plan;
    }

    public static function getIdno($id){
        $results = User::where('id',$id)->get()->first();
        return $results->idno;
    }

    public static function getEmail($id){
        $results = User::where('id',$id)->get()->first();
        return $results->email;
    }
    public static function getPhone($id){
        $results = User::where('id',$id)->get()->first();
        return '254'.$results->phone;
    }

    


    
}

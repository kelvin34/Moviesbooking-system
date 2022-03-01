<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\AdminsController;
use App\Http\Controllers\UpcomingController;
use App\Http\Controllers\ThrillersController;
use App\Http\Controllers\StreamController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[MoviesController::class, 'index']);

Route::get('/movies',[MoviesController::class, 'movies']);
Route::get('/onair',[MoviesController::class, 'onair']);
Route::get('/upcoming',[MoviesController::class, 'upcoming']);

Route::get('/aboutus', function () {
    return view('aboutus');
});
Route::get('/contactus', function () {
    return view('contactus');
});
Route::get('/partners', function () {
    return view('partners');
});

Route::get('/create-client-account',[ThrillersController::class, 'clientAccount']);
Route::post('/accounts/new/client/create',[ThrillersController::class, 'createClientAccount']);

Route::post('/accounts/new/admin/create',[ThrillersController::class, 'newMember']);
Route::post('/accounts/new/plan/create',[MoviesController::class, 'newPlan']);


Route::post('/movies/dash/hist',[MoviesController::class, 'getMonthlyBills']);
Route::post('/admin/movies/dash/hist',[MoviesController::class, 'getMonthlyBillsAdmin']);
Route::post('/admin/movies/dash/hist/requests',[MoviesController::class, 'getMonthlyRequestsAdmin']);
Route::post('/admin/movies/dash/hist/members',[MoviesController::class, 'getMonthlyMembersAdmin']);
Route::post('/admin/movies/dash/hist/movies',[MoviesController::class, 'getMonthlyMoviesAdmin']);
Route::post('/movies/dash/hist/prev',[MoviesController::class, 'getMonthsPrev']);


Route::get('/client/home',[HomeController::class, 'clientdash']);
Route::get('/client/movies',[ClientsController::class, 'clientmovies']);
Route::get('/client/upcoming',[ClientsController::class, 'clientupcoming']);
Route::get('/client/tickets',[ClientsController::class, 'clienttickets']);
Route::get('/client/requests',[ClientsController::class, 'clientrequests']);
Route::get('/client/refunds',[ClientsController::class, 'clientrefunds']);
Route::get('/client/my-account',[ClientsController::class, 'clientmyaccount']);
Route::get('/client/profile',[ClientsController::class, 'clientmyprofile']);


Route::get('/client/myaacount/wallets',[MoviesController::class, 'getAllWallets']);
Route::get('/client/myaacount/payments',[MoviesController::class, 'getAllPayments']);
Route::get('/client/myaacount/membership',[MoviesController::class, 'getMembership']);

Route::get('/admin/myaacount/wallets',[MoviesController::class, 'getAllWalletsAdmin']);
Route::get('/admin/myaacount/payments',[MoviesController::class, 'getAllPaymentsAdmin']);



Route::get('/client/tickets/latest',[MoviesController::class, 'getLatestTickets']);
Route::get('/client/tickets/all',[MoviesController::class, 'getAllTickets']);
Route::get('/client/movie/requests/all',[MoviesController::class, 'getAllRequests']);
Route::get('/client/refunds/all',[MoviesController::class, 'getAllRefundRequests']);


Route::get('/clients/movies/get-streams',[MoviesController::class, 'getStreamDetails']);

Route::get('/admin/movie/requests/all',[MoviesController::class, 'getAllRequestsAdmin']);
Route::get('/admin/refunds/all',[MoviesController::class, 'getAllRefundRequestsAdmin']);


Route::get('/admin/screens/usage/{screen}',[MoviesController::class, 'getScreenUsageMovies']);
Route::get('/client/search/{search}',[MoviesController::class, 'getClientSearch']);


Route::get('/admin/home',[HomeController::class, 'admindash']);
Route::get('/admin/movies',[AdminsController::class, 'adminmovies']);
Route::get('/admin/seach/movies',[AdminsController::class, 'adminsearchMovies']);
Route::get('/admin/onair',[AdminsController::class, 'adminonair']);
Route::get('/admin/upcoming',[AdminsController::class, 'adminupcoming']);
Route::get('/admin/tickets-sales',[AdminsController::class, 'admintickets']);
Route::get('/admin/requests',[AdminsController::class, 'adminrequests']);
Route::get('/admin/refunds',[AdminsController::class, 'adminrefunds']);
Route::get('/admin/screens',[AdminsController::class, 'adminscreens']);
Route::get('/admin/profile',[AdminsController::class, 'adminmyprofile']);
Route::get('/admin/newmember',[AdminsController::class, 'adminmynewmember']);
Route::get('/admin/members',[AdminsController::class, 'adminmymembers']);
Route::get('/admin/plans',[AdminsController::class, 'adminmyplans']);
Route::get('/admin/subscribed',[AdminsController::class, 'adminmysubscribed']);
Route::get('/admin/payments',[AdminsController::class, 'adminmypayments']);
Route::get('/admin/wallets',[AdminsController::class, 'adminmywallets']);

Route::post('/admin/movie/new',[MoviesController::class, 'store']);
Route::post('/admin/screen/new',[MoviesController::class, 'saveScreen']);
Route::post('/admin/upcoming/new',[MoviesController::class, 'setUpcoming']);
Route::post('/admin/upcoming/stream',[MoviesController::class, 'setStream']);
Route::get('/admin/screens/load',[MoviesController::class, 'getScreens']);
Route::get('/admin/movies/load',[MoviesController::class, 'getMovies']);
Route::get('/admin/upcoming/load/{id}',[UpcomingController::class, 'loadUpcomingMovie']);

Route::get('/admin/movies/load/{id}',[MoviesController::class, 'loadAllMoviesAdmin']);

Route::get('/client/movies/load/{id}',[MoviesController::class, 'loadAllMovies']);
Route::get('/client/notifications/unread',[ClientsController::class, 'unread_notifications']);
Route::get('/clients/notifications/diff/{time}',[ClientsController::class, 'timeDiff']);
Route::get('/client/notifications/{id}',[ClientsController::class, 'selNotifications']);
Route::get('/client/notifications',[ClientsController::class, 'Notifications'])->middleware("verified");


Route::get('/client/movies/streams/count',[ClientsController::class, 'streamscount']);

Route::get('/admin/notifications/{id}',[AdminsController::class, 'selNotifications']);
Route::get('/admin/notifications',[AdminsController::class, 'Notifications'])->middleware("verified");

Route::post('/admin/screen/update',[MoviesController::class, 'updateScreenSeats']);
Route::post('/client/movie/seats/book',[MoviesController::class, 'bookSeat']);
Route::post('/client/movie/ticket/pay',[MoviesController::class, 'payTicket']);
Route::post('/client/movie/ticket/checkin',[MoviesController::class, 'checkinTicket']);
Route::post('/client/movie/ticket/cancel',[MoviesController::class, 'cancelTicket']);

Route::post('/client/movie/requests/new',[MoviesController::class, 'newMovieRequests']);
Route::post('/client/refund/request/new',[MoviesController::class, 'newRefundRequests']);


Route::post('/admin/movie/requests/response',[MoviesController::class, 'respondMovieRequests']);
Route::post('/admin/refund/requests/response',[MoviesController::class, 'respondRefundRequests']);


Route::post('/admin/movie/ticket/checkin',[MoviesController::class, 'checkinTicketAccept']);

Route::get('/viewers/seats/get/{id}/{upcoming}',[MoviesController::class, 'getClientSeats']);
Route::get('/admin/seats/get/{id}/{upcoming}',[MoviesController::class, 'getMovieSeats']);
Route::get('/admin/seats/get/status/{seat_id}/{upcoming}/{ticket_id}/{availability}',[MoviesController::class, 'getBookedHolderStatus']);

Route::get('/client/accounts/get/membership/status/{amount}/{wallet}',[MoviesController::class, 'getPackageStatus']);
Route::get('/client/accounts/pay/membership/{amount}/{wallet}/{id}/{member}/{days}/{plan}',[MoviesController::class, 'payPackageAmountWallet']);

Route::get('/client/accounts/pay/package/{amount}/{wallet}/{id}/{member}/{days}/{plan}/{paid}/{trans}',[MoviesController::class, 'payPackageAmount']);


Route::get('/client/seats/get/status/{seat_id}/{upcoming}/{ticket_id}/{availability}',[MoviesController::class, 'getBookedHolderStatusClient']);

Route::get('/admin/seats/set/{id}',[MoviesController::class, 'setSeats']);
Route::get('/admin/seats/get/{id}',[MoviesController::class, 'getSeats']);
Route::get('/admin/seats/section/{id}',[MoviesController::class, 'getSeatsSections']);
Route::get('/admin/seats/tickets/{id}',[MoviesController::class, 'getBookedTickets']);


Route::get('/admin/movies/delete/{id}',[MoviesController::class, 'deleteMovie']);




Route::get('/client/tickets/unpaid',[MoviesController::class, 'updateExpiredUnpaid']);

// Route::post('/client/movies/stream/now', function () {
    // $filePath=$request->input('path');
    // echo $filePath;
    // $stream = new VideoStream($filePath);
    // $stream->start();
    // $stream= new StreamController();
// });
Route::get('/player', function () {
    $video = "video/os_simpsons_s25e22_720p.mp4";
    $mime = "video/mp4";
    $title = "Os Simpsons";

    return view('player')->with(compact('video', 'mime', 'title'));
});


Route::get('/client/movies/stream/now/{filename}', function ($filename) {
    // $videosDir = base_path('public/assets/movies');
    $filePath=$filename;

    if (file_exists($filePath)) {
        $stream = new StreamController($filePath);

        return response()->stream(function() use ($stream) {
            $stream->start();exit();
        });
    }

    return response("Stream doesn't exists", 404);


    // $videosDir = base_path('public/assets/movies');
    // $filePath=$request->input('path');
    // $stream= new StreamController($filePath);
    // $stream->start();

    // if (file_exists($filePath = $videosDir."/".$filename)) {
    //     $stream = new StreamController($filePath);

    //     return response()->stream(function() use ($stream) {
    //         $stream->start();exit();
    //     });
    // }

    // return response("File doesn't exists", 404);
});

// Route::post('/client/movies/stream/now',[MoviesController::class, 'streamnow'])->middleware("verified");

Route::post('/admin/movie/thriller/add',[MoviesController::class, 'uploadThriller'])->middleware("verified");
Route::post('/admin/movie/cover/add',[MoviesController::class, 'uploadCover'])->middleware("verified");
Route::resource('homeusers', HomeController::class);
Route::resource('clients', ClientsController::class);
Auth::routes(['verify' => true]);
// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
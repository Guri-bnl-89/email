<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Frontend routes
Auth::routes();
Route::get('/', function () { return view('home.index'); })->name('front');
Route::get('/about-us', function () { return view('home.aboutus'); })->name('about-us');
Route::get('/pricing', function () { return view('home.pricing'); })->name('pricing');
Route::get('/contact', function () { return view('home.contact'); })->name('contact');
Route::get('/blog', function () { return view('home.blog'); })->name('blog');
Route::get('/tos', function () { return view('home.tos'); })->name('tos');
Route::get('/privacy', function () { return view('home.privacy'); })->name('privacy');
Route::get('/faqs', function () { return view('home.faqs'); })->name('faqs');
Route::get('/data-policy', function () { return view('home.data-policy'); })->name('data-policy');
Route::get('/cookie-policy', function () { return view('home.cookie-policy'); })->name('cookie-policy');
Route::get('/refund-policy', function () { return view('home.refund-policy'); })->name('refund-policy');
Route::get('/gdpr-policy', function () { return view('home.gdpr-policy'); })->name('gdpr-policy');
Route::get('/zerobounce-alternative', function () { return view('home.zerobounce-alternative'); })->name('zerobounce-alternative');
Route::get('/neverbounce-alternative', function () { return view('home.neverbounce-alternative'); })->name('neverbounce-alternative');
Route::get('/xverify-alternative', function () { return view('home.xverify-alternative'); })->name('xverify-alternative');
Route::get('/briteverify-alternative', function () { return view('home.briteverify-alternative'); })->name('briteverify-alternative');
Route::get('/features', function () { return view('home.features'); })->name('features');
Route::get('/error', function () { return view('page.error'); })->name('error');
Route::post('/webhookRazorpay', [WebhookController::class, 'webhookRazorpay'])->name('webhookRazorpay');

//Route::get('/forgot-password', function () { return view('home.forgot_password'); })->name('forgot-password');


Route::group(['middleware' => 'auth'], function () { 
    //Verification controller routes
    Route::get('/list', [VerificationController::class, 'list'])->name('list');
    Route::get('/list_data', [VerificationController::class, 'listData'])->name('list_data');
    Route::get('/result/{id}', [VerificationController::class, 'result'])->name('result');
    Route::post('/emailVerifyRequest', [VerificationController::class, 'emailVerifyRequest'])->name('emailVerifyRequest');
    Route::post('/validateEmailsRequest', [VerificationController::class, 'validateEmailsRequest'])->name('validateEmailsRequest');
    Route::post('/validateSingleEmailRequest', [VerificationController::class, 'validateSingleEmailRequest'])->name('validateSingleEmailRequest');
    Route::post('/downloadCsvFile', [VerificationController::class, 'downloadCsvFile'])->name('downloadCsvFile');
    Route::get('/singleEmail', [VerificationController::class, 'singleEmail'])->name('singleEmail');
        
    //User controller routes
    Route::get('/logout', [UserController::class, 'logout']);
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile', [UserController::class, 'profileEdit'])->name('profileEdit');
    
    //Payment controller routes
    Route::get('/orders', [PaymentController::class, 'orders'])->name('orders');
    Route::get('/purchase', [PaymentController::class, 'purchase'])->name('purchase');
    Route::get('/checkout/{id}', [PaymentController::class, 'checkout'])->name('checkout');
    Route::post('/discount', [PaymentController::class, 'discount'])->name('discount');
    Route::post('/createOrder', [PaymentController::class, 'createOrder'])->name('createOrder');
    Route::post('/addPlan', [PaymentController::class, 'addPlan'])->name('addPlan');
    Route::post('/editPlan', [PaymentController::class, 'editPlan'])->name('editPlan');
    Route::get('/deletePlan/{id}', [PaymentController::class, 'deletePlan'])->name('deletePlan');

    //Chat controller routes
    Route::get('/support', [ChatController::class, 'support'])->name('support');
    Route::post('/support', [ChatController::class, 'supportAdd'])->name('supportAdd');
    Route::post('/getChat', [ChatController::class, 'getChat'])->name('getChat');
    Route::post('/addChat', [ChatController::class, 'addChat'])->name('addChat');
    Route::post('/closeTicket', [ChatController::class, 'closeTicket'])->name('closeTicket');
    
    //Home controller routes
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/reportsChartData', [HomeController::class, 'reportsChartData'])->name('reportsChartData');
    Route::get('/orders_list', [HomeController::class, 'orders_list'])->name('orders_list');
    Route::get('/front_home', [HomeController::class, 'front_home'])->name('front_home');
    Route::get('/front_about', [HomeController::class, 'front_about'])->name('front_about');
    Route::get('/front_pricing', [HomeController::class, 'front_pricing'])->name('front_pricing');
    Route::get('/front_contact', [HomeController::class, 'front_contact'])->name('front_contact');
    
    //Admin controller routes
    Route::get('/usersList', [AdminController::class, 'usersList'])->name('usersList');
    Route::post('/userUpdate', [AdminController::class, 'userUpdate'])->name('userUpdate');
    Route::get('/deleteUser/{id}', [AdminController::class, 'deleteUser'])->name('deleteUser');

});

// Route::get('/', function () { return view('welcome'); })->name('home');
// Auth::routes();

//  Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

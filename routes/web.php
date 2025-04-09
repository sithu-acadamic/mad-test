<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\AboutUsController;
use App\Http\Controllers\User\ContactController;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return redirect('/login'); // Redirect to the login page
});

Auth::routes();
Route::get('ajax-regen-captcha', [App\Http\Controllers\Auth\LoginController::class,'getCaptcha']);

Route::get('/test', function () {
    return response()->json(['message' => 'API is working']);
});

Route::get('partner-logo', [\App\Http\Controllers\API\APIController::class,'partnerLogo']);
Route::get('section-logo', [\App\Http\Controllers\API\APIController::class,'sectionImages']);
Route::get('team-members', [\App\Http\Controllers\API\APIController::class,'getTeamMembers']);
Route::get('google-review', [\App\Http\Controllers\API\APIController::class,'getGoogleReview']);
Route::get('our-service', [\App\Http\Controllers\API\APIController::class,'getOurService']);
Route::get('blog-post', [\App\Http\Controllers\API\APIController::class,'getBlogPost']);


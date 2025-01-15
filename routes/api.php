<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LandingPageController;
use App\Http\Controllers\Api\EventsController;
use App\Http\Controllers\Api\PostsController;
use App\Http\Controllers\Api\PartnersController;
use App\Http\Controllers\Api\AboutController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['throttle:60,1', \App\Http\Middleware\CorsMiddleware::class])->group(function () {
    Route::get('/landing-page', [LandingPageController::class, 'getLandingPageData']);
    //Events
    Route::get('/events/little', [EventsController::class, 'getLittleEventsData']);
    Route::get('/events', [EventsController::class, 'getAllEventsData']);
    Route::get('/events/{slug}', [EventsController::class, 'getOneEventData']);
    //Blogs
    Route::get('/posts/little', [PostsController::class, 'getLittlePostsData']);
    Route::get('/posts', [PostsController::class, 'getAllPostsData']);
    Route::get('/posts/{slug}', [PostsController::class, 'getOnePostData']);

    //Partners
    Route::get('/partners/little', [PartnersController::class, 'getLittlePartnersData']);
    Route::get('/partners', [PartnersController::class, 'getAllPartnersData']);
    Route::get('/partners/{id}', [PartnersController::class, 'getOnePartnerData']);

    //About
    Route::get('/about', [AboutController::class, 'getAbout']);
});

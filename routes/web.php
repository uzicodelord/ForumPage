<?php

use App\Http\Controllers\CategoryAdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\ReplyController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Route::get('/ranking', [RankingController::class, 'index'])->name('ranking.index');

Route::get('/', [ForumController::class, 'index'])->name('forum.index');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::get('/categories/{category:name}', [CategoryController::class, 'index'])->name('categories.index');
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/viewcategory', [CategoryAdminController::class, 'create'])->name('categories.create');
    Route::post('/addcategory', [CategoryAdminController::class, 'store'])->name('categories.store');
});

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
Route::post('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
Route::post('/posts/{post}/replies', [ReplyController::class, 'store'])->name('replies.store');
Route::post('/posts/{post}/reactions', [App\Http\Controllers\ReactionController::class, 'store'])->name('reactions.store');
Route::post('/posts/{post}/vote', [PostController::class, 'vote'])->name('posts.vote');

Route::get('/profiles/{id}', [ProfileController::class, 'show'])->name('profiles.show');
Route::get('/profiles/{id}/edit', [ProfileController::class, 'edit'])->name('profiles.edit');
Route::put('/profiles', [ProfileController::class, 'update'])->name('profiles.update');
Route::put('/profile/{user}/update-rank', [ProfileController::class, 'updateRank'])->middleware('admin')->name('profile.updateRank');
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index')->middleware('auth');

Route::get('/read-notification/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
Route::get('/delete-notification/{id}', [NotificationController::class, 'deleteNotification'])->name('notifications.delete');

Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat', [App\Http\Controllers\ChatController::class, 'store'])->name('chat.store');
});

Route::get('/search', [App\Http\Controllers\SearchController::class, 'index'])->name('search.index');

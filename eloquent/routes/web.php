<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Route;

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

Route::get('eloquent', function () {
    $posts = Post::where('id','>=','20')->orderBy('id', 'desc')->take(3)->get();

    //$posts = Post::all();
    foreach ($posts as $post) {
        echo "$post->id $post->title <br>";
    }
});


Route::get('posts', function () {
    $posts = Post::get();

    //$posts = Post::all();
    foreach ($posts as $post) {
        echo "$post->id - $post->get_title <strong> {$post->user->get_name} </strong> <br>";
    }
});


Route::get('users', function () {
    $users = User::get();

    //$posts = Post::all();
    foreach ($users as $user) {
        echo "$user->id - $user->name <strong> {$user->posts->count()} </strong> <br>";
    }
});


Route::get('collections', function () {
    $users = User::all();
    dd($users->load('posts'));
    dd($users->find([1]));
    dd($users->only([1,2,3,4]));
    dd($users->except([1,2,3,4]));
    dd($users->contains(4));
    //$posts = Post::all();

});

Route::get('serealization', function () {
    $users = User::all();
    $user = $users->find(1);
    dd($user->toJson());
    dd($user);
  dd($users->toArray());

});

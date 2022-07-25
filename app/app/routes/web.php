<?php

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

// Route::get('/', function () {
//     return view('home.index', []);
// })->name('home.index');

// Route::get('/contact', function () {
//     return view('home.contact', []);
// })->name('home.contact');

Route::view('/', 'home.index')
    ->name('home.index');
Route::view('/contact', 'home.contact')
    ->name('home.contact');

$posts = [
    1 => [
        'title' => 'Intro to Laravel',
        'content' => 'This is a short intro to Laravel',
        'is_new' => true,
        'has_comments' => true
    ],
    2 => [
        'title' => 'Intro to PHP',
        'content' => 'This is a short intro to PHP',
        'is_new' => false,
        'has_comment' => false
    ],
    3 => [
        'title' => 'Intro to GO',
        'content' => 'This is a short intro to GO',
        'is_new' => false,
        'has_comment' => false
    ]
];

Route::get('/posts', function() use ($posts) {
    return view('posts.index', ['posts' => $posts]);
});

Route::get('/posts/{id}', function ($id) use ($posts) {
    abort_if(!isset($posts[$id]), 404);

    return view('posts.show', ['post' => $posts[$id]]);
})->where([
    'id' => '[0-9]+'
])->name('posts.show');

Route::get('/recent-posts/{days_ago?}', function ($daysAgo = 20) {
    return $daysAgo;
})->name('posts.recent.index');

$strs = ["abca","aba","aaab"];

Route::get('/test', function () use ($strs) {
    $prefix = $strs[0];

    $x = 1;
    while ($x < count($strs)) {
        if (strlen($strs[$x]) < strlen($prefix)) $prefix = $strs[$x];
        $x++;
    }
    $p = str_split($prefix);
    $y = 0;
    $l = 0;
    while ($y < count($strs)) {
        if ($strs[$y] == $prefix) {
            $y++;
            continue;
        }
        for ($i = 0; $i < strlen($prefix); $i++) {
            if (str_split($strs[$y])[$i] != str_split($prefix)[$i] || $l) {
                unset($p[$i]);
                $l = 1;
            }
        }
        $y++;
    }

    return implode("", $p);
});
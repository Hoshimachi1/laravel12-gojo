<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/active/index', function () {
    return view('active/index');
})->name('index');

Route::get('/gallery', function () {
    $ant = 'https://cdn3.movieweb.com/i/article/Oi0Q2edcVVhs4p1UivwyyseezFkHsq/1107:50/Ant-Man-3-Talks-Michael-Douglas-Update.jpg';
    $bird = 'https://images.indianexpress.com/2021/03/falcon-anthony-mackie-1200.jpg';
    $cat = 'https://media.newyorker.com/photos/5a875e3f33aebd0cab9bab12/master/w_2560%2Cc_limit/Brody-Passionate-Politics-Black-Panther.jpg';
    $god = 'https://www.blackoutx.com/wp-content/uploads/2021/04/Thor.jpg';
    $spider = 'https://icdn5.digitaltrends.com/image/spiderman-far-from-home-poster-2-720x720.jpg';

    return view('test/index', compact('ant', 'bird', 'cat', 'god', 'spider'));
});

Route::get('/gallery/ant', function () {
    $ant = 'https://cdn3.movieweb.com/i/article/Oi0Q2edcVVhs4p1UivwyyseezFkHsq/1107:50/Ant-Man-3-Talks-Michael-Douglas-Update.jpg';

    return view('test/ant', compact('ant'));
});

Route::get('/gallery/bird', function () {
    $bird = 'https://images.indianexpress.com/2021/03/falcon-anthony-mackie-1200.jpg';

    return view('test/bird', compact('bird'));
});

Route::get('/gallery/cat', function () {
    $cat = 'https://media.newyorker.com/photos/5a875e3f33aebd0cab9bab12/master/w_2560%2Cc_limit/Brody-Passionate-Politics-Black-Panther.jpg';

    return view('test/cat', compact('cat'));
});

Route::get('/test', function () {
    return view('test');
})->name('test');

Route::get('/coronavirus', function () {
    $reports = [
        (object) ['country' => 'China', 'date' => '2020-04-19', 'total' => '2765', 'active' => '790', 'death' => '47', 'recovered' => '1928'],
        (object) ['country' => 'Thailand', 'date' => '2020-04-18', 'total' => '2733', 'active' => '899', 'death' => '47', 'recovered' => '1787'],
        (object) ['country' => 'Thailand', 'date' => '2020-04-17', 'total' => '2700', 'active' => '964', 'death' => '47', 'recovered' => '1689'],
        (object) ['country' => 'Thailand', 'date' => '2020-04-16', 'total' => '2672', 'active' => '1033', 'death' => '46', 'recovered' => '1593'],
        (object) ['country' => 'Thailand', 'date' => '2020-04-15', 'total' => '2643', 'active' => '1103', 'death' => '43', 'recovered' => '1497'],
    ];

    return view('coronavirus', compact('reports'));
})->name('coronavirus');

Route::get('/active/teacher', function () {
    $teachers = json_decode(file_get_contents('https://raw.githubusercontent.com/arc6828/laravel8/main/public/json/teachers.json'));

    return view('active.teacher', compact('teachers'));
})->name('active.teacher');

Route::get('/category/sport', [CategoryController::class, 'sport']);
Route::get('/category/politic', [CategoryController::class, 'politic']);
Route::get('/category/entertain', [CategoryController::class, 'entertain']);
Route::get('/category/auto', [CategoryController::class, 'auto']);

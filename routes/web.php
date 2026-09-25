<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

require __DIR__ . '/auth.php';

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


Route::get('query/sql', function () {
    $products = DB::select("SELECT * FROM products");
    // $products = DB::select("SELECT * FROM products WHERE price > 100");
    return view('query-test', compact('products'));
});

Route::get('query/builder', function () {
    $products = DB::table('products')->get();
    // $products = DB::table('products')->where('price', '>', 100)->get();
    return view('query-test', compact('products'));
});

Route::get('query/orm', function () {
    $products = Product::get();
    // $products = Product::where('price', '>', 100)->get();
    return view('query-test', compact('products'));
});

// Route::get('product/form', function () {
//     //
// })->name("product.form");

Route::get('barchart', function () {    
    return view('barchart');
})->name('barchart');


Route::get('product-index', function () {
    $products = Product::get();
    return view('query-test', compact('products'));
})->name("product.index");


Route::get('product-form', function () {    
    return view('product-form');
})->name("product.form"); 


Route::post('/product-submit', function (Request $request) {    
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);    

    // ตรวจสอบว่ามีการอัปโหลดรูปภาพ
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('uploads', 'public');
        $url = Storage::url($imagePath);
        $data["image"] =$url;
    }

    // บันทึกข้อมูลในฐานข้อมูล
    Product::create($data);

    return redirect()->route('product.index')->with('success', 'เพิ่มสินค้าแล้ว!');
})->name('product.submit');


use App\Http\Controllers\WeightController;

Route::resource('weights', WeightController::class);
Route::get('/', [WeightController::class, 'index']);

Route::resource('license', LicenseController::class);
Route::resource('user', UserController::class);
Route::resource('vehicle', VehicleController::class);

use App\Http\Controllers\AboutMeController;

// 1. หน้า /about-me
Route::get('/about-me', [AboutMeController::class, 'index'])->name('about-me');

// 2. ลิงก์งานต่าง ๆ (EP02 - EP08)
// หมายเหตุ: หากมี Route เดิมของ EP เหล่านี้อยู่แล้ว สามารถใช้ Route เดิมได้เลย
Route::get('/active/index', function () {
    return view('active/index');
})->name('index');

Route::get('/active/index', function () {
    return view('active/index');
})->name('index');

Route::get('/', function () {
    return view('weights.index');
})->name('weights');

Route::get('/', function () {
    return view('welcome');
});
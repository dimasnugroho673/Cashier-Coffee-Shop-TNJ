<?php

use App\Models\User;
use App\Models\RoleUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\MenuController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\DashboardController;

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

Route::get('/test', function () {
    // return view('welcome');
    // $datas = RoleUser::join('users', 'users.id', '=', 'role_users.user_id')
    // ->join('roles', 'roles.id', '=', 'role_users.role_id')
    // ->get();

    $datas = RoleUser::get();

    foreach ($datas as $d) {
        echo $d->user->name . " -> " . $d->role->name . isActive( $d->user->id) . "</br>";
    }



    echo "</br>";
    echo "</br>";
    echo "==================";
    echo "</br>";
    echo "User Login: " . auth()->user()->name;  

    $roleUsers = RoleUser::get();

    foreach ($roleUsers as $ru) {
        if ((auth()->user()->id == $ru->user->id) && ($ru->role->name == 'cashier')) {
            echo "true";
        }
    }
});

function isActive($id) {
    if ($id == auth()->user()->id) {
        return ' - active';
    }
}

Auth::routes();

Route::get('/', function()
{
    return redirect('/login');
});

Route::middleware('can:admin')->group(function () {
    Route::group(['prefix' => 'backend'], function(){
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('backend.dasboard');
        Route::get('/menu', [MenuController::class, 'index'])->name('backend.dasboard');
        Route::resource('/backend/ketegori',CategoryController::class)->except('show');
        Route::get('/users', [UserController::class, 'index'])->name('backend.users');
        Route::get('/users/json', [UserController::class, 'json'])->name('backend.users.json');
        Route::delete('/user/destroy/{id}', [UserController::class, 'destroy'])->name('backend.users.destroy');
        Route::post('/user', [UserController::class, 'create'])->name('backend.users.create');
    });

});

Route::middleware('can:cashier')->group(function () {
    Route::get('/order', [OrderController::class, 'index'])->name('frontend.order');
});

Route::get('/seeder', function()
{
    for ($i=0; $i < 1000000; $i++) { 
        User::create([
            'name' => "User Dummy $i",
            'email' => "dummy$i@gmail.com",
            'password' => bcrypt('12345678'),
            'photo' => ''
        ]);
    }
});

Route::get('/truncate', function()
{
    DB::table('users')->delete();
});

// Route::middleware('auth')->group(function () {
//     Route::view('about', 'about')->name('about');

//     Route::get('users', [UserController::class, 'index'])->name('users.index');

//     Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
//     Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
// });

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
use App\Http\Controllers\Backend\PurchaseController;
use App\Http\Controllers\Backend\TableController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SettingController;

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

Route::middleware(['can:admin', 'auth'])->group(function () {
    Route::group(['prefix' => 'backend'], function(){
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('backend.dasboard');
        Route::get('/menu', [MenuController::class, 'index'])->name('backend.dasboard');

        // Route::resource('/kategori',CategoryController::class)->except('show');

        Route::get('/category',[CategoryController::class,'index'])->name('backend.category');
        Route::post('/category/create',[CategoryController::class,'create'])->name('backend.category.create');
        Route::get('/category/{id}',[CategoryController::class,'edit'])->name('backend.category.edit');
        Route::put('category/{id}',[CategoryController::class,'update'])->name('backend.category.update');
        Route::delete('/category/destroy/{id}',[CategoryController::class,'destroy'])->name('backend.category.destroy');

        Route::get('/users', [UserController::class, 'index'])->name('backend.users');
        Route::post('/user/email-validator', [UserController::class, 'emailValidator'])->name('backend.users.email-validator');
        Route::post('/user', [UserController::class, 'create'])->name('backend.users.create');
        Route::get('/user/{id}', [UserController::class, 'show'])->name('backend.users.show');
        Route::put('/user/{id}', [UserController::class, 'update'])->name('backend.users.update');
        Route::delete('/user/{id}', [UserController::class, 'delete'])->name('backend.users.destroy');

        Route::get('/tables', [TableController::class, 'index'])->name('backend.tables');
        Route::post('/table', [TableController::class, 'create'])->name('backend.tables.create');
        Route::post('/table-increase', [TableController::class, 'increaseTable'])->name('backend.tables.table-increase');
        Route::put('/table-decrease', [TableController::class, 'decreaseTable'])->name('backend.tables.table-decrease');
        Route::get('/table/{id}', [TableController::class, 'show'])->name('backend.tables.show');
        Route::put('/table/{id}', [TableController::class, 'update'])->name('backend.tables.update');
        Route::delete('/table/{id}', [TableController::class, 'delete'])->name('backend.tables.destroy');

        Route::get('/finance/purchases', [PurchaseController::class, 'index'])->name('backend.purchases');
        Route::post('/finance/purchase', [PurchaseController::class, 'create'])->name('backend.purchases.create');
        Route::get('/finance/purchase/{id}', [PurchaseController::class, 'show'])->name('backend.purchases.show');
        Route::put('/finance/purchase/{id}', [PurchaseController::class, 'update'])->name('backend.purchases.update');
        Route::delete('/finance/purchase/{id}', [PurchaseController::class, 'delete'])->name('backend.purchases.destroy');

        Route::get('/setting',[SettingController::class,'index'])->name('backend.setting');
        Route::put('/setting/update-general-data',[SettingController::class,'updateGeneralData'])->name('backend.setting.generaldata');
        Route::put('setting/update-modal',[SettingController::class,'updateModal'])->name('backend.setting.updateModal');
        Route::put('setting/update-icons',[SettingController::class,'updateLogo'])->name('backend.setting.updateLogo');
    });
});

Route::middleware(['can:cashier', 'auth'])->group(function () {
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

<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Livewire;
use Illuminate\Http\Request;

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

Route::get('/', function () {
    return view('welcome');
});

Route::post("/livewire", function (Request $request) {
    $snapshot = $request->get("snapshot");
    $component = (new Livewire())->fromSnapshot($snapshot);
    if ($method = $request->get("callMethod")) {
        (new Livewire())->callMethod($component, $method);
    }
    [$html, $snapshot] = (new Livewire())->toSnapshot($component);
    return [$html, $snapshot];
});

Blade::directive("livewire", function ($class) {
    return "<?php echo (new \App\Livewire\Livewire())->initComponent($class); ?>";
});

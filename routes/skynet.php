<?php
use App\Http\Controllers\SkynetController;
Route::get('skynet', [SkynetController::class, 'index']);
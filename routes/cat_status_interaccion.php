<?php
use App\Http\Controllers\Cat_status_interaccionController;
Route::get('cat_status_interaccion', [Cat_status_interaccionController::class, 'index']);
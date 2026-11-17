<?php

use App\Http\Controllers\InterviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('interviews.index'));

Route::controller(InterviewController::class)->prefix('interviews')->name('interviews.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/', 'store')->name('store');
    Route::get('/{interview}', 'show')->name('show');
    Route::get('/{interview}/drill-down', 'drillDown')->name('drilldown');
    Route::delete('/{interview}', 'destroy')->name('destroy');
});

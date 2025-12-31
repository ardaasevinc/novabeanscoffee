<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\IndexController;
use App\Http\Controllers\Site\About\IndexController as AboutController;
use App\Http\Controllers\Site\Contact\IndexController as ContactController;
use App\Http\Controllers\Site\Blog\IndexController as BlogController;
use App\Http\Controllers\Site\Menu\IndexController as MenuController;
use App\Http\Controllers\Site\Booktable\IndexController as BooktableController;
use App\Http\Controllers\Site\Services\IndexController as ServicesController;

use App\Http\Controllers\Site\Reservation\IndexController as ReservationController;


Route::get('/', [IndexController::class, 'entry'])->name('site.index2');
Route::get('/anasayfa', [IndexController::class, 'index'])->name('site.index');
Route::get('/hakkimizda', [AboutController::class, 'index'])->name('site.about');
Route::get('/bize-ulasin', [ContactController::class, 'index'])->name('site.contact');
Route::get('/haberler', [BlogController::class, 'index'])->name('site.blog');
Route::get('/haber/{slug}', [BlogController::class, 'detail'])->name('site.blog.detail');
Route::get('/menu', [MenuController::class, 'index'])->name('site.menu');
Route::get('/hizmetler', [ServicesController::class, 'index'])->name('site.services');
Route::get('/hizmetler/{slug}', [ServicesController::class, 'detail'])->name('site.services.detail');
Route::post('/iletisim-gonder', [ContactController::class, 'contactStore'])->name('contact.store');
Route::get('/rezervasyon', [ReservationController::class, 'index'])->name('site.reservation');
Route::post('/rezervasyon-yap', [ReservationController::class, 'store'])->name('site.reservation.store');

Route::get('/blog/kategori/{slug}', [BlogController::class, 'categoryIndex'])->name('site.blog.category');


<?php

use App\Http\Controllers\CdStatisticsController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\MqqtController;
use App\Http\Controllers\StreamController;

use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Auth;
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

Route::redirect('/', '/home');


Route::middleware(['auth'])->group(function() {
    Route::get('/streamlist', [StreamController::class, 'showStream'])->name('streamlist');
    
    Route::get('/private/img/{imageName}', [FileController::class, 'showimage'])->name('img.show');
    Route::get('/realtime/{deviceid}', [CdStatisticsController::class, 'realtime'])->name('cd.realtime');
    Route::get('/rtlc/{deviceid}', [CdStatisticsController::class, 'rtlc'])->name('rtlc');
    Route::get('/rtsr/{deviceid}', [CdStatisticsController::class, 'rtsr'])->name('rtsr');
    
    Route::get('/stream/{id}/raw', [StreamController::class, 'rawstream'])->name('rawstream');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/datarecord/{id}', [CdStatisticsController::class, 'showlist'])->name('datarecord');
    Route::get('/datarecord/{id}/{date}', [CdStatisticsController::class, 'showlistdetail'])->name('datarecorddetail');
    Route::get('/statistic/{id}/filter', [CdStatisticsController::class, 'showplainfilt'])->name('cdstatisticfilt');
    Route::get('/statistic/{id}/{date}/{enddate}/{ftime}/{totime}', [CdStatisticsController::class, 'show'])->name('cdstatistic');
    Route::get('/statistic/{id}/realtime', [CdStatisticsController::class, 'showrt'])->name('cdstatisticrt');
    Route::get('/excelexport', [ExportController::class, 'exportToExcel'])->name('ex.export');
});


Route::middleware(['admin'])->group(function() {
    Route::post('/singledeldatarecord', [CdStatisticsController::class, 'singledeldatarecord'])->name('singledeldatarecord');
    Route::post('/datarecord/del', [CdStatisticsController::class, 'delrecord'])->name('delrecord');
    Route::get('/addstream', [StreamController::class, 'addStream'])->name('addstream');
    Route::post('/storeStream', [StreamController::class, 'storeStream'])->name('storeStream');
    Route::post('/storeUpdateStream', [StreamController::class, 'updateStream'])->name('storeUpStream');
    Route::post('/delstream', [StreamController::class, 'delStream'])->name('delstream');
    Route::get('/streamlist/{id}/edit', [StreamController::class, 'editStream'])->name('editstream');
    Route::get('/mqqtconfig', [MqqtController::class, 'index'])->name('mqqtconf');
    Route::get('/startsubmqqt', [MqqtController::class, 'start'])->name('startmqqtsub');
    Route::post('/mqqtconfigStore', [MqqtController::class, 'store'])->name('storeMqqconf');
});

Auth::routes();


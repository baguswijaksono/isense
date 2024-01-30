<?php

use App\Http\Controllers\CdStatisticsController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MqqtController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StreamController;

use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/home');

//Grup Endpoint khusus user terautentikasi
Route::middleware(['auth'])->group(function() {

    //Endpoint setelah berhasil autentikasi
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');//done
    Route::get('/askforit', [HomeController::class, 'ask'])->name('ask');//done

});

//Grup Endpoint khusus user terautentikasi dan mempunyai role 'admin'
Route::middleware(['admin'])->group(function() {
        //Endpoint untuk list raw stream yang tersedia
        Route::get('/streamlist', [StreamController::class, 'showStream'])->name('streamlist');//done

        //Endpoint untuk halaman raw stream
        Route::get('/stream/{id}/raw', [StreamController::class, 'rawstream'])->name('rawstream');//done
        
        //Endpoint untuk dis12play gambar 
        Route::get('/private/img/{imageName}', [FileController::class, 'showimage'])->name('img.show');//done
    
        //Endpoint untuk display JSON data terbaru yang ada di collection cd_statistics 
        Route::get('/realtime/{deviceid}', [CdStatisticsController::class, 'realtime'])->name('cd.realtime');//done
    
        //Endpoint untuk view realtime realtime linechart
        Route::get('/rtlc/{deviceid}', [CdStatisticsController::class, 'rtlc'])->name('rtlc');
    
        //Endpoint untuk view realtime statistic report
        Route::get('/rtsr/{deviceid}', [CdStatisticsController::class, 'rtsr'])->name('rtsr');
        
        //Endpoint untuk display data record collection cdstatistics
        Route::get('/datarecord/{id}', [CdStatisticsController::class, 'showlist'])->name('datarecord');//done
        Route::get('/datarecord/{id}/{date}', [CdStatisticsController::class, 'showlistdetail'])->name('datarecorddetail');//done
    
        //Endpoint untuk display statistic crowd detection yang difilter 
        Route::get('/statistic/{id}/filter', [CdStatisticsController::class, 'showplainfilt'])->name('cdstatisticfilt');
        Route::get('/statistic/{id}/{date}/{enddate}/{ftime}/{totime}', [CdStatisticsController::class, 'show'])->name('cdstatistic');
    
        //Endpoint untuk display statistic crowd detection secara realtime 
        Route::get('/statistic/{id}/realtime', [CdStatisticsController::class, 'showrt'])->name('cdstatisticrt');
    
        //Endpoint untuk export data ke excel 
        Route::get('/excelexport', [ExportController::class, 'exportToExcel'])->name('ex.export');
        Route::get('/ocarchive', [CdStatisticsController::class, 'ocarchive'])->name('ocarchive');
    
    
        Route::get('/overcrowd', [CdStatisticsController::class, 'overcrowdhs'])->name('overcrowd');
        Route::get('/alerts/{deviceid}', [CdStatisticsController::class, 'alerts'])->name('alerts');

        
    Route::post('/ocarchive/del', [CdStatisticsController::class, 'socarchivedel'])->name('socarchivedel');
    Route::get('/markasseen/{alertsid}', [CdStatisticsController::class, 'markasseen'])->name('markasseen');
     //Endpoint untuk pengaturan mqqt 
    Route::get('/rtconfig', [CdStatisticsController::class, 'rtconfiglist'])->name('rtconfiglist');
    Route::get('/rtconfig/{deviceid}', [CdStatisticsController::class, 'rtconfig'])->name('rtconfig');
    Route::post('/rtmqqtconfigStore', [CdStatisticsController::class, 'rtconfigstore'])->name('rtconfigstore');//done

    //Endpoint untuk export data ke excel 
    Route::post('/singledeldatarecord', [CdStatisticsController::class, 'singledeldatarecord'])->name('singledeldatarecord');//done
    Route::post('/datarecord/del', [CdStatisticsController::class, 'delrecord'])->name('delrecord');//done

    //Endpoint Create data raw stream
    Route::get('/addstream', [StreamController::class, 'addStream'])->name('addstream');//done
    Route::post('/storeStream', [StreamController::class, 'storeStream'])->name('storeStream');//done

    //Endpoint Update data raw stream
    Route::get('/streamlist/{id}/edit', [StreamController::class, 'editStream'])->name('editstream');//done
    Route::post('/storeUpdateStream', [StreamController::class, 'updateStream'])->name('storeUpStream');//done

    //Endpoint Delete data raw stream
    Route::post('/delstream', [StreamController::class, 'delStream'])->name('delstream');//done
    
    //Endpoint untuk ngatur configurasi subscriber mqqt 
    Route::get('/mqqtconfig', [MqqtController::class, 'index'])->name('mqqtconf');//done



    //Endpoint untuk store data subscriber mqqt 
    Route::post('/mqqtconfigStore', [MqqtController::class, 'store'])->name('storeMqqconf');//done

});

Route::group(['middleware' => 'superadmin'], function () {
    Route::get('/authorize', [AdminController::class, 'list'])->name('authorize');//done
    Route::post('/promote', [AdminController::class, 'promote'])->name('promote');//done
});


Auth::routes();


<?php

namespace App\Http\Controllers;

use App\Models\cdStatistic;
use App\Models\Rtsp;
use Illuminate\Http\Request;
use Carbon\Carbon;


class CdStatisticsController extends Controller {

    public function rtlc($deviceId) {
        return view('rtlc', ['deviceid' => $deviceId]);
    }

    public function rtsr($deviceId) {
        return view('rtsr', ['deviceid' => $deviceId]);
    }

    public function realtime($deviceid) {
        $data = cdStatistic::where('deviceid', $deviceid)
            ->latest()
            ->take(10)
            ->get();

        return response()->json(['data' => $data]);
    }



    public function showrt($deviceid) {
        return view('statistic.cdstatisticrt', ['deviceid' => $deviceid]);
    }

    public function delrecord(Request $request) {
        $id = $request->input('id');
        $date = $request->input('date');
        $data = cdStatistic::where('deviceid', $id)
            ->where('date', $date)
            ->delete();
        if($data) {
            return back();
        } else {
            return back();
        }
    }

    public function singledeldatarecord(Request $request) {
        $id = $request->input('id');

        $data = cdStatistic::find($id);

        if($data) {
            $data->delete();
            return redirect()->back();
        } else {
            return back()->with('error', 'Record not found');
        }
    }

    public function showlist($id) {
        $data = cdStatistic::where('deviceid', $id)->groupBy('date')->get();

        return view('statistic.statisticlist', ['data' => $data, 'id' => $id]);
    }

    public function showlistdetail($id, $date) {
        $data = cdStatistic::where('deviceid', $id)
            ->where('date', $date)
            ->get();

        return view('statistic.showlistdetail', ['data' => $data, 'recorddate' => $date]);

    }

    public function showplainfilt($id) {
        $listdata = Rtsp::all();

        $data = CdStatistic::where('deviceid', $id)
            ->latest()
            ->take(10)
            ->orderBy('time', 'asc')
            ->get();

        
        if ($data->count() === 0) {
            $first = $data->first();
            $date = $first->date;
            $time = $first->time;
            $last = $data->last();
            $enddate = $last->date;
            $endtime = $last->time;
    
            return view('statistic.cdstatistic', [
                'nodata' => true, 
                'finenddate' => $enddate,
                'date' => $date,
                'from' => $time,
                'to' => $endtime,
                'listdata' => $listdata,
                'data' => $data,
                'device' => $id,
     
            ]);
        } else {
            $first = $data->first();
            $date = $first->date;
            $time = $first->time;
            $last = $data->last();
            $enddate = $last->date;
            $endtime = $last->time;
    
            $greatestPeopleCount = $data->max('peoplecount');
            $lowestPeopleCount = $data->min('peoplecount');
    
            $timeOfGreatestPeopleCount = $data->where('peoplecount', $greatestPeopleCount)->pluck('time')->first();
            $timeOfLowestPeopleCount = $data->where('peoplecount', $lowestPeopleCount)->pluck('time')->first();
    
            $averagePeopleCount = $data->avg('peoplecount');
            $totalDataRecord = $data->count();
    
    
            return view('statistic.cdstatistic', [
                'nodata' => false, 
                'finenddate' => $enddate,
                'date' => $date,
                'from' => $time,
                'to' => $endtime,
                'listdata' => $listdata,
                'data' => $data,
                'device' => $id,
                'lowestPeopleCount' => $lowestPeopleCount,
                'greatestPeopleCount' => $greatestPeopleCount,
                'timeOfGreatestPeopleCount' => $timeOfGreatestPeopleCount,
                'timeOfLowestPeopleCount' => $timeOfLowestPeopleCount,
                'averagePeopleCount' => $averagePeopleCount,
                'totalDataRecord' => $totalDataRecord
            ]);
        }
        

  


    }


    public function show($id, $date, $enddate, $ftime, $totime) {
        $listdata = Rtsp::all();

        if(!$date) {
            $currentDate = Carbon::now()->setTimezone('Asia/Jakarta')->format('D-m-y');
        } else {
            $currentDate = $date;
        }

        if(!$enddate) {

        } else {
            $finenddate = $enddate;
        }

        if(!$ftime) {
            $hoursBefore = 1;
            $beforeTime = Carbon::now()->subHours($hoursBefore)->setTimezone('Asia/Jakarta')->format('H:i:s');
        } else {
            $beforeTime = $ftime;
        }

        if(!$totime) {
            $currentTime = Carbon::now('Asia/Jakarta')->format('H:i:s');
        } else {
            $currentTime = $totime;
        }

        $data = cdStatistic::where('deviceid', $id)
            ->whereBetween('time', [$beforeTime, $currentTime])
            ->whereBetween('date', [$currentDate, $finenddate])
            ->get();

        $data2 = cdStatistic::where('deviceid', $id)
            ->whereBetween('time', [$beforeTime, $currentTime])
            ->whereBetween('date', [$currentDate, $finenddate])
            ->orderBy('peoplecount', 'desc')
            ->orderBy('time', 'asc')
            ->get();

        if($data2->count() > 0) {
            $greatestPeopleCountRecord = $data2->first();
            $lowestPeopleCountRecord = $data2->last();
            $greatestPeopleCount = $greatestPeopleCountRecord->peoplecount;
            $lowestPeopleCount = $lowestPeopleCountRecord->peoplecount;
            $timeOfGreatestPeopleCount = $greatestPeopleCountRecord->time;
            $timeOfLowestPeopleCount = $lowestPeopleCountRecord->time;
            $averagePeopleCount = $data2->avg('peoplecount');
            $totalDataRecord = $data->count();

            return view('statistic.cdstatistic', [
                'nodata' => false, 
                'data' => $data,
                'data2' => $data2,
                'device' => $id,
                'from' => $beforeTime,
                'date' => $currentDate,
                'finenddate' => $finenddate,
                'to' => $currentTime,
                'listdata' => $listdata,
                'lowestPeopleCount' => $lowestPeopleCount,
                'greatestPeopleCount' => $greatestPeopleCount,
                'timeOfGreatestPeopleCount' => $timeOfGreatestPeopleCount,
                'timeOfLowestPeopleCount' => $timeOfLowestPeopleCount,
                'averagePeopleCount' => $averagePeopleCount,
                'totalDataRecord' => $totalDataRecord
            ]);
        }else{
            return view('statistic.cdstatistic', [
                'listdata' => $listdata,
                'to' => $currentTime,
                'from' => $beforeTime,
                'finenddate' => $finenddate,
                'date' => $currentDate,
                'device' => $id,
                'data' => $data,
                'nodata' => true, 
            ]);
            
        }

    }



}


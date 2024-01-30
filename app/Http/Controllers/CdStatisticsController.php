<?php

namespace App\Http\Controllers;

use App\Models\cdrtconfig;
use App\Models\cdStatistic;
use App\Models\ovcrowdalerts;
use App\Models\Rtsp;
use Illuminate\Http\Request;
use Carbon\Carbon;


class CdStatisticsController extends Controller
{

    public function rtconfig($deviceid)
    {
        $mqtt = cdrtconfig::all();
        $count = $mqtt->count();
        
        if ($count > 0) {
            $mqtt = cdrtconfig::where('deviceid', $deviceid)->get();
            return view("mqqtcon.rt", [
                'data' => $mqtt
            ]);
        } else {
            return view("mqqtcon.rt", [
                'data' => null
            ]);
        }
    }

    public function alerts($deviceid) {
        $latestData = OvcrowdAlerts::where('seen', 'false')
            ->orderBy('created_at', 'desc') 
            ->first(); 

        return response()->json(['data' => $latestData]);
    }
    

    public function markAsSeen($id){
        $data = Ovcrowdalerts::find($id);
        if ($data) {
            $data->seen = "true";
            $data->save();
            echo $data;
        } else {
            echo "No data found for ID: $id";
        }
    }
    
    public function ocarchive(){
        $data = ovcrowdalerts::where('seen', "true")->get();
        $count = $data->count();
        
        return view("statistic.ocarchive", [
            'data' => ($count > 0) ? $data : null
        ]);

    }

    public function socarchivedel(Request $request){
        $alert = ovcrowdalerts::find($request->input('id'));
    
        if($alert){
            $alert->delete();
            // Optionally, you might want to redirect or return a success message here
            return redirect()->back()->with('success', 'Alert deleted successfully');
        } else {
            // Alert not found, handle this scenario as per your requirements
            return redirect()->back()->with('error', 'Alert not found');
        }
    }
    

    public function overcrowdhs()
    {
        $data = ovcrowdalerts::where('seen', "false")->get();
        $count = $data->count();
        
        return view("statistic.overcrowd", [
            'data' => ($count > 0) ? $data : null
        ]);
    }
    
    

    public function rtconfiglist()
    {
        $mqtt = cdrtconfig::all();
        return view("mqqtcon.rtlist", [
            'data' => $mqtt
        ]);

    }

    public function rtconfigstore(request $request)
    {
        $mqtt = cdrtconfig::all();
        $count = $mqtt->count();
        if ($count > 0) {
            $mqtt = cdrtconfig::where('deviceid', $request->input('deviceid'))->first();

            if ($mqtt) {
                $data = [
                    'latestRecordtoGet' => $request->input('latestRecordtoGet'),
                    'maxcrowd' => $request->input('maxcrowd'),
                ];

                $mqtt->update($data);

                return redirect()->route('rtconfig', ['deviceid' => $request->input('deviceid')]);
            } else {

            }


        } else {
            $data = [
                'latestRecordtoGet' => $request->input('latestRecordtoGet'),
                'maxcrowd' => $request->input('maxcrowd'),
            ];
            if ($data) {
                cdrtconfig::create($data);
                return redirect()->route('rtconfig');
            }

        }

    }
    public function rtlc($deviceId)
    {
        $cdrtConfig = Cdrtconfig::where('deviceid', $deviceId)->first();
    
        if ($cdrtConfig) {
            $maxcrowd = $cdrtConfig->maxcrowd;
            return view('rtlc', ['deviceid' => $deviceId, 'maxcrowd' => $maxcrowd]);
        } else {
        }
    }
    

    public function rtsr($deviceId)
    {
        return view('rtsr', ['deviceid' => $deviceId]);
    }
    
    public function realtime($deviceid)
    {
        $mqttConfig = cdrtconfig::where('deviceid', $deviceid)->first();
    
        $data = cdStatistic::where('deviceid', $deviceid)
            ->orderBy('created_at', 'asc')
            ->take($mqttConfig->latestRecordtoGet)  
            ->get();
    
        return response()->json(['data' => $data, 'mqttConfig' => $mqttConfig]);
    }
    
    
    
    
    
    
    



    public function showrt($deviceid)
    {

        return view('statistic.cdstatisticrt', ['deviceid' => $deviceid,]);
    }

    public function delrecord(Request $request)
    {
        $id = $request->input('id');
        $date = $request->input('date');
        $data = cdStatistic::where('deviceid', $id)
            ->where('date', $date)
            ->delete();
        if ($data) {
            return back();
        } else {
            return back();
        }
    }

    public function singledeldatarecord(Request $request)
    {
        $id = $request->input('id');

        $data = cdStatistic::find($id);

        if ($data) {
            $data->delete();
            return redirect()->back();
        } else {
            return back()->with('error', 'Record not found');
        }
    }

    public function showlist($id)
    {
        $data = cdStatistic::where('deviceid', $id)->groupBy('date')->get();

        return view('statistic.statisticlist', ['data' => $data, 'id' => $id]);
    }

    public function showlistdetail($id, $date)
    {
        $data = cdStatistic::where('deviceid', $id)
            ->where('date', $date)
            ->get();

        return view('statistic.showlistdetail', ['data' => $data, 'recorddate' => $date]);

    }

    public function showplainfilt($id)
    {
        $listdata = Rtsp::all();
        $mqtt = cdrtconfig::first();

        $cdrtConfig = Cdrtconfig::where('deviceid', $id)->first();
    
            $maxcrowd = $cdrtConfig->maxcrowd;
            $latestRecordtoGet = $cdrtConfig->latestRecordtoGet;

            $data = cdStatistic::where('deviceid', $id)
            ->orderBy('created_at', 'asc') 
            ->take($mqtt->latestRecordtoGet)  
            ->get();
        

        if ($data->count() === 0) {

            return view('statistic.cdstatistic', [
                'nodata' => true,
                'finenddate' => now()->setTimezone('Asia/Jakarta')->format('Y-m-d'),
                'date' => now()->setTimezone('Asia/Jakarta')->format('Y-m-d'),
                'from' => now()->setTimezone('Asia/Jakarta')->format('H:i:s'),
                'to' => now()->setTimezone('Asia/Jakarta')->format('H:i:s'),
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
                'maxcrowd' => $maxcrowd,
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


    public function show($id, $date, $enddate, $ftime, $totime)
    {
        $listdata = Rtsp::all();

        if (!$date) {
            $currentDate = Carbon::now()->setTimezone('Asia/Jakarta')->format('D-m-y');
        } else {
            $currentDate = $date;
        }

        if (!$enddate) {

        } else {
            $finenddate = $enddate;
        }

        if (!$ftime) {
            $hoursBefore = 1;
            $beforeTime = Carbon::now()->subHours($hoursBefore)->setTimezone('Asia/Jakarta')->format('H:i:s');
        } else {
            $beforeTime = $ftime;
        }

        if (!$totime) {
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
        $maxcrowd = cdrtconfig::first()->maxcrowd;

        if ($data2->count() > 0) {
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
                'maxcrowd' => $maxcrowd,
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
        } else {
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


<?php

namespace App\Http\Controllers;
use App\Models\Mqtt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class MqqtController extends Controller
{
    public function index(){
        $mqtt = Mqtt::all();
        $count = $mqtt->count();
        if ($count > 0) {
            $mqtt = Mqtt::first();

            return view("mqqtcon.mqqtconf" , [
                'data' => $mqtt
            ]);

        } else {
            return view("mqqtcon.mqqtconf" , [
                'data' => null
            ]);

        }

    }

    public function store(request $request){

        $mqtt = Mqtt::all();
        $count = $mqtt->count();
        if ($count > 0) {
            $mqtt = Mqtt::first();

            if ($mqtt) {
                $data = [
                    'host' => $request->input('host'),
                    'topic' => $request->input('topic'),
                    'port' => $request->input('port'),
                ];
            
                $mqtt->update($data); 
            
                return redirect()->route('mqqtconf');
            } else {

            }
            

        } else {
            
            $data = [
                'host' => $request->input('host'),
                'port' => $request->input('port'),
            ];
            if($data){
                Mqtt::create($data);
                return redirect()->route('mqqtconf');
            }

        }

     

    }

}

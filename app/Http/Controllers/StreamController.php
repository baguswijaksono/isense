<?php

namespace App\Http\Controllers;

use App\Models\Rtsp;
use App\Models\cdStatistic;
use App\Models\cdrtconfig;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StreamController extends Controller
{
    public function rawstream($id)
    {
        $listdata = Rtsp::all();
        $data = Rtsp::find($id);
        $specificDate = Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d');
        $cdStatistics = cdStatistic::where('date', $specificDate)->get();

        return view('rtspstream.rawstream', [
            'data' => $data,
            'streamtype' => "Raw",
            'listdata' => $listdata,
            'cdStatistic' => $cdStatistics
        ]);
    }


    public function addStream()
    {
        return view('rtspstream.addstream');
    }

    public function editStream($id)
    {
        $data = Rtsp::find($id);
        return view('rtspstream.editstream', ['data' => $data]);
    }

    public function delStream(Request $request)
    {
        $data = Rtsp::find($request->input('id'));

        if ($data) {
            if ($data->image) {
                Storage::disk('image')->delete($data->image);
            }

            $data->delete();
            return redirect()->route('streamlist');
        } else {
            return redirect()->back()->withErrors(['error' => 'Data tidak ditemukan.']);
        }
    }

    public function showStream()
    {
        $data = Rtsp::all();
        return view('rtspstream.streamlist', ['data' => $data]);
    }

    public function storeStream(Request $request)
    {
        $data = [
            'name' => $request->input('name'),
            'raw_url' => $request->input('raw_url'),
            'description' => $request->input('description'),
        ];

        $rtst = [
            'deviceid' => $request->input('name'),
            'latestRecordtoGet' => $request->input('latestRecordtoGet'),
            'maxcrowd' => $request->input('maxcrowd'),
        ];

        if ($request->hasFile('image')) {
            $imageName = time() . Auth::user()->id . "." . $request->file('image')->extension();
            Storage::disk('image')->put($imageName, file_get_contents($request->file('image')->getRealPath()));
            $data['image'] = $imageName;
        } else {
            return redirect()->back()->withErrors(['error' => 'Anda belum mengupload gambar.']);
        }

        cdrtconfig::create($rtst);
        Rtsp::create($data);

        return redirect()->route('streamlist');
    }

    public function updateStream(Request $request)
    {
        $data = [
            'name' => $request->input('name'),
            'raw_url' => $request->input('raw_url'),
            'description' => $request->input('description'),
        ];

        $old = Rtsp::find($request->input('id'));

        if ($request->hasFile('image')) {
            Storage::disk('image')->delete($old->image);

            $imageName = time() . Auth::user()->id . "." . $request->file('image')->extension();
            Storage::disk('image')->put($imageName, file_get_contents($request->file('image')->getRealPath()));

            $data['image'] = $imageName;
        }

        $stream = Rtsp::find($request->input('id'));

        if (!$stream) {
            return redirect()->back()->with('error', 'not found!');
        } else {
            $stream->update($data);
            return redirect()->route('streamlist');
        }
    }
}
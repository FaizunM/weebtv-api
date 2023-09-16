<?php

namespace App\Http\Controllers;

use App\Models\Stream;
use App\Http\Requests\StoreStreamRequest;
use App\Http\Requests\UpdateStreamRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StreamController extends Controller
{
    public function index(Request $req)
    {
        $data = null;
        if ($req->id) {
            $data = Stream::findOrFail($req->id);
        } else {
            $data = Stream::paginate($req->per_page)->items();
        }

        return response()->json(['status' => 1, 'data' => $data], 200);
    }

    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'anime' => "required|integer",
            'resolutions' => "required|json",
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()], 200);
        }

        $data = new Stream;
        $data->anime = $req->anime;
        $data->resolutions = $req->resolutions;
        $data->save();

        return response()->json(['status' => 1, 'data' => $data, 'message' => 'Successfully'], 200);
    }

    public function edit(Request $req)
    {
        $data = Stream::findOrFail($req->id);
        $data->update($req->all());
        $data->save();

        return response()->json(['status' => 1, 'data' => $data, 'message' => 'Successfully'], 200);
    }

    public function destory(Request $req)
    {
        $data = Stream::findOrFail($req->id);
        $data->delete();

        return response()->json(['status' => 1, 'message' => 'Successfully'], 200);
    }
}

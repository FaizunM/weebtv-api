<?php

namespace App\Http\Controllers;

use App\Models\Studio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudioController extends Controller
{
    public function index(Request $req)
    {
        $data = null;
        if ($req->id) {
            $data = Studio::findOrFail($req->id);
        } else {
            $data = Studio::all();
        }

        return response()->json(['status' => 1, 'data' => $data], 200);
    }

    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => "required|string",
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()], 200);
        }

        $data = new Studio;
        $data->name = $req->name;
        $data->save();

        return response()->json(['status' => 1, 'data' => $data, 'message' => 'Successfully'], 200);
    }

    public function edit(Request $req)
    {
        $data = Studio::findOrFail($req->id);
        $data->update($req->all());
        $data->save();

        return response()->json(['status' => 1, 'data' => $data, 'message' => 'Successfully'], 200);
    }

    public function destory(Request $req)
    {
        $data = Studio::findOrFail($req->id);
        $data->delete();

        return response()->json(['status' => 1, 'message' => 'Successfully'], 200);
    }
}

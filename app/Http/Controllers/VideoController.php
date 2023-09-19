<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller
{
    public function index(Request $req)
    {
        $data = null;
        if ($req->id) {
            $data = Video::with('anime')->findOrFail($req->id);
        } else {
            $data = Video::with('anime')->paginate($req->per_page ? $req->per_page : 10);
        }

        return response()->json(['status' => 1, 'data' => $data], 200);
    }

    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'title' => "required|string",
            'slug' => "required|string",
            'anime' => "required|integer",
            'images' => "required|string",
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()], 200);
        }

        $data = new Video;
        $data->title = $req->title;
        $data->slug = $req->slug;
        $data->anime = $req->anime;
        $data->images = $req->images;
        $data->save();

        return response()->json(['status' => 1, 'data' => $data, 'message' => 'Successfully'], 200);
    }

    public function edit(Request $req)
    {
        $data = Video::findOrFail($req->id);
        $data->update($req->all());
        $data->save();

        return response()->json(['status' => 1, 'data' => $data, 'message' => 'Successfully'], 200);
    }

    public function destory(Request $req)
    {
        $data = Video::findOrFail($req->id);
        $data->delete();

        return response()->json(['status' => 1, 'message' => 'Successfully'], 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnimeController extends Controller
{
    public function index(Request $req)
    {
        $data = null;
        if ($req->id) {
            $data = Anime::with('studio')->findOrFail($req->id);
        } else {
            $data = Anime::with('studio')->paginate($req->per_page? $req->per_page : 10);
        }

        return response()->json(['status' => 1, 'data' => $data], 200);
    }

    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'title' => 'required|string',
            'slug' => 'required|string',
            'description' => 'required|string',
            'studio' => "required|integer",
            'genres' => 'required|json',
            'duration' => "required|integer",
            'images' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()], 200);
        }

        $data = new Anime;
        $data->title = $req->title;
        $data->slug = $req->slug;
        $data->description = $req->description;
        $data->studio = $req->studio;
        $data->genres = $req->genres;
        $data->duration = $req->duration;
        $data->images = $req->images;
        $data->save();

        return response()->json(['status' => 1, 'data' => $data, 'message' => 'Successfully'], 200);
    }

    public function edit(Request $req)
    {
        $data = Anime::findOrFail($req->id);
        $data->update($req->all());
        $data->save();

        return response()->json(['status' => 1, 'data' => $data, 'message' => 'Successfully'], 200);
    }

    public function destory(Request $req)
    {
        $data = Anime::findOrFail($req->id);
        $data->delete();

        return response()->json(['status' => 1, 'message' => 'Successfully'], 200);
    }
}

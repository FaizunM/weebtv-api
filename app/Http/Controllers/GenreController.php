<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GenreController extends Controller
{
    public function index(Request $req)
    {
        $data = null;
        if ($req->id) {
            $data = Genre::findOrFail($req->id);
        } else {
            $data = Genre::paginate($req->per_page)->items();
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

        $data = new Genre;
        $data->name = $req->name;
        $data->save();

        return response()->json(['status' => 1, 'data' => $data, 'message' => 'Successfully'], 200);
    }

    public function edit(Request $req)
    {
        $data = Genre::findOrFail($req->id);
        $data->update($req->all());
        $data->save();

        return response()->json(['status' => 1, 'data' => $data, 'message' => 'Successfully'], 200);
    }

    public function destory(Request $req)
    {
        $data = Genre::findOrFail($req->id);
        $data->delete();

        return response()->json(['status' => 1, 'message' => 'Successfully'], 200);
    }
}

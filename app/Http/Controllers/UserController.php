<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $req)
    {
        $data = null;
        if ($req->id) {
            $data = User::findOrFail($req->id);
        } else {
            $data = User::paginate($req->per_page)->items();
        }

        return response()->json(['status' => 1, 'data' => $data], 200);
    }

    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => "required|string",
            'username' => "required|string",
            'email' => "required|email",
            'password' => "required|string",
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()], 200);
        }

        $data = new User;
        $data->name = $req->name;
        $data->username = $req->username;
        $data->email = $req->email;
        $data->password = $req->password;
        $data->save();

        return response()->json(['status' => 1, 'data' => $data, 'message' => 'Successfully'], 200);
    }

    public function login(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'username' => "required|string",
            'password' => "required|string",
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()], 200);
        }

        $field = null;

        if (filter_var($req->username, FILTER_VALIDATE_EMAIL)) {
            $field = 'email';
        } else {
            $field = 'username';
        }

        $credentials = [$field => $req->username, 'password' => $req->password];

        if (Auth::attempt($credentials)) {
            $data = Auth::user();
            $token = $data->createToken('Bearer')->plainTextToken;

            return response()->json(['status' => 1, 'data' => ['token' => $token, 'token_type' => 'Bearer',], 'message' => 'Successfully'], 200);
        }

        return response()->json(['status' => 0, 'message' => 'Login failed'], 200);
    }

    public function logout(Request $req)
    {
        $user = $req->user()->tokens()->delete();

        return response()->json(['status' => 1, 'message' => 'Successfully', 'data' => $user], 200);
    }

    public function show(Request $req)
    {
        return response()->json(['status' => 1, 'message' => 'Successfully', 'data' => $req->user()], 200);
    }

    public function edit(Request $req)
    {
        $data = User::findOrFail($req->id);
        $data->update($req->all());
        $data->save();

        return response()->json(['status' => 1, 'data' => $data, 'message' => 'Successfully'], 200);
    }

    public function destory(Request $req)
    {
        $data = User::findOrFail($req->id);
        $data->delete();

        return response()->json(['status' => 1, 'message' => 'Successfully'], 200);
    }
}

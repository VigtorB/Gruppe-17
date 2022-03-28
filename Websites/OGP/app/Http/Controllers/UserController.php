<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user= User::where('email', $request->email)->first();
        // print_r($data);
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response([
                    'message' => ['These credentials do not match our records.']
                ], 404);
            }

             $token = $user->createToken('my-app-token')->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $token
            ];

             return response($response, 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //register
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //find user
        try {
            $user = User::findOrFail($id);
            return response($user, 200);
        } catch (\Exception $e) {
            return response([
                'message' => ['User not found']
            ], 404);
        }
    }

    public function showAll()
    {
        try {
            $users = User::all();
            return response($users, 200);
        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage()
            ], 500);
        }
        //find all users
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //update description on description
        try {
            $user = User::findOrFail($id);
            $user->description=$request->get('description');
            return response($user, 200);
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()
        ], 500)->json;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //delete user
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response(['message' => 'user ' +$id+ ' deleted'], 200)->json;
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()
        ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Coin;

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
        try {
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            //add user id to current coin database
            $user_id = $user->id;
            $coin = new Coin;
            $coin->user_id = $user_id;
            $coin->save();

            $token = $user->createToken('my-app-token')->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token
            ];
            return response($response, 201);
        } catch (\Throwable $th) {
            return response([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getUser($info)
    {
        //find user
        try {
            if(is_numeric($info)){
                $user = User::findOrFail($info);
                return response($user, 200);
            }
            else
            {
                $user = User::where('username', $info)->first();
                return response($user, 200);
            }
        } catch (\Exception $e) {
            return response([
                'message' => ['User not found']
            ], 500);
        }
    }
    public function getUsername($info)
    {
        //find user
            if(is_numeric($info)){
                $user = User::findOrFail($info);
                return $user->username;
            }

    }
    /*
    public function getUserByUsername($username)
    {
        //find user
        try {
            $user = User::where('username', $username)->first();
            return response($user, 200);
        } catch (\Exception $e) {
            return response([
                'message' => ['User not found']
            ], 404);
        }
    }
    */

    //find all users
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

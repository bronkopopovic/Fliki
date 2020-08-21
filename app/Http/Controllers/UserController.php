<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Get a user by ID.
     *
     * @param string $id
     *
     * @return string
     */
    public function getById($id)
    {
        $user = User::where('id', $id)->first()->toArray();
        return response()->json($user);
    }

    /**
     * Get all users.
     *
     * @return string
     */
    public function getAll()
    {
        $users = User::all()->toArray();
        return response()->json($users);
    }

    /**
     * Create a new user.
     *
     * @return string
     */
    public function save()
    {
        $data = request(['id', 'email', 'name', 'password']);
        if(array_key_exists('id', $data)){
            $user = User::where('id', $data['id'])->first();
        }
        else {
            $user = new User();
        }
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();
        $response = [
            'message' => 'User saved',
            'id' => $user->id
        ];
        return response()->json($response);
    }

    /**
     * Delete a new user.
     *
     * @return string
     */
    public function delete()
    {
        $data = request(['id']);
        $user = User::where('id', $data['id'])->first();
        $user->delete();
        $response = [
            'message' => 'User deleted'
        ];
        return response()->json($response);
    }
}

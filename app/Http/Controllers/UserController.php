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
        $this->middleware('admin', ['except' => [
            'getById',
            'getAll',
            'updatePassword'
        ]]);
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
     * Update password.
     *
     * @return string
     */
    public function updatePassword()
    {
        $data = request(['id', 'old', 'new']);
        $user = User::where('id', $data['id'])->first();
        if(Hash::check($data['old'], $user->password)){
            $user->password = Hash::make($data['new']);
            $user->save();
            return response()->json(['message' => 'Password updated']);
        }
        else {
            return response()->json(['error' => 'Old password does not match'], 401);
        }
    }

    /**
     * Create a new user.
     *
     * @return string
     */
    public function save()
    {
        $data = request(['id', 'email', 'name', 'password', 'is_admin']);
        if(array_key_exists('id', $data)){
            $user = User::where('id', $data['id'])->first();
        }
        else {
            $user = new User();
        }
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->is_admin = $data['is_admin'];
        $user->save();
        return response()->json([
            'message' => 'User saved',
            'id' => $user->id
        ]);
    }

    /**
     * Delete a user.
     *
     * @return string
     */
    public function delete()
    {
        $data = request(['id']);
        $user = User::where('id', $data['id'])->first();
        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }
}

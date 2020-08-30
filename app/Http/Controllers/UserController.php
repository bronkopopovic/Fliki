<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
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
        $user = User::where('id', $id)->first();
        if($user === null){
            return response()->json(['error' => 'User not found'], 404);
        }
        return response()->json($user->toArray());
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
    public function updatePassword(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        if($user === null){
            return response()->json(['error' => 'User not found'], 404);
        }
        if(Hash::check($request->input('old'), $user->password)){
            $user->password = Hash::make($request->input('new'));
            $user->save();
            return response()->json(['message' => 'Password updated']);
        }
        else {
            return response()->json(['error' => 'Old password does not match'], 401);
        }
    }

    /**
     * CReate a user.
     *
     * @return string
     */
    public function create(Request $request)
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->is_admin = $request->input('is_admin');
        $user->save();
        return response()->json([
            'message' => 'User saved',
            'id' => $user->id
        ]);
    }

    /**
     * Update a user.
     *
     * @return string
     */
    public function save(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        if($user === null){
            return response()->json(['error' => 'User not found'], 404);
        }
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->is_admin = $request->input('is_admin');
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
    public function delete($id)
    {
        $user = User::where('id', $id)->first();
        if($user === null){
            return response()->json(['error' => 'User not found'], 404);
        }
        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }
}

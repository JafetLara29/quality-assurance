<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStorageRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        return view('users.index')->with([
            'users'=>$users,
        ]);
    }
    public function update(UserStorageRequest $request, User $user){
        $user->update($request->validated());
        
        return $this->index();
    }
    public function destroy(User $user){
        $user->delete();

        return $this->index();
    }
}

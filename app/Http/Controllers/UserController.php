<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateTypeUserRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        return view('users.index')->with([
            'users'=>$users,
        ]);
    }
    
    public function store(UserRequest $request){
        if(strcmp($request->password_confirmation, $request->password) == 0){
            $requestData = $request->validated();
            $requestData['password'] = Hash::make($request->password);
            User::create($requestData);
            return $this->index();
        }else{
            return redirect()->back()->withInput($request->validated())->withErrors('Las contraseñas no coinciden');
        }
    }

    public function edit(User $user){
        return view('users.edit')->with([
            'user'=> $user,
        ]);
    }

    public function update(UpdateTypeUserRequest $request, User $user){
        if(strcmp($request->password_confirmation, $request->password) == 0){
            if($request->password != ''){
                $requestData = $request->validated();
                $requestData['password'] = Hash::make($request->password);
                $user->update($requestData);
                return $this->index();
            }else{
                $requestData = $request->validated();
                $requestData['password'] = $user->password;
                $user->update($requestData);
                return $this->index();
            }
        }else{
            return redirect()->back()->withInput($request->validated())->withErrors('Las contraseñas no coinciden');
        }
    }

    public function destroy(User $user){
        $user->delete();

        return $this->index();
    }
}

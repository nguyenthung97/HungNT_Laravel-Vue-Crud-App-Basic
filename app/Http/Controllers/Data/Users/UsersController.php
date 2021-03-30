<?php

namespace App\Http\Controllers\Data\Users;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UsersController extends Controller
{
    public function _construct(){
        $this->middleware(function($request,$next){
            if(!Auth::user->isAdmin()){
                return response('Unauthorized',403);
            }
            return $next($request);
        })->only('delete','update');
    }
    public function index(){
        return response()->json(['results' => User::latest()->paginate(15)]);
    }

    public function store(StoreUserRequest $request){
        $user = User::create($request->only('name','role','email') + ['password' => Hash::make($request->password)]);

        return $request->json(['user' => $user]);
    }

    public function delete(User $user){
        $user->delete();

        return response()->json(['message'=> "Successfully deleted user"]);
    }

    public function update(UpdateUserRequest $request, User $user){
        $user->update($request->validated());
        
        return response()->json(['user' => $user->only('id','name','email','role')]);
    }
}

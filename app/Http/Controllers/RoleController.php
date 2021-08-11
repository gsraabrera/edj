<?php

namespace App\Http\Controllers;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
class RoleController extends Controller
{
        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function assign(Request $request)
    {


        if(Auth::user()->hasRole('Admin')){
            $roles = \Spatie\Permission\Models\Role::get(['name']);
            $user = User::find($request->input('id'));
            $user->syncRoles($request->input('name'));

            return redirect()->route('admin.users')
            ->with('success','User updated successfully.');
        }else{
            return  redirect('/home');
        }
    }
}

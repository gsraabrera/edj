<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Mail;
use Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->hasRole('Admin')){
            $data = User::with('roles')->paginate(5);
            $roles = \Spatie\Permission\Models\Role::get(['name']);
            // return $roles;
            return view('admin.users',compact('data','roles'));
        }else{
            return  redirect('/home');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        if(Auth::user()->hasRole('Admin')){
            $request->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'title' => ['required', 'max:255'],
                'current_job_title' => ['required',  'max:255'],
                'department_research_unit' => ['required', 'max:255'],
                'institution' => ['required',  'max:255'],
                'street' => ['required', 'max:255'],
                'town' => ['required',  'max:255'],
                'zip' => ['required', 'max:255'],
                'country' => ['required', 'max:255'],
                'contact_no' => ['required', 'max:255'],
                'mobile_no' => ['required',  'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ]);
            $user = New User;
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->middle_name = $request->input('middle_name');
            $user->title = $request->input('title');
            $user->current_job_title = $request->input('current_job_title');
            $user->department_research_unit = $request->input('department_research_unit');
            $user->institution = $request->input('institution');
            $user->street = $request->input('street');
            $user->town = $request->input('town');
            $user->zip = $request->input('zip');
            $user->country = $request->input('country');
            $user->contact_no = $request->input('contact_no');
            $user->mobile_no = $request->input('mobile_no');
            $user->email = $request->input('email');
            $user->password = Str::random(40);
            $user->save();

            return redirect()->route('admin.users')
            ->with('success','User added successfully.');
        }else{
            return  redirect('/home');
        }
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // return $request;
        if(Auth::user()->hasRole('Admin')){
            $request->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'title' => ['required', 'max:255'],
                'current_job_title' => ['required',  'max:255'],
                'department_research_unit' => ['required', 'max:255'],
                'institution' => ['required',  'max:255'],
                'street' => ['required', 'max:255'],
                'town' => ['required',  'max:255'],
                'zip' => ['required', 'max:255'],
                'country' => ['required', 'max:255'],
                'contact_no' => ['required', 'max:255'],
                'mobile_no' => ['required',  'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,id,'.$request->input('id')],
            ]);
            $user = User::find($request->input('id'));
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->middle_name = $request->input('middle_name');
            $user->title = $request->input('title');
            $user->current_job_title = $request->input('current_job_title');
            $user->department_research_unit = $request->input('department_research_unit');
            $user->institution = $request->input('institution');
            $user->street = $request->input('street');
            $user->town = $request->input('town');
            $user->zip = $request->input('zip');
            $user->country = $request->input('country');
            $user->contact_no = $request->input('contact_no');
            $user->mobile_no = $request->input('mobile_no');
            $user->email = $request->input('email');
            $user->save();

            return redirect()->route('admin.users')
            ->with('success','User updated successfully.');
        }else{
            return  redirect('/home');
        }
    }

}

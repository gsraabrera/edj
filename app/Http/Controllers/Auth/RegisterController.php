<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
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
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'],
            'last_name' =>  $data['last_name'],
            'title' => $data['title'],
            'current_job_title' => $data['current_job_title'],
            'department_research_unit' => $data['department_research_unit'],
            'institution' => $data['institution'],
            'street' => $data['street'],
            'town' => $data['town'],
            'zip' => $data['zip'],
            'country' => $data['country'],
            'contact_no' => $data['contact_no'],
            'mobile_no' => $data['mobile_no'],
            
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $user->assignRole('Author');
        return $user;
    }
}

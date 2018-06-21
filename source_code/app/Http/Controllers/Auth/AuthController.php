<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Hash;


class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
	public function getLogin(){
		return view('Backend.login');
		
	}
	public function postLogin(LoginRequest $request){
        


		$login= array(
		'email' => $request->email,
		'password'=> $request->password,
      
		);

		if(Auth::attempt($login)){

         
			  return redirect('quan-tri/');
		}else{
			return redirect()->back();
		}
		
	}
    public function getRegister(){
        return view('Backend.register');
    }
    public function postRegister(){
        $data = \Request::input();
        $user = new User();
        $user->username = $data['Username'];
         $user->email =$data['Email'];
          $user->password = bcrypt($data['Password']);
          $user->remember_token = $data['_token'];
          $user->save();
          return redirect('login/');
      }
      public function postCheckExistEmail() {
            extract($_POST);

            $emailExist = User::where('email', $email)->get()->toArray();

            if (count($emailExist) > 0) {
                return 1;
            } else {
                return 0;
            }
        }
}
;

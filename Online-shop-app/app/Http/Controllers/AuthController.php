<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        return view('Front.Account.login');
    }

    public function loginProcess(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if ($validator->passes())
        {
            if(Auth::attempt([ 'email'=> $request->email, 'password'=>$request->password],$request->get('remember')))
            {
                if(session()->has('url.intended')){
                    return redirect(session()->get('url.intended'));
                }
                return redirect()->route('account.profile');
            }
            else{
                return redirect()->route('account.login')
                    ->withErrors($validator)
                    ->withInput($request->only('email'))
                    ->with('error','Enter Valid Input');
            }
        }
        else{
            return redirect()->route('account.login')
                ->withErrors($validator)
                ->withInput($request->email)
                ->with('error','Enter Valid Input');
        }
    }

    public function profile()
    {
        return view('Front.Account.profile');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('account.login')
            ->with('success','Successfully LogOut');
    }

    public function register(Request $request)
    {
        return view('Front.Account.register');
    }

    public function registerUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'phone' => 'required|numeric|digits:11',
            'password' => 'required|min:5|confirmed',
        ]);

        if ($validator->passes()) {

            // Create the user
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->save();

            // Redirect to a success page
            return redirect()->route('account.login')->with('success', 'Registration successful. Please Login With your Credential');
        } else {
            return redirect()->route('account.register')
                ->withErrors($validator)
                ->withInput($request->all())
                ->with('error', 'Register Request Failed. Please try again.');
        }
    }


    public function checkEmail(Request $request)
    {
        $emailExists = User::where('email', $request->email)->exists();

        return response()->json(['exists' => $emailExists]);
    }


    public function forgetPassword()
    {
        return view('Front.Account.forgetPassword');
    }
}

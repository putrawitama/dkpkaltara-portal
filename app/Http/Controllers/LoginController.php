<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Security\EncryptController;
use App\Http\Controllers\Security\ValidatorController;
use App\User;

use Request;
use Hash;
use Session;

class LoginController extends Controller
{
    public function viewLogin() {
    	if (Session()->get('session_id') != null) {
            return redirect()->back();
        } else {
            return view('login');
        }
    }

    public function postLogin() {
        $encrypt = new EncryptController;
        $data = $encrypt->fnDecrypt(Request::input('data'),true);
        // dd($data);
        $user = User::where('email', $data['email'])->first();
        if ($user) {
            if (Hash::check($data['password'].env('SALT_PASS'), $user->password)) {
                $session = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'user_type' => $user->user_type,
                ];
                Session::put('session_id', $session);

                return [
                    'status'   => 'success',
                    'url'      => '/dashboard',
                    'callback' => 'login'
                ];
            } else {
                return [
                    'status'  => 'error',
                    'message' => 'Maaf password anda salah'
                ];
            }
        } else {
            return [
                'status'  => 'error',
                'message' => 'Maaf user tidak terdaftar'
            ];
        }
    }

    public function logout(){
		session()->forget('session_id');

    	return redirect('login');
    }
}

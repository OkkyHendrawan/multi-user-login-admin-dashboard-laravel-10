<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ForgotPasswordMail;
use App\Models\DosenModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{
    public function login()
        {
            if(!empty(Auth::check()))
            {
                if(Auth::user()->user_type ==1)
                {
                    return redirect('admin/dashboard');
                }
                else if(Auth::user()->user_type ==2)
                {
                    return redirect('dosen/dashboard');
                }
                else if(Auth::user()->user_type ==3)
                {
                    return redirect('mahasiswa/dashboard');
                }
            }
            return view('auth.login');
        }

    public function AuthLogin(Request $request)
        {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if(Auth::guard('dosen')->attempt($credentials)){
                $request->session()->regenerate();
                return redirect('dosen/dashboard');
            }
            if(Auth::guard('web')->attempt($credentials)){
                $request->session()->regenerate();
                return redirect('admin/dashboard');
            }
            if(Auth::guard('mahasiswa')->attempt($credentials)){
                $request->session()->regenerate();
                return redirect('mahasiswa/dashboard');
            }
            return back()->withErrors([
                'email' => 'email untuk Kredensial yang diberikan tidak cocok dengan catatan kami',
            ])->onlyInput('email');

        }

    public function forgotpassword()
        {
            return view('auth.forgot');
        }

    public function PostForgotPassword(Request $request)
        {
              $email = $request->validate(['email' => 'required|email']);

              $user = User::where('email', $email)->first();
              $dosen = DosenModel::where('email', $request->email)->first();

              if (!$user && !$dosen) {
                  return redirect()->back()->with('error', 'Email tidak ditemukan.');
              }

              $recipient = $user ?: $dosen;

              $recipient->remember_token = Str::random(60);
              $recipient->save();

              try {
                Mail::to($recipient->email)->send(new ForgotPasswordMail($recipient));
                return redirect()->back()->with('success', "Please check your email and reset your password");
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'There was an error sending the password reset email.');
            }
        }

    public function reset($remember_token)
        {
            $user = User::getTokenSingle($remember_token);
            $dosen = DosenModel::getTokenSingle($remember_token);

            if (!empty($user)) {
                $data['user'] = $user;
                return view('auth.reset', $data);
            } elseif (!empty($dosen)) {
                $data['dosen'] = $dosen;
                return view('auth.reset', $data);
            } else {
                abort(404);
            }
        }

    public function PostReset($token, Request $request)
        {
            $user = User::getTokenSingle($token);
            $dosen = DosenModel::getTokenSingle($token);

            if (!empty($user)) {
                $model = $user;
            } elseif (!empty($dosen)) {
                $model = $dosen;
            } else {
                abort(404);
            }

            if ($request->password == $request->cpassword) {
                $model->password = Hash::make($request->password);
                $model->remember_token = Str::random(60);
                $model->save();

                return redirect(url(''))->with('success', "Password successfully reset.");
            } else {
                return redirect()->back()->with('error', 'Password and confirm password do not match');
            }
        }

    public function logout()
        {
            Auth::logout();
            return redirect(url(''));
        }

}

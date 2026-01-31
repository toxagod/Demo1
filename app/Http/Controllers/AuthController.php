<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required|regex:/^[a-zA-Z0-9]+$/|min:6|unique:users',
            'password' => 'required|min:8',
            'full_name' => 'required|regex:/^[А-Яа-яёЁ\s]+$/u',
            'phone' => 'required|regex:/^8\(\d{3}\)\d{3}-\d{2}-\d{2}$/',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'login' => $request->login,
            'password' => Hash::make($request->password),
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'is_admin' => false
        ]);

        session([
            'user_id' => $user->id,
            'user_login' => $user->login,
            'user_name' => $user->full_name,
            'is_admin' => false
        ]);

        return redirect()->route('applications.index');
    }

    public function showLogin()
    {
        if (session('user_id')) {
            if (session('is_admin')) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('applications.index');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        if ($request->login === 'Admin' && $request->password === 'KorokNET') {
            session([
                'user_id' => 1,
                'user_login' => 'Admin',
                'user_name' => 'Администратор',
                'is_admin' => true
            ]);
            return redirect()->route('admin.dashboard');
        }

        $user = User::where('login', $request->login)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect()->back()
                ->withErrors(['login' => 'Неверный логин или пароль'])
                ->withInput();
        }

        session([
            'user_id' => $user->id,
            'user_login' => $user->login,
            'user_name' => $user->full_name,
            'is_admin' => $user->is_admin
        ]);

        return redirect()->route('applications.index');
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
}

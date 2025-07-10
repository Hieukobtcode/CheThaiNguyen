<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\NguoiDung;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{

    public function create()
    {
        return redirect()->route('home')->with('error','Hãy tiến hành đăng nhập');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'ten' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:nguoi_dungs,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = NguoiDung::create([
            'ten' => $request->ten,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'vai_tro_id' => 1,
            'tong_diem' => 0,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('admin.dashboard');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginPage()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($request->only('email', 'password'), $remember)) {
            $user = Auth::user();
            app()->setLocale($user->language); // Assuming 'language' field exists
            session()->put('locale', $user->language);

            return redirect()->route('admin.songs.index');

            // $user=Auth::user();
            // if($user->hasRole('admin')){
            // }
        }

        return back()->withErrors([
            'email' => 'The provide credencial not match with our records'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Optionally remove the locale from the session if you want to reset it
        // $request->session()->forget('locale');

        return redirect()->route('admin.login');
    }
}

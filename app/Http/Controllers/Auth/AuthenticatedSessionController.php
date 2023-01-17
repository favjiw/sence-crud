<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

use Kreait\Firebase\Contract\Database;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */

    protected $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function create(): View
    {
        return view('login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request) // : RedirectResponse
    {
        return redirect()->intended(RouteServiceProvider::HOME);
        // $request->authenticate();

        // $request->session()->regenerate();

        // $username = $request->username;
        // $password = $request->password;
        
        // echo $username.$password;
        // query firebase
        // $path = "/teacher";
        // $reference =  $this->database->getReference($path);
        // $snapshot = $reference->getSnapshot();
        // $value = $snapshot->getValue();

        // foreach($value as $val) {
        //     if($val["id"] == (int) $username && $val["password"] == "12345678") {
        //         return redirect()->intended(RouteServiceProvider::HOME);
        //     }
        // }

        // if($username == "2021118576" && $password = "12345678") {
        //     return redirect()->intended(RouteServiceProvider::HOME);
        // }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

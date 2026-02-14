<?php

namespace App\Http\Controllers\Auth;

use App\Events\VerifyReCaptchaToken;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Languages;
use App\Models\Utility;
use App\Models\User;
use App\Models\LoginDetails;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return $this->showLoginForm();
    }

    public function __construct()
    {
    }


    public function store(LoginRequest $request)
    {
        $settings = getCompanyAllSettings();
        $validation = [];
        if (isset($settings['RECAPTCHA_MODULE']) && $settings['RECAPTCHA_MODULE'] == 'yes') {
            if ($settings['google_recaptcha_version'] == 'v2-checkbox') {
                $validation['g-recaptcha-response'] = 'required';
            } elseif ($settings['google_recaptcha_version'] == 'v3') {


                $result = event(new VerifyReCaptchaToken($request));
                if (!isset($result[0]['status']) || $result[0]['status'] != true) {
                    $key = 'g-recaptcha-response';
                    $request->merge([$key => null]);

                    $validation['g-recaptcha-response'] = 'required';
                }
            } else {
                $validation = [];
            }
        } else {
            $validation = [];
        }

        $this->validate($request, $validation);
        $request->authenticate();

        $request->session()->regenerate();
        $user = Auth::user();
        if ($user->delete_status == 1) {
            Auth::guard('web')->logout();
        }

        if ($user->is_enable_login != 1 && $user->type != '0') {
            Auth::guard('web')->logout();
            return redirect()->route('login')->with('error', 'Your account is disabled from admin.');
        }

        if(!moduleIsActive('CustomerLogin'))
        {
            if(($request->email == $user->email) && ($user->type == 'customer')) {
                Auth::guard('web')->logout();
                return redirect()->route('login')->with('error', 'Customer Login Module is disabled from admin.');
                
            }
        }

        if($user->type != 'customer')
        {
            return redirect()->intended(RouteServiceProvider::HOME);
        }else {
                $customerHome = defined('\\Workdo\\CustomerLogin\\Providers\\RouteServiceProvider::HOME')
                    ? constant('\\Workdo\\CustomerLogin\\Providers\\RouteServiceProvider::HOME')
                    : RouteServiceProvider::HOME;
                return redirect()->intended($customerHome);
        }            
    }

    public function showLoginForm($lang = '')
    {
        if ($lang == '') {
            $lang = getActiveLanguage();
        } else {
            $lang = array_key_exists($lang, languages()) ? $lang : 'en';
        }
        $language = Languages::where('code',$lang)->first();
        if (!$language) {
            $language = (object) ['fullName' => strtoupper($lang)];
        }
        $settings = getCompanyAllSettings();
        App::setLocale($lang);

        return view('auth.login', compact('lang', 'settings','language'));
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // return redirect('/');
        return redirect()->route('login');
    }
}



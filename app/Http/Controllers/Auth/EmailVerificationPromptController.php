<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class EmailVerificationPromptController extends Controller
{
    public function __invoke(Request $request)
    {

        $settings = getCompanyAllSettings();
        $lang = '';

        if ($lang == '') {
            $lang =  isset($settings['default_language']) ? $settings['default_language'] : 'it';
        }

        App::setLocale($lang);
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(RouteServiceProvider::HOME)
                    : view('auth.verify-email',compact('lang'));
    }
}

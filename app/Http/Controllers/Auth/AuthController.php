<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\OTPSms;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Psy\Util\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Wavey\Sweetalert\Sweetalert;
use Anetwork\Validation\PersianValidationServiceProvider;
use Anetwork\Validation\ValidationMessages;

class AuthController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $social_user = Socialite::driver($provider)->user();
        } catch (Exception $exception) {
            return redirect()->route('login');
        }
        $user = User::where('email', $social_user->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name' => $social_user->getName(),
                'user_name' => $social_user->user['given_name'],
                'provider_name' => $provider,
                'avatar' => $social_user->getAvatar(),
                'email' => $social_user->getEmail(),
                'password' => Hash::make($social_user->getId()),
                'email_verified_at' => Carbon::now(),
            ]);
//            Sweetalert::success('به فروشگاه سپنتا خوش آمدید', 'ثبت نام شما با موفقیت انجام شد')->persistent(true);
            toastr()->success('به فروشگاه سپنتا خوش آمدید', 'ثبت نام شما با موفقیت انجام شد', ['timeOut' => 10000]);
        } else {
//            Sweetalert::success('  به فروشگاه سپنتا خوش برگشتی ' . $social_user->user['given_name'], 'از دیدن مجدد شما خوشحالیم')->persistent(true);;
            toastr()->success('  به فروشگاه سپنتا خوش برگشتی ', 'از دیدن مجدد شما خوشحالیم', ['timeOut' => 10000]);
        }

        auth()->login($user, $remember = true);

        return redirect()->route('home.index');
    }

    public function loginCellphone(Request $request)
    {
        if ($request->method() == 'GET') {
            return view('auth.loginCell');
        }

        $request->validate([
            'cellphone' => 'required|iran_mobile',
        ]);

        try {
            $user = User::where('cellphone', $request->cellphone)->first();
            $OTPCode = mt_rand(100000, 999999);
//            $loginToken = Hash::make('DCGHYTUpioamcFHBF@sdfdsf%!!sdASDFyiSF');
            $loginToken = bin2hex(random_bytes(32));

            if ($user) {

                $user->update([
                    'otp' => $OTPCode,
                    'login_token' => $loginToken,
                ]);
            } else {
                $user = User::create([
                    'cellphone' => $request->cellphone,
                    'otp' => $OTPCode,
                    'login_token' => $loginToken,
                ]);
            }
            $user->notify(new OTPSms($OTPCode));

            return response(['login_token' => $loginToken], 200);
        } catch (Exception $exception) {
            return response(['errors' => $exception->getMessage()], 422);

        }
    }

    public function checkOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
            'login_token' => 'required',
        ]);

        try {
            $user = User::where('login_token', $request->login_token)->firstOrFail();

            if ($user->otp == $request->otp) {
                auth()->login($user, $remember = true);
                return response(['ورود با موفقیت انجام شد'], 200);
            } else {
                return response(['errors' => ['otp' => ['کد وارد شده اشتباه است']]], 422);
            }
        } catch (Exception $exception) {
            return response(['errors' => $exception->getMessage()], 422);
        }

    }

    public function resendOtp(Request $request)
    {
        $request->validate([
            'login_token' => 'required',
        ]);

        try {
            $user = User::where('login_token', $request->login_token)->firstOrFail();
            $OTPCode = mt_rand(100000, 999999);
//            $loginToken = Hash::make('DCGHYTUpioamcFHBF@sdfdsf%!!sdASDFyiSF');
            $loginToken = bin2hex(random_bytes(32));

            $user->update([
                'otp' => $OTPCode,
                'login_token' => $loginToken,
            ]);
            $user->notify(new OTPSms($OTPCode));

            return response(['login_token' => $loginToken], 200);
        } catch (Exception $exception) {
            return response(['errors' => $exception->getMessage()], 422);

        }
    }
}

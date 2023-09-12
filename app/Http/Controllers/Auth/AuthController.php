<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;
use Wavey\Sweetalert\Sweetalert;

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
}

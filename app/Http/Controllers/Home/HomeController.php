<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\ContactUs;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Exception;
use Alert;
use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Banner::where('type', 'slider')->where('is_active', 1)->orderBy('priority')->get();
        $indexTopBanners = Banner::where('type', 'index-top')->where('is_active', 1)->orderBy('priority')->get();
        $indexBottomBanners = Banner::where('type', 'index-bottom')->where('is_active', 1)->orderBy('priority')->get();

        $products = Product::where('is_active', 1)->get()->take(15);


//        $productsd = Product::where('is_active', 1)->get()->take(6);
//        $jsonenc = json_encode($productsd);
//       $jsondc= json_decode($jsonenc)[2]->price_check->price;


        return view('home.index', compact('sliders', 'indexTopBanners', 'indexBottomBanners', 'products'));
    }


    public function aboutUs()
    {
        $bottomBanners = Banner::where('type', 'index-bottom')->where('is_active', 1)->orderBy('priority')->get();
        return view('home.about-us', compact('bottomBanners'));
    }

    public function contactUs()
    {
        $setting = Setting::findOrFail(1);
        return view('home.contact-us', compact('setting'));
    }

    public function contactUsForm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:250',
            'email' => 'required|email',
            'subject' => 'required|string|min:4|max:250',
            'text' => 'required|min:5|max:2000',
//            'g-recaptcha-response' => [new GoogleReCaptchaV3ValidationRule('contact_us')],
        ]);
        try {

            ContactUs::create([
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'text' => $request->text,

            ]);
            toastr()->success('پیام شما با موفقیت ثبت شد', 'کاربر گرامی', ['timeOut' => 5000, 'iconClass' => 'toast-success', 'positionClass' => 'toast-top-center',]);
            return redirect()->back();

        } catch (Exception $exception) {
            toastr()->error('متاسفانه ارسال پیام با خطا مواجه شد', 'کاربر گرامی', ['timeOut' => 5000, 'iconClass' => 'toast-error', 'positionClass' => 'toast-top-center',]);
            return redirect()->back();
        }

    }
}


//$message = new ContactUs();
//$message->name = $request->input('name');
//$message->email = $request->input('email');
//$message->subject = $request->input('subject');
//$message->text = $request->input('text');
//$message->save();

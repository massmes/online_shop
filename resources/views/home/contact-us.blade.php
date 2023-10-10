@extends('home.layouts.home')

@section('title')
    صفحه تماس با ما
@endsection

@section('style')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin=""/>
@endsection

@section('script')

    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin="">
    </script>

    <script>
        var mymap = L.map('map', {
            center: [{{$setting->latitude}}, {{$setting->longitude}}],
            zoom: 16,
            tapHold: true,
        });

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(mymap);


        var marker = L.marker([{{$setting->latitude}}, {{$setting->longitude}}]).addTo(mymap);

        marker.bindPopup("<b>سلام دوست من</b><br>من رو در اینجا میتونی پیدا کنی").openPopup();




        {{--var circle = L.circle([{{$setting->latitude}}, {{$setting->longitude}}], {--}}
        {{--    color: 'red',--}}
        {{--    fillColor: 'rgba(255, 53, 53,0.3)',--}}
        {{--    fillOpacity: 0.3,--}}
        {{--    radius: 200--}}
        {{--}).addTo(mymap);--}}
    </script>

@endsection

@section('content')

    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{ route('home.index') }}">صفحه ای اصلی</a>
                    </li>
                    <li class="active">فروشگاه</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="contact-area pt-100 pb-100">
        <div class="container">
            <div class="row text-right" style="direction: rtl;">
                <div class="col-lg-5 col-md-6">
                    <div class="contact-info-area">
                        <h2> لورم ایپسوم متن </h2>
                        <p>
                            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک
                            است.
                        </p>
                        <div class="contact-info-wrap">
                            <div class="single-contact-info">
                                <div class="contact-info-icon">
                                    <i class="sli sli-location-pin"></i>
                                </div>
                                <div class="contact-info-content">
                                    <p>{{ $setting->address }}</p>
                                </div>
                            </div>
                            <div class="single-contact-info">
                                <div class="contact-info-icon">
                                    <i class="sli sli-envelope"></i>
                                </div>
                                <div class="contact-info-content">
                                    <p><a href="mailto:{{$setting->email}}">{{ $setting->email }}</a></p>
                                </div>
                            </div>
                            <div class="single-contact-info">
                                <div class="contact-info-icon">
                                    <i class="sli sli-screen-smartphone"></i>
                                </div>
                                <div class="contact-info-content">
                                    <p style="direction: ltr;">
                                        <a href="tel:{{$setting->telephone}}">{{ $setting->telephone }}</a> /
                                        <a href="tel:{{$setting->telephone2}}">{{ $setting->telephone2 }}</a>
                                    </p>
                                </div>
                            </div>

                            @if(!empty($setting->instagram ))
                                <div class="single-contact-info">
                                    <div class="contact-info-icon">
                                        <i class="fab fa-instagram-square"></i>
                                    </div>
                                    <div class="contact-info-content">
                                        <p style="direction: ltr;">
                                            <a href="{{$setting->instagram}}"
                                               target="_blank">
                                                {{explode('/',parse_url($setting->instagram,PHP_URL_PATH))[1]}}
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-6">
                    <div class="contact-from contact-shadow">
                        <form id="contact-form" action="{{ route('home.contact-us.form') }}" method="post">
                            @csrf
                            <input name="name" type="text" placeholder="نام شما" value="{{old('name')}}">
                            @error('name')
                            <p class="input-error-validation">
                                <strong>{{$message}}</strong>
                            </p>
                            @enderror
                            <input name="email" type="email" placeholder="ایمیل شما" value="{{old('email')}}">
                            @error('email')
                            <p class="input-error-validation">
                                <strong>{{$message}}</strong>
                            </p>
                            @enderror
                            <input name="subject" type="text" placeholder="موضوع پیام" value="{{old('subject')}}">
                            @error('subject')
                            <p class="input-error-validation">
                                <strong>{{$message}}</strong>
                            </p>
                            @enderror
                            <textarea name="text" placeholder="متن پیام">{{old('text')}}</textarea>
                            @error('text')
                            <p class="input-error-validation">
                                <strong>{{$message}}</strong>
                            </p>
                            @enderror

                            <div id="contact_us_id" class="my-2"></div>
                            @error('g-recaptcha-response')
                            <p class="input-error-validation">
                                <strong>{{$message}}</strong>
                            </p>
                            @enderror

                            <button class="submit" type="submit"> ارسال پیام</button>
                        </form>
                        {!!  GoogleReCaptchaV3::render(['contact_us_id'=>'contact_us']) !!}
                    </div>
                </div>
            </div>
            <div class="contact-map pt-100">
                <div id="map"></div>
            </div>
        </div>
    </div>

@endsection

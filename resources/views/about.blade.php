<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>FaceChange</title>
        <!--JavaScript reference-->
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js""></script>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                /*color: #636b6f;*/
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100%;
                margin: 0;
            }

            .nav a:hover, a:active {
                color: rgb(240,233,129);
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
                bottom: 18px;
            }

            .top-left {
                position: absolute;
                left: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }
            .media {
                padding-left: 20px;
                padding-right: 20px;
            }
            .media-heading {
                color: rgb(7,91,162);
                font-size: 18px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
            #referenceAbout a {
                color: black;
                font-size: 15px;
                font-weight: 200;
            }
            p {
                color: rgb(7,91,162);
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
            }

            .title {
                font-size: 84px;
                margin: 0;
                position: absolute;
                top: 20%;
                left: 50%;
                margin-right: -50%;
                transform: translate(-50%, -50%);
            }

            .homeTitle {
                font-size: 84px;
                margin: 0;
                position: absolute;
                top: 50%;
                left: 50%;
                margin-right: -50%;
                transform: translate(-50%, -50%);
            }

            .links > a {
                color: rgb(7,91,162);
                padding: 0 15px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
                color: rgb(240,233,129);               
            }

            footer {
                display: block;
                bottom: 0;
                left: 0;
                overflow: hidden;
                width: 100%;
                position: fixed;
                text-align: right;
                padding-right: 10px;
                font-size: 48px;
            }

            .imgContainer {
                background-image: url("surgery.jpg");
                height: 100%;
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
            }

            #About {
                padding: 5px;
                margin-top: 170px;
                height: 450px;
                width: auto;
                display: block;
                margin-left: auto;
                margin-right: auto;
                background-color: rgba(153,184,191,.5);
            }

            /*--styles for contact form--*/
            input[type=text], select, textarea {
                width: 100%;
                padding: 12px;
                border: 1px solid #ccc;
                border-radius: 4px; /*--rounded borders--*/
                box-sizing: border-box;
                resize: vertical;
            }
            #contact {
                padding: 5px;
                margin-top: 170px;
                height: 450px;
                width: auto;
                display: block;
                margin-left: auto;
                margin-right: auto;
                padding-left: 20px;
                padding-right: 20px;
            }
            #fname, #email, #subject, #query {
                background-color: rgba(153,184,191,.5);
                border-color: rgb(7,91,162);
                font-weight: 600;

            }
            option {
                background-color: rgba(153,184,191);
                border-color: rgb(7,91,162);
                font-weight: 600;
            }
            input[type=submit] {
                width: 100%;
                background-color: rgb(7,91,162);
                color: rgb(240,233,129);
                border-radius: 4px;
                border:none;
                padding: 0 15px;
                font-size: 24px;
                font-weight: 150;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

        </style>
    </head>
    <body>

        <!--Photo by Bernard Osei on Unsplash-->
        <div class="imgContainer">
            <!-- <img class="image" src="surgery.jpg" alt="surgery"> -->
        


        <nav class="nav m-b-md">
            <div class="top-left links ">
                <a href="{{ url('/') }}" class="link">Home</a>
                <a href="{{ url('/about') }}"class="link">About</a>
                <a href="{{ route('testimonials.view') }}"class="link">Testimonials</a>
                <a href="{{ route('gallery.view') }}"class="link">Gallery</a>
                <a href="{{ url('/contact') }}"class="link">Contact</a>
            </div>
             @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endif
                </div>
            @endif
        </nav>

        <div class="tabcontent" id="About">
            <div class="title m-b-md">
                    About
            </div>

            <div class="media">
                <div class="media-left media-middle">
                    <img class="media-object" src="eye.png">
                </div>
                <div class="media-body">
                    <h4 class="media-heading">Our Mission</h4>
                    <p>Here at FaceChange, we aim to provide you a more realistic view of your life-changing cosmetic procedures will turn out.</p>
                    <p>We eliminate the unrealistic methods of photoshopping and free hand sketches, using our software to allow you to manipulate areas of your face in real-time and with a full 360 degree view.</p>
                </div>
            </div>

            <div class="media">
                <div class="media-body">
                    <h4 class="media-heading">Our Values</h4>
                    <p>Our core value is to ensure you get the best service and quality experience possible, to gain your trust and respect.</p>
                    <p>We give excellent customer service by ensuring your needs are met. We care about you and how your cosmetic surgery will boost your confidence. Everything we do is for you.</p>
                </div>
                <div class="media-right media-middle">
                    <img class="media-object" src="ear.png">
                </div>
            </div>

            <div class="media">
                <div class="media-left media-middle">
                    <img class="media-object" src="nose.png">
                </div>
                <div class="media-body">
                    <h4 class="media-heading">What You Can Expect</h4>
                    <p>Using our service, you can expect nothing but the highest professional standards of staff and software quality.</p>
                    <p>You will recieve your own dedicated account on our website, where you can use our specialist software to create your new looks.</p>
                    <p>You will be able to save your looks onto your profile for use in future consultations.</p>
                </div>
            </div>
            <div id="referenceAbout">Icons made by <a href="https://www.flaticon.com/authors/smashicons" title="Smashicons">Smashicons</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>

        </div>
    </body>
</html>

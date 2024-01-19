@extends('main')
@section('title', 'Home')
@section('content')
    <style>
        /* Custom styling for the images */
        .container {
            margin-top: 20px;
        }
        .main_img {
            width: 100%;
            max-width: 400px;
            height: 400px;

        }
        .custom-img {
            width: 100%;
            max-width: 200px;
            height: 200px;
        }

        .margin-10 {
            margin-left: -10%;
        }

        .main_title {
            margin-top: 20px
        }

        .profile {
            display: inline-flex;
            align-items: center;
            margin-top: 20px
        }

        .profile img {
            width: 60px;
            height: auto;
            margin-right: 10px;
        }

        .profile p {
            margin: 0;
        }

        .profile span {
            font-size: 12px;
        }
    </style>

    <div>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset('images/image1.jpg') }}" alt="Image 1" class="main_img">
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-4" style="margin-left: -1%;">
                            <img src="{{ asset('images/image1.jpg') }}" alt="Image 3" class="img-fluid custom-img">
                        </div>
                        <div class="col-md-4 margin-10">
                            <img src="{{ asset('images/image1.jpg') }}" alt="Image 3" class="img-fluid custom-img">
                        </div>
                        <div class="col-md-4 margin-10">
                            <img src="{{ asset('images/image1.jpg') }}" alt="Image 3" class="img-fluid custom-img">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4" style="margin-left: -1%;">
                            <img src="{{ asset('images/image1.jpg') }}" alt="Image 3" class="img-fluid custom-img">
                        </div>
                        <div class="col-md-4 margin-10">
                            <img src="{{ asset('images/image1.jpg') }}" alt="Image 3" class="img-fluid custom-img">
                        </div>
                        <div class="col-md-4 margin-10">
                            <img src="{{ asset('images/image1.jpg') }}" alt="Image 3" class="img-fluid custom-img">
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="main_title">
                    <h4>Tungro virus</h4>
                    <div class="profile">
                        <img src="{{ asset('images/profile.png') }}" alt="" width="60px">
                        <p>
                            <span>Admin123 <br>Jan, 07,2023</span>
                        </p>
                    </div>
                    <p class="mt-3">Tungrovirus is a genus of viruses, in the family Caulimoviridae, order Ortervirales. Monocots
                        and family Poaceae serve as natural hosts.Monocots and family Poaceae serve as natural hosts.</p>
                </div>
            </div>
        </div>

    </div>
    </div>
@endsection

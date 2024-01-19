@extends('main')
@section('title', 'Home')
@section('content')

    <style>
        .image-container {
            position: relative;
            display: inline-block;
        }
        .profile-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
        }
        .upload-icon {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 30px;
            height: 30px;
            color: white;
        }
        .text-detail{
            text-align: left;
        }
    </style>

    <div class="text-center">
        <h4 class='text-warning'>Please drop the image here</h4>
        <div class="image-container mt-5">
            <img src="{{ asset('images/heart-crop.jpg') }}" alt="" class="rounded-circle profile-image">
            <img src="{{ asset('images/upload_icon1.svg') }}" alt="" class="upload-icon">
        </div> <br> <br>

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Upload image
        </button>

        <!-- Modal -->
        <div class="modal fade mt-lg-5" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Image Successfully Detected</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <img src="{{ asset('images/image1.jpg') }}" alt="Image" class="rounded img-fluid">
                                    <h4 class="mt-3">Tungro virus</h4>
                                </div>
                                <div class="col-md-6 text-detail">
                                    <p>
                                        Tungrovirus is a genus of viruses, in the family Caulimoviridae, order Ortervirales. Monocots
                                        and family Poaceae serve as natural hosts. Monocots and family Poaceae serve as natural hosts.
                                    </p>
                                </div>
                            </div>
                            {{-- <button type="button" class="btn btn-success">View Detail</button> --}}
                            <a href="{{ route('home.show') }}">
                                <button type="button" class="btn btn-success">View Detail</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

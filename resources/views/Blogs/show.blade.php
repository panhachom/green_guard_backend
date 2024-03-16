@extends(backpack_view('blank'))
@php

    use App\Models\Blog;
    use App\Models\ImageFile;
    $blog = Blog::where('id', $crud->entry->id)->first();
    $model = 'App\Models\Blog';
    $image_files = ImageFile::where('parent_id', $crud->entry->id)->where('parent_type',$model)->get();
    // dd($image_file->file_path);
@endphp
<style>
    img{
        height: 10rem;
        object-fit: cover;
        border-radius: 1rem;
        margin-right: 10px;
    }
</style>
@section('header')
    <link rel="stylesheet" href="{!! asset("css/upload.css") !!}">
    <section class="container-fluid d-flex">
        <div>
            <h2>
                <span class="text-capitalize ml-3">Blog</span>
                @if ($crud->hasAccess('list'))
                    <small>
                        <a href="{{ url($crud->route) }}" class="d-print-none font-sm">
                            <i class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i>
                            {{ trans('backpack::crud.back_to_all') }}
                            <span>{{ $crud->entity_name_plural }}</span>
                        </a>
                    </small>
                @endif
            </h2>
        </div>
    </section>

@endsection
    <style>
        .image {
        height: 10rem;
        object-fit: cover;
        border-radius: 1rem;
    }
    textarea {
        resize: none;
    }
    </style>
@section('content')
<div class="col-sm-8">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <label class="my-1 mr-2">Title</label>
                    <input type="name" class="form-control" value="{{ $blog->title }}" disabled>
                </div>
                <div class="col-sm-12">
                    <label class="my-1 mr-2">sub title</label>
                    <input type="name" class="form-control" value="{{ $blog->sub_title }}" disabled>
                </div>
                <div class="col-sm-12">
                    <label class="my-1 mr-2">Category</label>
                    <input type="name" class="form-control" value="{{ $blog->category }}" disabled>
                </div>
                <div class="col-sm-12">
                    <label class="my-1 mr-2">Description</label>
                    <textarea class="form-control" cols="30" rows="8" disabled >{!! $blog->body !!}</textarea>

                </div>
                <div class="col-sm-12 mt-3">
                    <label class="my-1 mr-2">Images</label><br>

                    @if ($image_files)
                        @foreach ($image_files as $image_file)
                            <div style="display: inline-block; margin-right: 10px;" class="mt-4">
                                <img src="{{ asset($image_file->file_path) }}" style="cursor: pointer;"> <br>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="col-sm-12" style="margin-top: 30px; text-align:center">
                    <a href="{{ backpack_url('blog/' . $entry->getKey() . '/edit') }}" class="btn btn-sm btn-link"><i class="la la-edit"></i>Edit</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection





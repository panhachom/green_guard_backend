@extends(backpack_view('blank'))

@php
    use App\Models\User;

    $defaultBreadcrumbs = [
        trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
        $crud->entity_name_plural => url($crud->route),
        trans('backpack::crud.list') => false,
    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
    // $user = User::where('id',)
    if(backpack_user()->hasRole('normal_user')){
        $bolgs = $crud->model::where('user_id',backpack_auth()->user()->id)->get();
    }
    if(backpack_user()->hasRole('admin')){
        $bolgs = $crud->model->get();
    }
@endphp

@section('header')
  <div class="container-fluid">
    <h2>
      <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
      <small id="datatable_info_stack">{!! $crud->getSubheading() ?? '' !!}</small>
    </h2>
  </div>
@endsection

@section('content')
  {{-- Default box --}}
  <div class="row">

    {{-- THE ACTUAL CONTENT --}}
    <div class="{{ $crud->getListContentClass() }}">

        <div class="row mb-0">
          <div class="col-sm-6">
            @if ( $crud->buttons()->where('stack', 'top')->count() ||  $crud->exportButtons())
              <div class="d-print-none {{ $crud->hasAccess('create')?'with-border':'' }}">

                @include('crud::inc.button_stack', ['stack' => 'top'])

              </div>
            @endif
          </div>
          <div class="col-sm-6">
            <div id="datatable_search_stack" class="mt-sm-0 mt-2 d-print-none"></div>
          </div>
        </div>

        {{-- Backpack List Filters --}}
        @if ($crud->filtersEnabled())
          @include('crud::inc.filters_navbar')
        @endif
        <table class="bg-white table table-striped table-hover nowrap rounded shadow-xs border-xs mt-2">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Sub Title</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>User</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($bolgs))
                    @foreach ($bolgs as $bolg)
                        <tr>
                            <td>{{ $bolg->title }}</td>
                            <td>{{ $bolg->sub_title }}</td>
                            <td>{{ $bolg->category ?? 'no result' }}</td>
                            <td>
                                @if ($bolg->status == 1)
                                    <span class="badge bg-success">Published</span>
                                @else
                                    <span class="badge bg-warning">Unpublished</span>
                                @endif
                            </td>
                            <td>{{ $bolg->user->name }}</td>
                            <td>{{ $bolg->created_at }}</td>
                            <td>
                                <a href="{{ backpack_url('blog/' . $bolg->id . '/show') }}" class="btn btn-sm btn-link"><i class="la la-eye"></i>Preview</a>
                                <a href="{{ backpack_url('blog/' . $bolg->id . '/edit') }}" class="btn btn-sm btn-link"><i class="la la-edit"></i>Edit</a>
                                <form action="{{ route('blog.destroy', $bolg->id) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-sm btn-link"><i class="la la-trash"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>No result</td>
                    </tr>
                @endif

            </tbody>
        </table>


        @if ( $crud->buttons()->where('stack', 'bottom')->count() )
        <div id="bottom_buttons" class="d-print-none text-center text-sm-left">
        @include('crud::inc.button_stack', ['stack' => 'bottom'])

        <div id="datatable_button_stack" class="float-right text-right hidden-xs"></div>
        </div>
        @endif

    </div>

  </div>

@endsection

@section('after_styles')
  {{-- DATA TABLES --}}
  <link rel="stylesheet" type="text/css" href="{{ asset('packages/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('packages/datatables.net-fixedheader-bs4/css/fixedHeader.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('packages/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}">

  {{-- CRUD LIST CONTENT - crud_list_styles stack --}}
  @stack('crud_list_styles')
@endsection

@section('after_scripts')
  @include('crud::inc.datatables_logic')

  {{-- CRUD LIST CONTENT - crud_list_scripts stack --}}
  @stack('crud_list_scripts')
@endsection

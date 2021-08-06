@extends('main.main')
@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center mb-4">
    <a href="{{ route('get.list-menu') }}" class="text-gray-800 mr-3" style="font-size:1.5rem">
        <i class="fas fa-arrow-circle-left fa-fw"></i>
    </a>
    <h1 class="h3 mb-0 text-gray-800">{{ ucwords($title) }}</h1>
    <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Add New
    </a> -->
</div>
<!-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
    For more information about DataTables, please visit the <a target="_blank"
        href="https://datatables.net">official DataTables documentation</a>.</p> -->

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('post.store-menu') }}" method="POST" id="formAddMenu">
            @csrf
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="row">
                        <div class="col-lg-11 col-md-6 col-12">
                            <div class="form-group">
                                <label for="">Title</label>
                                <input type="text" name="title" id="title" class="form-control bg-gray-200 border-0" required>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="selectMenu">
                        <div class="col-lg-11 col-md-6 col-12"> 
                            <div class="form-group">
                                <label for="">Menu Parent</label>
                                <select class="select2 form-control bg-gray-200 border-0" name="menu_id">
                                    @for ($i = 0; $i < count($menu); $i++)
                                    <option value="{{ $menu[$i]['id'] }}">{{ $menu[$i]['name'] }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="row">
                        <div class="col-lg-10 col-md-12">
                            <div class="form-group" id="select2ErrorInstalasi">
                                <label for="" class="label-form">Make Sub Menu</label>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="child" id="customSwitch1" value="1">
                                    <label class="custom-control-label" for="customSwitch1">*Choose to set sub menu true</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row mt-4">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary px-4">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

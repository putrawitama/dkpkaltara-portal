@extends('main.main')
@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center mb-4">
    <a href="{{ route('get.list-user') }}" class="text-gray-800 mr-3" style="font-size:1.5rem">
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
        <form action="{{ route('post.update-user') }}" method="POST" id="formEditUser" ajax="true">
            @csrf
            <input type="hidden" name="id" value="{{ $detail['id'] }}">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="row">
                        <div class="col-lg-11 col-md-6 col-12">
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" name="name" id="name" class="form-control bg-gray-200 border-0" placeholder="Enter name" required value="{{ $detail['name'] }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-11 col-md-6 col-12">
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" name="email" id="email" class="form-control bg-gray-200 border-0" placeholder="Enter email" required value="{{ $detail['email'] }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-11 col-md-6 col-12">
                            <div class="form-group">
                                <label for="">User Type</label>
                                <select name="user_type" id="user_type" class="form-control bg-gray-200 border-0">
                                    <option value="">Choose User Type</option>
                                    <option value="1" {{ $detail['user_type'] == 1 ? 'selected' : '' }}>Super Admin</option>
                                    <option value="2" {{ $detail['user_type'] == 2 ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-11 col-md-6 col-12">
                            <div class="form-group with-eye-error">
                                <label for="">New Password</label>
                                <div class="d-flex with-eye">
                                    <input type="password" name="password" id="password" class="form-control bg-gray-200 border-0" placeholder="Enter password">
                                    <div class="eye-content">
                                        <i class="fas fa-fw fa-eye"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-11 col-md-6 col-12">
                            <div class="form-group with-eye-error">
                                <label for="">Confirm New Password</label>
                                <div class="d-flex with-eye">
                                    <input type="password" name="cPassword" id="cPassword" class="form-control bg-gray-200 border-0" placeholder="Enter confirm password">
                                    <div class="eye-content">
                                        <i class="fas fa-fw fa-eye"></i>
                                    </div>
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

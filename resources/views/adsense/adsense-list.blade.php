@extends('main.main')
@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ ucwords($title) }}</h1>
    <a href="{{ route('get.add-adsense') }}" class="d-none d-sm-inline-block btn btn-primary shadow-sm px-4">
        <i class="fas fa-plus fa-sm text-white-50"></i> Add New
    </a>
</div>
<!-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
    For more information about DataTables, please visit the <a target="_blank"
        href="https://datatables.net">official DataTables documentation</a>.</p> -->

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered w-100 display" id="tableAdsense" cellspacing="0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Link</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Created at</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

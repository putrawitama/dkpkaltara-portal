@extends('main.main')
@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ ucwords($title) }}</h1>
    <a href="{{ route('get.add-jobs') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Add New
    </a>
</div>
<!-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
    For more information about DataTables, please visit the <a target="_blank"
        href="https://datatables.net">official DataTables documentation</a>.</p> -->

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <table class="table table-bordered w-100" id="tableJobs" cellspacing="0">
            <thead>
                <tr>
                    <th>Job Position</th>
                    <th>Job Description</th>
                    <th>Placement</th>
                    <th>Created At</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>

@endsection

@extends('main.main')
@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
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
        <form action="{{ route('post.store-jobs') }}" method="POST" id="formAddJobs" ajax="true">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="row">
                        <div class="col-lg-11 col-md-6 col-12">
                            <div class="form-group">
                                <label for="">Job Position</label>
                                <input type="text" name="job_position" id="job_position" class="form-control bg-gray-200 border-0" placeholder="Enter job position">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-11 col-lg-6 col-12">
                            <div class="form-group">
                                <label for="">Job Description</label>
                                <textarea name="job_desc" id="job_desc" cols="10" rows="4" class="form-control bg-gray-200" placeholder="Enter job description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12">
                    <div class="row">
                        <div class="col-lg-11 col-lg-6 col-12">
                            <div class="form-group">
                                <label for="">Requirement</label>
                                <textarea name="requirement" id="requirement" cols="10" rows="4" class="form-control bg-gray-200" placeholder="Enter requirement"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="row">
                        <div class="col-lg-11 col-md-6 col-12">
                            <div class="form-group">
                                <label for="">Placement</label>
                                <input type="text" name="job_position" id="job_position" class="form-control bg-gray-200 border-0" placeholder="Enter job position">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary px-4">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

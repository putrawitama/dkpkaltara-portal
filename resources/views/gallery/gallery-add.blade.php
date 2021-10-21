@extends('main.main')
@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center mb-4">
    <a href="{{ route('get.list-gallery') }}" class="text-gray-800 mr-3" style="font-size:1.5rem">
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
        <form action="{{ route('post.store-gallery') }}" method="POST" id="formAddGallery" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="row">
                        <div class="col-lg-11 col-md-6 col-12">
                            <div class="form-group">
                                <label for="">Title</label>
                                <input type="text" name="title" id="title" class="form-control bg-gray-200 border-0" placeholder="Enter title">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-11 col-lg-6 col-12">
                            <div class="form-group">
                                <label for="">Description</label>
                                <textarea name="desc" id="desc" cols="10" rows="4" class="form-control bg-gray-200" placeholder="Enter description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="row">
                        <div class="col-lg-10 col-md-12">
                            <div class="form-group" id="select2ErrorInstalasi">
                                <label for="" class="label-form">Publish</label>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="publish" id="customSwitch1" value="1">
                                    <label class="custom-control-label" for="customSwitch1">*Choose to publish gallery</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-10 col-md-12">
                            <div class="form-group" id="select2type">
                                <label for="" class="label-form">Upload Video?</label>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="isVideo" id="customSwitch2" value="1">
                                    <label class="custom-control-label" for="customSwitch2">*Choose to upload video</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="videos">
                        <div class="col-lg-10 col-md-12">
                            <div class="form-group">
                                <label for="exampleFormControlFile1">Choose video <small class="text-danger">*Max 64MB, file mp4</small></label>
                                <input type="file" class="form-control-file" id="exampleFormControlFile1" name="video[]" id="video" accept="video/mp4">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div id="images">
                <div class="row mb-4">
                    <div class="col-lg-6 col-md-12">
                        <button type="button" class="btn btn-primary btn-add-gallery">
                            <i class="fas fa-plus"></i> Add Image
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-11 col-md-12">
                        <div id="listGallery" class="d-flex flex-wrap">
                            <div class="form-group mx-2" id="uploadGambar">
                                <div class="custom-file-multiple">
                                    <input type="file" class="custom-file-input imageMore" name="image[]" id="image" accept=".jpg, .png, .jpeg">
                                    <label class="custom-file-label" for="image">
                                        <button type="button" class="btn-remove-image">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </label>
                                    <span><i class="fas fa-images"></i></span>
                                </div>
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

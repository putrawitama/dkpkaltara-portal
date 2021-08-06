@extends('main.main')
@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center mb-4">
    <a href="{{ route('get.list-article') }}" class="text-gray-800 mr-3" style="font-size:1.5rem">
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
        <form action="{{ route('post.update-article') }}" method="POST" id="formEditArticle" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $detail['id'] }}">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="row">
                        <div class="col-lg-11 col-md-6 col-12">
                            <div class="form-group">
                                <label for="">Title</label>
                                <input type="text" name="title" id="title" class="form-control bg-gray-200 border-0" placeholder="Enter title" value="{{ $detail['title'] }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-11 col-md-6 col-12"> 
                            <div class="form-group">
                                <label for="">Menu</label>
                                <select class="select2 form-control bg-gray-200 border-0" name="sub_menu">
                                    @for ($i = 0; $i < count($menu); $i++)
                                    <option value="{{ $menu[$i]['id'] }}" {{ $menu[$i]['id'] == $detail['sub_menu_id'] ? 'selected' : '' }}>{{ $menu[$i]['name'] }}</option>
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
                                <label for="" class="label-form">Publish</label>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="publish" id="customSwitch1" value="1" {{ $detail['publish'] == 1 ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="customSwitch1">*Choose to publish gallery</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-11 col-lg-6 col-12">
                    <div class="form-group">
                        <label for="">Content</label>
                        <textarea name="desc" id="contentArticle" rows="10" class="form-control bg-gray-200 h-50" placeholder="Enter description">{{ $detail['description'] }}</textarea>
                    </div>
                </div>
            </div>
            <hr>
            <!-- <div class="row mb-4">
                <div class="col-lg-6 col-md-12">
                    <button type="button" class="btn btn-primary btn-add-gallery">
                        <i class="fas fa-plus"></i> Add Image
                    </button>
                </div>
            </div> -->
            <div class="row">
                <div class="col-lg-11 col-md-12">
                    <div id="listGallery" class="d-flex flex-wrap">
                        @for ($i = 0; $i < count($detail['images']); $i++)
                        <div class="form-group mx-2" id="uploadGambar">
                            <input type="hidden" name="imgReview[]" value="{{ $detail['images'][$i] }}">
                            <div class="custom-file-multiple" style="background-image:url({{ url('storage').'/'.$detail['images'][$i] }})">
                                <input type="file" class="custom-file-input imageMore" name="image[]" id="image" accept=".jpg, .png, .jpeg">
                                <!-- <label class="custom-file-label" for="image">
                                    <button type="button" class="btn-remove-image-exist">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </label> -->
                                <!-- <span><i class="fas fa-images"></i></span> -->
                            </div>
                        </div>
                        @endfor
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

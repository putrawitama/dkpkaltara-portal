@extends('landing.main')
@section('content')
<div class="container mb-5">
        <hr style="border-color: #004385">
        <p class="lead">Galeri</p>
        <hr style="border-color: #004385" class="mb-5">
        
        @if($is_detail)
            <p>Diunggah pada {{ $detail->created_at }}</p>
            <h3 class=" mb-2 font-weight-bold mb-4" style="color: #004385">{{ $detail->title }}</h3>
            {!! $detail->desc !!}
            @if($type === 'photo')
                @php $images = json_decode($detail->images); @endphp
                <div class="row mt-3">
                @foreach($images as $img)
                    <div class="col-md-3">
                        <a href="#" onclick="showPreview(this)" data-image="{{ url('storage').'/'.$img }}">
                            <div class="card bg-dark text-white">
                                <img src="{{ url('storage').'/'.$img }}" class="card-img" alt="image gallery">
                            </div>
                        </a>
                    </div>
                    <!-- <img class="d-block w-100 mb-4" src="{{ url('storage').'/'.$img }}" alt="First slide"> -->
                @endforeach
                </div>
            @else
                <video class="card-img-top w-100" controls>
                    <source src="{{ url('storage').'/'.json_decode($detail->images)[0] }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            @endif
            <div class="fb-comments w-100 mt-5" data-href="{{ Request::url() }}" data-width="auto" data-numposts="5"></div>
        @else
            <h3 class=" mb-5 font-weight-bold" style="color: #004385">Daftar Galeri {{ $type === 'video' ? 'Video' : 'Foto' }}</h3>
            <div class="row">
            @for($i = 0; $i < count($list); $i++)
                <div class="card col-md-3 p-0">
                    @if($type === 'photo')
                        <img class="card-img-top" src="{{ url('storage').'/'.json_decode($list[$i]->images)[0] }}" alt="Card image cap">
                    @else
                    <video class="card-img-top w-100">
                        <source src="{{ url('storage').'/'.json_decode($list[$i]->images)[0] }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $list[$i]->title }}</h5>
                        <p class="card-text">{{ $list[$i]->created_at }}</p>
                        <a href="{{ route('landing.gallery.detail', ['type' => $list[$i]->type ? 'video' : 'photo', 'id' => $list[$i]->id]) }}" class="btn btn-primary">Detail</a>
                    </div>
                </div>
            @endfor
            </div>
        @endif
    </div>
    <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Image preview</h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
                <div class="modal-body">
                    <img src="" id="imagepreview" class="w-100">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
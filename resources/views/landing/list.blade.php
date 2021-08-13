@extends('landing.main')
@section('content')
<div class="container mb-5">
        <hr style="border-color: #004385">
        <p class="lead">{{ $navbar }}</p>
        <hr style="border-color: #004385" class="mb-5">
        
        @if($is_detail)
            <p>Diunggah pada {{ $detail->created_at }}</p>
            <h3 class=" mb-2 font-weight-bold" style="color: #004385">{{ $detail->title }}</h3>
            <img class="d-block w-100 mb-4" src="{{ url('storage').'/'.json_decode($detail->thumbnail)[0] }}" alt="First slide">
            {!! $detail->description !!}
            <div class="fb-comments w-100 mt-5" data-href="{{ Request::url() }}" data-width="auto" data-numposts="5"></div>
        @else
            <h3 class=" mb-5 font-weight-bold" style="color: #004385">{{ $navbar }}</h3>
            <div class="row">
                <div class="col-md-8">
                    @for($i = 0; $i < count($list); $i++)
                    <div class="row mb-3">
                        <div class="card w-100 p-0">
                            <img class="card-img-top" src="{{ url('storage').'/'.json_decode($list[$i]->thumbnail)[0] }}" alt="Card image cap">
                            <div class="card-body">
                                <h4 class="card-title">{{ $list[$i]->title }}</h4>
                                <h6 class="card-subtitle mb-2 text-muted">{{ $list[$i]->created_at }}</h6>
                                <p class="lead mt-3">
                                    @php
                                        $cleanTag = strip_tags($list[$i]->description);
                                        $string = strlen($cleanTag) > 50 ? substr($cleanTag,0,50)."..." : $cleanTag;
                                    @endphp
                                    {{ $string }}
                                </p>
                                <a href="{{ route('landing.detail', ['menu' => $list[$i]->subMenu->slug, 'article' => $list[$i]->slug]) }}" class="card-link">Read More</a>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
            
        @endif
    </div>
@endsection
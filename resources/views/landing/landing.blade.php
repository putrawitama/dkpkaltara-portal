@extends('landing.main')
@section('content')
<div class="container mb-5">
<div class="row mx-auto my-auto">
        <div id="recipeCarousel" class="carousel slide w-100" data-ride="carousel">
            <div class="carousel-inner carousel-inner-link w-100" role="listbox">
                @foreach($link as $key => $d)
                <div class="carousel-item carousel-link {{ $key === 0 ? 'active' : '' }}">
                    <div class="col-md-3">
                        <a href="{{ $d->link }}">
                            <div class="card">
                                <img class="card-img" src="{{ url('storage').'/'.json_decode($d->image)[0] }}">
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
                
            </div>
            <a class="carousel-control-prev w-auto" href="#recipeCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next w-auto" href="#recipeCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-8">
            <hr style="border-color: #004385">
            <p class="lead">Berita Terkini</p>
            <hr style="border-color: #004385">
            <div class="row mb-4">
                <div id="carouselExampleIndicators" class="carousel slide w-100" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                    </ol>
                    <div class="carousel-inner">
                        @for($i = 0; $i < 4; $i++)
                        @if(!isset($article[$i]))
                            @break
                        @endif
                        @if($i == 0)
                        <div class="carousel-item active">
                        @else
                        <div class="carousel-item">
                        @endif
                            <a href="{{ route('landing.detail', ['menu' => $article[$i]->subMenu->slug, 'article' => $article[$i]->slug]) }}">
                                <img class="d-block w-100" src="{{ url('storage').'/'.json_decode($article[$i]->thumbnail)[0] }}" alt="First slide">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>{{ $article[$i]->title }}</h5>
                                </div>`
                            </a>
                        </div>
                        @endfor
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>

            <h3 class="text-dark mt-5">
                Lainnya
            </h3>
            <div class="row mt-2">
                @for($i = 4; $i < 9; $i++)
                @if(!isset($article[$i]))
                    @break
                @endif
                <div class="col-md-4 mb-4">
                    <div class="card w-100">
                        <div class="w-100" style="height: 150px; overflow: hidden;">
                            <img class="card-img-top w-100" src="{{ url('storage').'/'.json_decode($article[$i]->thumbnail)[0] }}" alt="Image Title">
                        </div>
                        <div class="card-body">
                            <h4 class="card-title mb-3 text-dark text-cut">{{ $article[$i]->title }}</h4>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $article[$i]->created_at }}</h6>
                            <p class="lead">
                                @php
                                    $cleanTag = strip_tags($article[$i]->description);
                                    $string = strlen($cleanTag) > 400 ? substr($cleanTag,0,40)."..." : $cleanTag;
                                @endphp
                                {{ $string }}
                            </p>
                            <a href="{{ route('landing.detail', ['menu' => $article[$i]->subMenu->slug, 'article' => $article[$i]->slug]) }}" class="card-link">Read more ...</a>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-12 mt-3">
                    <iframe class="w-100" src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FDinas-Kelautan-dan-Perikanan-Provinsi-Kalimantan-Utara-102199581418319%2F&tabs=timeline&width=340&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=false&appId" width="340" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mt-5">
                    <iframe class="w-100" height="490" src="https://www.instagram.com/p/{{ $latestIg }}/embed" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

@if($ads !== null)
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">{{ $ads->title }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <a href="{{ $ads->link }}" target="_blank"> 
            <img class="img-thumbnail w-100" src="{{ url('storage').'/'.json_decode($ads->image)[0] }}" alt="First slide">
        </a>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endif
@endsection
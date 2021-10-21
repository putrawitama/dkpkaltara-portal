@extends('main.main')
@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center mb-4">
    <a href="{{ route('get.list-mail') }}" class="text-gray-800 mr-3" style="font-size:1.5rem">
        <i class="fas fa-arrow-circle-left fa-fw"></i>
    </a>
    <h1 class="h3 mb-0 text-gray-800">{{ ucwords($title) }}</h1>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <ul class="list-group">
                    <li class="list-group-item">{{ $detail['subject'] }}</li>
                    <li class="list-group-item">{{ $detail['name'] }}</li>
                    <li class="list-group-item">{{ $detail['email'] }}</li>
                    <li class="list-group-item">{{ $detail['phone'] }}</li>
                    <li class="list-group-item">{{ $detail['is_responded'] ? 'Sudah Diresponse' : 'Belum ada response'}}</li>
                </ul>
            </div>
            <div class="col-md-8">
                <h3>Isi Pesan</h3>
                <p>{{ $detail['message'] }}</p>
            </div>
        </div>
    </div>
</div>

@endsection

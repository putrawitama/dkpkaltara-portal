@extends('landing.main')
@section('content')
<div class="container mb-5">
        <hr style="border-color: #004385">
        <p class="lead">Hubungi Kami</p>
        <hr style="border-color: #004385" class="mb-5">
        
        <form action="{{ route('landing.contact-post') }}" method="POST" id="formContactUs">
            @csrf
            <div class="form-group">
                <label for="inputAddress">Subject</label>
                <input type="text" name="subject" class="form-control" id="inputSubject" placeholder="Subject" required>
            </div>
            <div class="form-group">
                <label for="inputAddress">Name</label>
                <input type="text" name="name" class="form-control" id="inputName" placeholder="John Doe" required>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Email</label>
                    <input type="email" name="email"  class="form-control" id="inputEmail" placeholder="Email" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">Telepon</label>
                    <input type="input" name="phone"  class="form-control" id="inputPhone" placeholder="Nomor Telepon" required>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Pesan</label>
                <textarea class="form-control" name="message" id="inputMessage" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-lg">Kirim</button>
        </form>
</div>
@endsection
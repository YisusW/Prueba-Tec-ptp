@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div id="app"  class="col-md-8">

          <form-payer id_bayer="{{$id_comprador}}"></form-payer>
        </div>
    </div>
@endsection

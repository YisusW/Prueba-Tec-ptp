@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div id="app"  class="col-md-8">
          @if(isset($data))
            <form-bank :personas="{{json_encode($data)}}" ></form-bank>
          @else
            <form-bank ></form-bank>
          @endif

        </div>
    </div>
</div>
@endsection

@extends('web.app-layouts.app')

@section('content')

    <section class="sec-termsandcondition">
        <div class="container">
            <div class="title-termsCondition">
                {{ $row->title }}
            </div>
            <div class="content-termsAndCondition">
                {!! $row->description !!}
            </div>
        </div>
    </section>
    
@endsection
@section('javascripts')

@endsection
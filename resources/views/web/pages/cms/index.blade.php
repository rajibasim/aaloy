@extends('web.layouts.app')

@section('content')
    <aside class="asi-breadcrump" style="display: {{ isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'app' ? 'none;' : '' }}">
        <div class="container">
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a class="active">{{ $row->title }}</a></li>
            </ul>
        </div>
    </aside>
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
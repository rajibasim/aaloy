@extends('web.layouts.app')

@section('styles')
    <link href="{{ asset('public/frontend/assets/css/blog.css') }}" rel="stylesheet" />
@endsection

@section('content')

    <aside class="asi-breadcrump" style="display: {{ isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'app' ? 'none;' : '' }}">
        <div class="container">
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a class="active">Blogs</a></li>
            </ul>
        </div>
    </aside>
    <!-- Blog Body -->
    <section class="sec-bloglist">
        <div class="container">
            <div class="title-blog">Blogs</div>
            <ul>
                @if(isset($row) && $row)
                    @foreach ( $row as $key => $res )
                        <li>
                            <a href="{{ url('blogs/'.$res->slug) }}">
                                <div class="image">
                                    <figure>
                                        <img src="{{ url($res->blog_image) }}" alt="" />
                                    </figure>
                                </div>
                                <div class="topic">{{ $res->category }}</div>
                                <div class="blogtitle">
                                    {{ $res->title }}
                                </div>
                                <div class="wirter-date-comments">
                                    <span>By <strong>{{ $res->author }}</strong></span>
                                    <span>- {{ date('M d, Y', strtotime($res->created_at)) }}</span>
                                </div>
                            </a>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </section>

@endsection
@section('javascripts')

@endsection
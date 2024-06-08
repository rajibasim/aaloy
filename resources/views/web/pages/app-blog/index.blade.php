@extends('web.app-layouts.app')

@section('styles')
    <link href="{{ asset('public/frontend/assets/css/blog.css') }}" rel="stylesheet" />
@endsection

@section('content')

    <!-- Blog Body -->
    <section class="sec-bloglist">
        <div class="container">
            <div class="title-blog">Blogs</div>
            <ul>
                @if(isset($row) && $row)
                    @foreach ( $row as $key => $res )
                        <li>
                            <a href="{{ url('app-blogs/'.$res->slug) }}">
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
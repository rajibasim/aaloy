@extends('web.app-layouts.app')

@section('styles')
    <link href="{{ asset('public/frontend/assets/css/blog.css') }}" rel="stylesheet" />
@endsection

@section('content')

    <!-- Blog Body -->
    <!-- Blog details Banner -->
    <section class="sec-banner-details">
        <div class="container">
            <div class="image">
                <figure>
                    <img src="{{ url($row->blog_image) }}" alt="" /> 
                </figure>
            </div>
        </div>
    </section>
    <!-- Blog Body -->
    <section class="sec-bloglist sec-blog-details">
        <div class="container">
            <aside class="asi-details-left">
                <div class="topic">{{ $row->category }}</div>
                <div class="blogtitle">
                    {{ $row->title }}
                </div>
                <div class="wirter-date-comments">
                    <span>By <strong>{{ $row->author }}</strong></span>
                    <span>- {{ date('M d, Y', strtotime($row->created_at)) }}</span>
                </div>
                <div class="detailsp">
                    {!! $row->description !!}
                </div>   
            </aside>
            @if(isset($recent) && $recent)
                <aside class="asi-details-right">
                    <div class="title-blog">Recent Posts</div>
                    <ul>
                        @foreach ( $recent as $key => $res )
                            <li>
                                <a href="#">
                                    <div class="image">
                                        <figure>
                                            <img src="{{ url($res->blog_image) }}" alt="" />
                                        </figure>
                                    </div>
                                    <div class="blog-listcontent">
                                        <div class="topic">{{ $res->category }}</div>
                                        <div class="blogtitle">
                                            {{ $res->title }}
                                        </div>
                                        <div class="wirter-date-comments">
                                            <span>By <strong>{{ $res->author }}</strong></span>
                                            <span>- {{ date('M d, Y', strtotime($res->created_at)) }}</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </aside>
            @endif
        </div>
    </section>
   
@endsection
@section('javascripts')

@endsection
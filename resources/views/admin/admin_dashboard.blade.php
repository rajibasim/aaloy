@extends('../master_layout/admin_master')

@section('title')
<title>{{trans('labels.0') }}</title>
@endsection

@section('content_header')
<a href="{{url('admin-dashboard')}} "><i class="icon-home"></i> {{trans('labels.9')}}</a>
<style>
    /* Style the tab */
    div.tab {
        overflow: hidden;
        border: 1px solid #ccc;
        background-color: #f1f1f1;
    }

    /* Style the buttons inside the tab */
    div.tab button {
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        transition: 0.3s;
    }

    /* Change background color of buttons on hover */
    div.tab button:hover {
        background-color: #ddd;
    }

    /* Create an active/current tablink class */
    div.tab button.active {
        background-color: #ccc;
    }

    /* Style the tab content */
    .tabcontent {
        display: none;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-top: none;
    }
</style>
@endsection

@section('custom_js')
<!--<script src="{{asset('public/assets/Myfile/item_js.js')}}"></script>-->
<script>
    function openCity(evt, cityName) {
        // Declare all variables
        var i, tabcontent, tablinks;

        // Get all elements with class="tabcontent" and hide them
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // Get all elements with class="tablinks" and remove the class "active"
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        // Show the current tab, and add an "active" class to the button that opened the tab
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>
@endsection

@section('content')

<div clas="span12" style="display:block; border: 0 1px 1px 1px solid #000;">  
    <div class="quick-actions_homepage">
        <ul class="quick-actions">
            <li class="bg_lh "><a><i class="icon-building"></i> <strong>@if(!empty($total_product)){{$total_product}}@else {{'0'}} @endif</strong><br> <small>Total Products</small></a></li>
            <li class="bg_lr "><a><i class="icon-money"></i> <strong>@if(!empty($total_customer)){{$total_customer}}@else {{'0'}} @endif</strong><br> <small>Total Customers</small></a></li>
            <li class="bg_ls "><a><i class="icon-money"></i> <strong>@if(!empty($total_order)){{$total_order}}@else {{'0'}} @endif</strong><br> <small>Total Orders</small></a></li>
            <li class="bg_lv "><a><i class="icon-money"></i> <strong>@if(!empty($total_store)){{$total_store}}@else {{'0'}} @endif</strong><br> <small>Total Stores</small></a></li>
        </ul>
    </div>
</div>

@endsection
@extends('layouts.master')

@section('content')

    <div class="content">

        <div class="row">
            <div class="col-md-7 col-lg-7 main_content">
                <!-- Main charts -->
                <div class="page-header">
                    <div class="page-header-content">
                        <div class="page-title" style="display: flex;justify-content: space-between">
                            <h2><img src="{{asset('assets/images/searchIcon.png')}}" style="cursor: pointer" alt=""> <span class="text-semibold subtitle">search.</span></h2>
                            <div style="display: flex;flex-direction: row;align-items: center">
                                <span style="color: #CCCCCC;display: flex;align-items: flex-end;font-size: 1vw;">Artists</span>
                                <input type="checkbox" class="toggle-control" id="toggle" name="group_del">
                                <label for="toggle"></label>
                                <span style="color: #CCCCCC;display: flex;align-items: flex-end;font-size: 1vw;margin-left: 2vw">Labels</span>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="display: flex;justify-content: center">
                        <span class="search_AZ">a &nbsp;</span>
                        <span class="search_AZ">b &nbsp;</span>
                        <span class="search_AZ">c &nbsp;</span>
                        <span class="search_AZ">d &nbsp;</span>
                        <span class="search_AZ">e &nbsp;</span>
                        <span class="search_AZ">f &nbsp;</span>
                        <span class="search_AZ">g &nbsp;</span>
                        <span class="search_AZ">h &nbsp;</span>
                        <span class="search_AZ">i &nbsp;</span>
                        <span class="search_AZ">j &nbsp;</span>
                        <span class="search_AZ">k &nbsp;</span>
                        <span class="search_AZ">l &nbsp;</span>
                        <span class="search_AZ">m &nbsp;</span>
                        <span class="search_AZ">n &nbsp;</span>
                        <span class="search_AZ">o &nbsp;</span>
                        <span class="search_AZ">p &nbsp;</span>
                        <span class="search_AZ">q &nbsp;</span>
                        <span class="search_AZ">r &nbsp;</span>
                        <span class="search_AZ">s &nbsp;</span>
                        <span class="search_AZ">t &nbsp;</span>
                        <span class="search_AZ">u &nbsp;</span>
                        <span class="search_AZ">v &nbsp;</span>
                        <span class="search_AZ">w &nbsp;</span>
                        <span class="search_AZ">x &nbsp;</span>
                        <span class="search_AZ">y &nbsp;</span>
                        <span class="search_AZ">z &nbsp;</span>
                    </div>
                </div>
                <div class="panel panel-flat uploader">

                </div>
            </div>
            @component('shared.info_panel')
            @endcomponent
            {{--<div class="col-lg-5 col-md-5">--}}
                {{--<!-- Main charts -->--}}
                {{--<div class="page-header">--}}
                    {{--<div class="page-header-content right">--}}
                        {{--<span class="huge-number">4</span>--}}
                        {{--<span class=""></span>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<section class="panel right_widget">--}}
                    {{--<header class="panel-heading right_panel">--}}
                        {{--<div class="right_qrcode row">--}}
                            {{--<div class="col-md-4" style="display: flex;justify-content: center">--}}
                                {{--<img class="lazy" src="{{asset('assets/images/icons/qrcode.png')}}" alt="" style="width: 5vw;height: 5vw;">--}}
                            {{--</div>--}}
                            {{--<div class="col-md-8" style="display: flex;align-items: center">--}}
                                {{--<div class="right_title"><strong>{{ Auth::user()['first_name']." ".Auth::user()['lastname'] }}</strong></div>--}}
                            {{--</div>--}}

                        {{--</div>--}}
                        {{--<div class="right_social row">--}}
                            {{--<a href="#"><strong><i class="fa fa-facebook"></i></strong></a>--}}
                            {{--<a href="#"><strong><i class="fa fa-twitter"></i></strong></a>--}}
                            {{--<a href="#"><strong><i class="fa fa-instagram"></i></strong></a>--}}
                            {{--<a href="#"><strong><i class="fa fa-cloud"></i></strong></a>--}}
                            {{--<a href="#"><strong><i class="fa fa-headphones"></i></strong></a>--}}
                        {{--</div>--}}
                    {{--</header>--}}
                    {{--<div class="panel-body right_body">--}}
                        {{--<p id="uname">Edu Imbernon & Los Suruba</p>--}}
                        {{--<div class="right_body_state">--}}
                            {{--<div class="state_title" id="music_title">FORMENTERA</div>--}}
                            {{--<div class="state_date" id="music_duration">8:25min<br>--}}
                                {{--<span class="last_time" id="music_ltime">45mins ago</span>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="right_message">--}}
                            {{--<input type="textarea" name="message">--}}
                        {{--</div>--}}
                        {{--<ul class="tag_group">--}}
                            {{--<li><button type="button" class="btn"><strong>mastered</strong></button></li>--}}
                            {{--<li><button type="button" class="btn"><strong>unreleased</strong></button></li>--}}
                            {{--<li><button type="button" class="btn"><strong>wav</strong></button></li>--}}
                            {{--<li><button type="button" class="btn"><strong>24bit</strong></button></li>--}}
                            {{--<li><button type="button" class="btn"><strong>44.1k</strong></button></li>--}}
                            {{--<li><button type="button" class="btn"><strong>-6db of headroom</strong></button></li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</section>--}}
            {{--</div>--}}
        </div>
    </div>
@endsection
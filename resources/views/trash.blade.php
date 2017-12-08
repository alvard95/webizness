@extends('layouts.master')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-7 col-md-7 main_content">
            <!-- Main charts -->
            <div class="page-header">
                <div class="page-header-content">
                    <div class="page-title">
                        <h2>
                            @if(count($musics) > 0)
                                <img class="lazy" src="{{asset('assets/images/icons/icon_inbox.png')}}" style="cursor: pointer" class="play {{$musics[0]->file_id}}" onclick="displayDetails({{json_encode($musics[0])}}, this)" alt="">
                            @else
                                <img class="lazy" src="{{asset('assets/images/icons/icon_inbox.png')}}" style="cursor: pointer" alt="">
                            @endif
                            <span class="text-semibold subtitle">recent trash.</span></h2>
                    </div>

                    <div class="heading-elements">
                        <div class="heading-btn-group">
                            <a  class="btn btn-link btn-float has-text btn-prev"><img class="lazy" src="{{asset('assets/images/icons/icon_prev.png')}}" alt=""></a>
                            <a  class="btn btn-link btn-float has-text btn-next"><img class="lazy" src="{{asset('assets/images/icons/icon_next.png')}}" alt=""></a>
                            <a  class="btn btn-link btn-float has-text btn-shuffle"><img class="lazy" src="{{asset('assets/images/icons/icon_reload.png')}}" alt="" style="width: 1.8vw"></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-flat">
                @foreach($musics as $music)

                    @if($music->filter == 0)
                        <div class="row v jwplayer" id="audioplayer" data-id="{{$music->file_id}}" data-file="{{ $music->file_name }}">
                            {{--<audio id="music" class="music" preload="true">--}}
                            {{--<source src="uploads/{{$music->file_name}}">--}}
                            {{--</audio>--}}
                            <div class="m_avatar">
                                <div class="avatar_info">
                                    <img src="{{ asset("assets/images/profile/icon_avatar_1.png")}}" alt="" class="avatar-back avatar_0">
                                    <img src="{{ asset('assets/images/profile/'.$music->avatar)}}" alt="" class="avatar-back avatar_1">
                                    <button id="pButton" class="play {{$music->file_id}}"  onclick="displayDetails({{json_encode($music)}}, this)"></button>
                                </div>
                                <div class="m_brief">{{$music->first_name}} {{$music->last_name}}</div>
                                <div class="m_name">{{$music->title}}</div>
                            </div>
                            <div class="progressbar">
                                <div id="timeline">
                                    <div id="playhead" class="playhead"></div>
                                </div>
                            </div>
                            <div class="m_action">
                                <a class="item-action" >
                                    @if($music->favorite == 1)
                                        <img class="lazy" src="{{ asset("assets/images/icons/icon_favourite2.png")}}" />
                                    @else
                                        <img class="lazy" src="{{ asset("assets/images/icons/favourite_unselect.png")}}" />
                                    @endif
                                </a>
                                <a class="item-action" onclick="onDelete({{$music->file_id}},1)"><img class="lazy" src="assets/images/icons/icon_delete.png" style="width: 1vw" /></a>
                                <a class="item-action" onclick="onFilter({{$music->file_id}})"><img class="lazy" src="assets/images/icons/icon_filter.png" /></a>
                                <div class="m_action_icon">
                                    <div class="first filter">
                                        <a href="#" style="display:block; width: 100%;height: 100%"><i class="fa fa-angle-right"></i></a>
                                    </div>
                                    <div class="second">
                                        @if($music->display == null)
                                            <a href="uploads/{{$music->file_name}}" download><img class="lazy" src="assets/images/icons/icon_download.png"/></a>
                                        @else
                                            <img class="lazy" src="assets/images/icons/icon_unavailable.png">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        {{--<div class="col-lg-7 col-md-7 main_content">--}}
            {{--<!-- Main charts -->--}}
            {{--<div class="page-header">--}}
                {{--<div class="page-header-content">--}}
                    {{--<div class="page-title">--}}
                        {{--<h2><img src="{{asset('assets/images/icons/icon_inbox.png')}}" alt=""> <span class="text-semibold subtitle">recent trash.</span></h2>--}}
                    {{--</div>--}}
                    {{--<div class="heading-elements">--}}
                        {{--<div class="heading-btn-group">--}}
                            {{--<a href="#" class="btn btn-link btn-float has-text btn-prev">--}}
                                {{--<img src="{{asset('assets/images/icons/icon_prev.png')}}" alt="">--}}
                            {{--</a>--}}
                            {{--<a href="#" class="btn btn-link btn-float has-text btn-next">--}}
                                {{--<img src="{{asset('assets/images/icons/icon_next.png')}}" alt="">--}}
                            {{--</a>--}}
                            {{--<a href="#" class="btn btn-link btn-float has-text btn-shuffle">--}}
                                {{--<img src="{{asset('assets/images/icons/icon_reload.png')}}" alt="">--}}
                            {{--</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="panel panel-flat">--}}
            {{--@foreach($musics as $music)--}}
                {{--<div class="row v jwplayer" id="audioplayer">--}}
                    {{--<audio id="music" class="music" preload="true">--}}
                        {{--<source src="uploads/{{$music->file_name}}">--}}
                    {{--</audio>--}}
                    {{--<div class="m_avatar">--}}
                        {{--<div class="avatar_info">--}}
                            {{--<img src="assets/images/profile/icon_avatar_1.png" alt="" class="avatar-back avatar_0">--}}
                            {{--<img src="assets/images/profile/{{$music->avatar}}" alt="" class="avatar-back avatar_1">--}}
                            {{--<button id="pButton" class="play"   onclick="displayDetails({{json_encode($music)}}, this)"></button>--}}
                        {{--</div>--}}
                        {{--<div class="m_brief">{{$music->first_name}} {{$music->last_name}}</div>--}}
                        {{--<div class="m_name">{{$music->title}}</div>--}}
                    {{--</div>--}}
                    {{--<div class="progressbar">--}}
                        {{--<div id="timeline">--}}
                            {{--<div id="playhead" class="playhead"></div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="m_action">--}}
                        {{--<a class="item-action" onclick="onFavorite({{$music->file_id}})">--}}
                            {{--@if($music->favorite == 1)--}}
                                {{--<img src="assets/images/icons/icon_favourite2.png" />--}}
                            {{--@else--}}
                                {{--<img src="assets/images/icons/favourite_unselected.png" />--}}
                            {{--@endif--}}
                        {{--</a>--}}
                        {{--<a class="item-action" onclick="onDelete({{$music->file_id}})"><img src="assets/images/icons/icon_delete.png" /></a>--}}
                        {{--<a class="item-action" onclick="onFilter({{$music->file_id}})"><img src="assets/images/icons/icon_filter.png" /></a>--}}
                        {{--<div class="m_action_icon">--}}
                            {{--<div class="first filter">--}}
                                {{--<a href="#" style="display:block; width: 100%;height: 100%"><i class="fa fa-angle-right"></i></a>--}}
                            {{--</div>--}}
                            {{--<div class="second">--}}
                                {{--@if($music->display == null)--}}
                                    {{--<a href="uploads/{{$music->file_name}}" download><img src="assets/images/icons/icon_download.png"/></a>--}}
                                {{--@else--}}
                                    {{--<img src="assets/images/icons/icon_unavailable.png">--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--@endforeach--}}
            {{--</div>--}}
        {{--</div>--}}
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
                    {{--<img src="{{asset('assets/images/icons/img_info.png')}}" alt="" class="right_image">--}}
                    {{--<div class="right_qrcode row">--}}
                        {{--<img src="{{asset('assets/images/icons/qrcode.png')}}" alt="" style="float: left;">--}}
                        {{--<div class="label_artist"><span style="color: white;font-size: 0.8vw;font-family: 'dosis';">label Artist</span></div>--}}
                        {{--<div class="right_title"><strong>Los Suruba</strong></div>--}}
                    {{--</div>--}}
                    {{--<div class="right_social">--}}
                        {{--<a href="#"><strong><i class="fa fa-facebook"></i></strong></a>--}}
                        {{--<a href="#"><strong><i class="fa fa-twitter"></i></strong></a>--}}
                        {{--<a href="#"><strong><i class="fa fa-instagram"></i></strong></a>--}}
                        {{--<a href="#"><strong><i class="fa fa-cloud"></i></strong></a>--}}
                        {{--<a href="#"><strong><i class="fa fa-headphones"></i></strong></a>--}}
                    {{--</div>--}}
                {{--</header>--}}
                {{--<div class="panel-body right_body">--}}
                    {{--<span style="font-size: 0.8vw;color: #799a91;margin-bottom: 0.4vw;" id="music_ltime">45mins ago</span>--}}
                    {{--<p id="uname">Edu Imbernon & Los Suruba</p>--}}
                    {{--<div class="right_body_state">--}}
                        {{--<div class="state_title" id="music_title">FORMENTERA</div>--}}
                        {{--<div class="state_date" id="music_duration">8:25min<br>--}}
                        {{--<span class="last_time" id="music_ltime">45mins ago</span>--}}
                        {{--</div>--}}
                        {{--<div class="state_date" id="music_duration">8:25--}}
                            {{--<span style="font-size: 0.8vw;color: #799a91;margin-bottom: 0.4vw;"> &nbsp; minutes.</span>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="right_message">--}}
                        {{--<textarea type="textarea" rows="5" name="message" id="message" style="--}}
                        {{--width: 98%;--}}
                        {{--resize: none;--}}
                        {{--border-radius: 5px;--}}
                        {{--border-color: #e6e6e6;--}}
                        {{--"></textarea>--}}
                        {{--<div style="width: 98%;resize: none;border-radius: 5px;border-color: #e6e6e6;height:7vw;background-color: white;overflow-y: scroll;padding: 0.2vw;display: flex;flex-direction: column;justify-content: flex-end;">--}}
                            {{--                            @if(role == 0)--}}
                            {{--<div style="width: 100%;display: flex;flex-direction: row;margin-top: 0.3vw;margin-bottom: 0.3vw;align-items: flex-end;">--}}
                                {{--<img src="{{asset('assets/images/profile/default.png')}}" style="width: 2vw;height:2vw;border-radius: 50%;">--}}
                                {{--<div style="max-width: 79%;background-color: #23AE98;margin-left: 1%;margin-right: 1%;border-radius: 0.3vw;padding:0.1vw;padding-left: 0.3vw;padding-right: 0.3vw;color: white;font-family: 'dosis';font-size: 0.9vw;">--}}
                                    {{--<span>Hey check this! The track we were talking about earlier :)</span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div style="width: 100%;display: flex;flex-direction: row;margin-top: 0.3vw;margin-bottom: 0.3vw;justify-content: flex-end;align-items: flex-end">--}}

                                {{--<div style="max-width: 79%;background-color: #FCF9CE;margin-left: 1%;margin-right: 1%;border-radius: 0.3vw;padding:0.1vw;padding-left: 0.3vw;padding-right: 0.3vw;font-family: 'dosis';font-size: 0.9vw;">--}}
                                    {{--<span>Reply</span>--}}
                                {{--</div>--}}
                                {{--<img src="{{asset('assets/images/profile/default.png')}}" style="width: 2vw;height:2vw;border-radius: 50%;">--}}
                            {{--</div>--}}
                        {{--</div>--}}
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
@stop
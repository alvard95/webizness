@extends('layouts.master')

@section('content')
<div class="content">

    <div class="row" style="display: flex;">
        <div class="col-lg-7 col-md-7 main_content">
            <!-- Main charts -->
            <div class="page-header">
                <div class="page-header-content">
                    <div class="page-title" style="display: flex;flex-direction: column">
                        <div style="display: flex">
                            <h2 style="display: flex;flex-direction: row;align-items: center;">
                                @if(count($musics) > 0)
                                <div class="play {{$musics[0]->file_id}}" onclick="displayDetails({{json_encode($musics[0])}}, this)" style="width: 1.5vw;height: 1.7vw;mask: url('/assets/images/icons/icon_promos.png');-webkit-mask-box-image: url('/assets/images/icons/icon_promos.png');background-color: {{$group_name[0]->color}};cursor: pointer"></div>
                                @else
                                    <div style="width: 1.5vw;height: 1.7vw;mask: url('/assets/images/icons/icon_promos.png');-webkit-mask-box-image: url('/assets/images/icons/icon_promos.png');background-color: {{$group_name[0]->color}};cursor: pointer"></div>

                                    @endif
                                    <span class="text-semibold subtitle" id="text-semibold">{{ $group_name[0]->name }}.</span></h2>
                            <span id="group_edit" style="color: #FBA634;padding-bottom: 0.3vw;margin-left: 0.5vw;display: none;font-size: 20px;margin-left: 1vw;cursor: pointer;margin-top: 1vw;">edit.</span>
                        </div>
                        <span style="margin-left: 2.8vw;font-size: 0.8vw;font-family: fontMedium;color: #b5b5b5;margin-top: -0.4vw;">{{ $group_name[0]->group_note }}</span>
                    </div>

                    <div class="heading-elements">
                        <div class="heading-btn-group">
                            <a href="#" class="btn btn-link btn-float has-text btn-prev"><img src="{{asset('assets/images/icons/icon_prev.png')}}" alt=""></a>
                            <a href="#" class="btn btn-link btn-float has-text btn-next"><img src="{{asset('assets/images/icons/icon_next.png')}}" alt=""></a>
                            <a href="#" class="btn btn-link btn-float has-text btn-shuffle"><img src="{{asset('assets/images/icons/icon_reload.png')}}" alt="" style="width: 1.8vw"></a>
                        </div>
                    </div>

                </div>

            </div>
            <div class="panel panel-flat" style="overflow-x:hidden">
                @foreach($musics as $music)
                    <div class="row v jwplayer" id="audioplayer" data-id="{{$music->file_id}}" data-file="{{ $music->file_name }}">
                        <audio id="music" class="jwengine" preload="true">
                            <source src="../uploads/{{ $music->file_name }}">
                        </audio>
                        <div class="m_avatar">
                            <div class="avatar_info">
                                <img src="{{asset('assets/images/icons/icon_avatar_1.png')}}" alt="" class="avatar-back avatar_0">
                                <img src="{{asset('assets/images/profile/'.$music->avatar)}}" alt="" class="avatar-back avatar_1">
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
                        <div class="m_action uploads">
                            <div class="m_action" style="display: initial;width: 100%;">
                                <div class="m_action_icon">
                                    <div class="first"><a href="#"><i class="fa fa-bars"></i></a></div>
                                    <div class="second"><a href=""><i class="fa fa-long-arrow-right"></i></a></div>
                                </div>
                                {{--<div class="share_group">--}}
                                    {{--<div class="share_icon">--}}
                                        {{--<a class=""><img class="lazy" src="{{asset('assets/images/icons/icon_dot_purple.png')}}" alt=""></a>--}}
                                    {{--</div>--}}
                                    {{--<div class="share_title">--}}
                                        {{--<a class=""><span>share with.</span><i class="fa fa-share-alt"></i></a>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            </div>
                        </div>
                    </div>
                @endforeach
                 <div class="friends">
                    <div class="title">
                        <h1>shared with.</h1>
                    </div>
                    <div class="row" style="display: flex;justify-content: center">
                        {{--<div class="col-md-1"--}}
                        @foreach($group_user_list as $group_user)
                            <div style="margin-bottom: 1vw"><img class="lazy" src='{{asset("assets/images/profile/".$group_user->avatar) }}' alt="" style="width: 4vw;height: 4vw;background-color: grey;border-radius: 50%"></div>
                            {{--<img class="lazy" src='../../assets/images/icons/{{ $group_user->avatar }}' alt="" style="width: 5vw;height: 5vw;background-color: grey">--}}
                            <div style="width: 0.5vw"></div>
                        @endforeach
                    </div>
                    <div class="add">
                        <h1><a id="add_person_in_group" data-id="{{$group_name[0]->id}}" data-name="{{$group_name[0]->name}}">+</a></h1>
                    </div>
                </div>
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
                        {{--<div class="col-md-4" style="display: flex;justify-content: center;flex-direction: column;align-items: center;">--}}
                            {{--<img class="lazy" src="{{asset('assets/images/icons/qrcode.png')}}" alt="" style="width: 5vw;height: 5vw;">--}}
                            {{--<div class="label_artist"><span style="color: white;font-size: 0.8vw;font-family: 'dosis';">label Artist</span></div>--}}
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
                    {{--<span style="font-size: 0.8vw;color: #799a91;margin-bottom: 0.4vw;" id="music_ltime">45mins ago</span>--}}
                    {{--<p id="uname">Edu Imbernon & Los Suruba</p>--}}
                    {{--<div class="right_body_state">--}}
                        {{--<div class="state_title" id="music_title">FORMENTERA</div>--}}
                        {{--<div class="state_date" id="music_duration">8:25--}}
                        {{--</div>--}}
                        {{--<span style="font-size: 0.8vw;color: #799a91;margin-top: -0.4vw;position:absolute;right:2.2vw">minutes.</span>--}}
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
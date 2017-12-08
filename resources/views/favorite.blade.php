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
                            @if(count($favorites) > 0)
                                <img src="{{asset('assets/images/icons/icon_promos.png')}}" class="play {{$favorites[0]->file_id}}" onclick="displayDetails({{json_encode($favorites[0])}}, this)" style="cursor: pointer" alt="">
                            @else
                                <img src="{{asset('assets/images/icons/icon_promos.png')}}"  style="cursor: pointer" alt="">
                            @endif
                                <span class="text-semibold subtitle">favorites.</span></h2>
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
            <div class="panel panel-flat">
            @foreach($favorites as $favorite)
                <div class="row v jwplayer" id="audioplayer" data-id="{{$favorite->file_id}}" data-file="{{ $favorite->file_name }}">
                    {{--<audio id="music" class="music" preload="true">--}}
                        {{--<source src="uploads/{{$favorite->file_name}}">--}}
                    {{--</audio>--}}
                    <div class="m_avatar">
                        <div class="avatar_info">
                            <img src="{{asset("assets/images/profile/icon_avatar_1.png")}}" alt="" class="avatar-back avatar_0">
                            <img src="{{asset("assets/images/profile/".$favorite->avatar)}}" alt="" class="avatar-back avatar_1">
                            <button id="pButton" class="play"   onclick="displayDetails({{json_encode($favorite)}}, this)"></button>
                        </div>
                        <div class="m_brief">{{$favorite->first_name}} {{$favorite->last_name}}</div>
                        <div class="m_name">{{$favorite->title}}</div>
                    </div>
                    <div class="progressbar">
                        <div id="timeline">
                            <div id="playhead" class="playhead"></div>
                        </div>
                    </div>
                    <div class="m_action">
                        <a class="item-action" onclick="unFavorite({{$favorite->in_id}})"><img src="{{ asset("assets/images/icons/icon_favourite2.png")}}" /></a>
                        <a class="item-action" onclick="onDelete({{$favorite->in_id}})"><img src="{{ asset("assets/images/icons/icon_delete.png")}}" /></a>
                        <a class="item-action">
                            <img src="{{asset("assets/images/icons/icon_filter.png")}}" /></a>
                        <div class="m_action_icon">
                            <div class="first filter">
                                <a href="#" style="display:block; width: 100%;height: 100%"><i class="fa fa-angle-right"></i></a>
                                <div class="dropdown-menu dropdown-menu-right toggle">
                                    <h3>filtered. <i class="fa fa-glass" style="color: rgb(250, 175, 58);"></i></h3>
                                    <ul>
                                        <li>
                                            &nbsp;&nbsp;default filter
                                            <div class="filterbar">
                                                <div class="filterline">
                                                    <div class="filterhead"></div>
                                                </div>
                                            </div>
                                            <span style="margin-left: 120px;font-weight: 600;color:#48aa9d">6</span>
                                            <span style="margin-left: 10px;font-weight: 600;color:#777"> months</span>
                                            <span style="float:right; color: #65c5b9; font-weight: 800; font-size: 12px;">remove</span>
                                        </li>
                                        <li>
                                            <img src = "{{asset('assets/images/icons/avatar.png')}}" />
                                            &nbsp;&nbsp; Almost Human
                                            <span style="top: 3px; left: 190px; font-weight: 600;color:#48aa9d;position:absolute;">3</span>
                                            <span style="top: 3px; left: 230px; font-weight: 600;color:#48aa9d;position:absolute;">12</span>
                                            <span style="top: 3px; left: 270px; font-weight: 600;color:#48aa9d;position:absolute;">24</span>
                                            <div class="filterbar">
                                                <div class="filterline">
                                                    <div class="filterhead"></div>
                                                </div>
                                            </div>
                                            <span style="float:right; color: #fff; font-weight: 800; font-size: 12px;"><i class="fa fa-close"></i></span>
                                        </li>
                                        <li>
                                            <img src = "{{asset('assets/images/icons/avatar.png')}}" />
                                            &nbsp;&nbsp; Almost Human
                                            <span style="top: 3px; left: 190px; font-weight: 600;color:#48aa9d;position:absolute;">3</span>
                                            <span style="top: 3px; left: 230px; font-weight: 600;color:#48aa9d;position:absolute;">12</span>
                                            <span style="top: 3px; left: 270px; font-weight: 600;color:#48aa9d;position:absolute;">24</span>
                                            <div class="filterbar">
                                                <div class="filterline">
                                                    <div class="filterhead"></div>
                                                </div>
                                            </div>
                                            <span style="float:right; color: #fff; font-weight: 800; font-size: 12px;"><i class="fa fa-close"></i></span>
                                        </li>
                                        <li>
                                            <img src = "{{asset('assets/images/icons/avatar.png')}}" />
                                            &nbsp;&nbsp; Almost Human
                                            <span style="top: 3px; left: 190px; font-weight: 600;color:#48aa9d;position:absolute;">3</span>
                                            <span style="top: 3px; left: 230px; font-weight: 600;color:#48aa9d;position:absolute;">12</span>
                                            <span style="top: 3px; left: 270px; font-weight: 600;color:#48aa9d;position:absolute;">24</span>
                                            <div class="filterbar">
                                                <div class="filterline">
                                                    <div class="filterhead"></div>
                                                </div>
                                            </div>
                                            <span style="float:right; color: #fff; font-weight: 800; font-size: 12px;"><i class="fa fa-close"></i></span>
                                        </li>
                                        <li>
                                            <img src = "{{asset('assets/images/icons/avatar.png')}}" />
                                            &nbsp;&nbsp; Almost Human
                                            <span style="top: 3px; left: 190px; font-weight: 600;color:#48aa9d;position:absolute;">3</span>
                                            <span style="top: 3px; left: 230px; font-weight: 600;color:#48aa9d;position:absolute;">12</span>
                                            <span style="top: 3px; left: 270px; font-weight: 600;color:#48aa9d;position:absolute;">24</span>
                                            <div class="filterbar">
                                                <div class="filterline">
                                                    <div class="filterhead"></div>
                                                </div>
                                            </div>
                                            <span style="float:right; color: #fff; font-weight: 800; font-size: 12px;"><i class="fa fa-close"></i></span>
                                        </li>
                                        <li>
                                            <img src = "{{asset('assets/images/icons/avatar.png')}}" />
                                            &nbsp;&nbsp; Almost Human
                                            <span style="top: 3px; left: 190px; font-weight: 600;color:#48aa9d;position:absolute;">3</span>
                                            <span style="top: 3px; left: 230px; font-weight: 600;color:#48aa9d;position:absolute;">12</span>
                                            <span style="top: 3px; left: 270px; font-weight: 600;color:#48aa9d;position:absolute;">24</span>
                                            <div class="filterbar">
                                                <div class="filterline">
                                                    <div class="filterhead"></div>
                                                </div>
                                            </div>
                                            <span style="float:right; color: #fff; font-weight: 800; font-size: 12px;"><i class="fa fa-close"></i></span>
                                        </li>
                                        <li>
                                            <img src = "{{asset('assets/images/icons/avatar.png')}}" />
                                            &nbsp;&nbsp; Almost Human
                                            <span style="top: 3px; left: 190px; font-weight: 600;color:#48aa9d;position:absolute;">3</span>
                                            <span style="top: 3px; left: 230px; font-weight: 600;color:#48aa9d;position:absolute;">12</span>
                                            <span style="top: 3px; left: 270px; font-weight: 600;color:#48aa9d;position:absolute;">24</span>
                                            <div class="filterbar">
                                                <div class="filterline">
                                                    <div class="filterhead"></div>
                                                </div>
                                            </div>
                                            <span style="float:right; color: #fff; font-weight: 800; font-size: 12px;"><i class="fa fa-close"></i></span>
                                        </li>
                                        <li>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="second"><a href="{{asset('uploads/abc.mp3')}}" download><img src="{{asset("assets/images/icons/icon_download.png")}}"/></a></div>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
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
                        {{--<div class="chat-content." style="width: 98%;resize: none;border-radius: 5px;border-color: #e6e6e6;height:7vw;background-color: white;padding: 0.2vw;display: flex;flex-direction: column;justify-content: flex-end;">--}}
                            {{--                            @if(role == 0)--}}
                            {{--<ul style="padding:0px;overflow-y: scroll;" id="messages">--}}

                            {{--</ul>--}}

                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div style="background-color: white;width:98%;margin-top: 0.3vw;border-radius: 5px;">--}}
                        {{--<input type="hidden" name="_token" value="{{ csrf_token() }}" >--}}
                        {{--<input type="hidden" name="music_id" value="" >--}}
                        {{--<input type="hidden" name="user" value="{{ Auth::user() }}" >--}}
                        {{--<input type="hidden" name="uploader_id" value="" >--}}
                        {{--<div style="display: flex;width: 100%;justify-content: center;align-items: center">--}}
                            {{--<div style="background-color: #28ABB5;width: 12%;border-radius: 0.3vw;margin: 0.1vw;display: flex;justify-content: center;align-items: center;">--}}
                            {{--<img src="{{asset('assets/images/icons/file.png')}}" style="width: 12%;height:90%;margin: 0.1vw;"/>--}}
                            {{--</div>--}}
                            {{--<input class="form-control msg" placeholder="type a message" style="border:0px;width: 75%"/>--}}
                            {{--<img src="{{asset('assets/images/icons/note.png')}}" style="width: 13%;height:90%;margin: 0.1vw;"/>--}}
                            {{--<input type="button" value="Send" class="btn btn-success send-msg">--}}
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

            {{--<section class="panel right_widget">--}}
                {{--<header class="panel-heading right_panel">--}}
                    {{--<img src="{{asset('assets/images/icons/img_info.png')}}" alt="" class="right_image">--}}
                    {{--<div class="right_qrcode row">--}}
                        {{--<img src="{{asset('assets/images/icons/qrcode.png')}}" alt="" style="float: left;">--}}
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
                    {{--<p id="uname">Edu Imbernon & Los Suruba</p>--}}
                    {{--<div class="right_body_state">--}}
                        {{--<div class="state_title" id="music_title">FORMENTERA</div>--}}
                        {{--<div class="state_date" id="music_duration">8:25min<br>--}}
                        {{--<span class="last_time" id="music_ltime">45mins ago</span>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="right_message">--}}
                        {{--<div style="width: 98%;resize: none;border-radius: 5px;border-color: #e6e6e6;height:7vw;background-color: white;overflow-y: scroll;padding: 0.2vw">--}}
                            {{--                            @if(role == 0)--}}
                            {{--<div style="width: 100%;display: flex;flex-direction: row;margin-top: 0.3vw;margin-bottom: 0.3vw">--}}
                                {{--<img src="{{asset('assets/images/profile/default.png')}}" style="width: 2vw;height:2vw;border-radius: 50%;">--}}
                                {{--<div style="width: 88%;background-color: whitesmoke;margin-left: 1%;margin-right: 1%;border-radius: 0.3vw;padding:0.1vw;padding-left: 0.3vw;padding-right: 0.3vw">--}}
                                    {{--<span>Hello</span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div style="width: 100%;display: flex;flex-direction: row;margin-top: 0.3vw;margin-bottom: 0.3vw">--}}

                                {{--<div style="width: 88%;background-color: #FCF9CE;margin-left: 1%;margin-right: 1%;border-radius: 0.3vw;padding:0.1vw;padding-left: 0.3vw;padding-right: 0.3vw">--}}
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
        @component('shared.info_panel')
        @endcomponent
    </div>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
<script type="text/javascript">
    var socket = io.connect('http://192.168.0.71:8890');
    socket.on('message', function (data) {
        data = jQuery.parseJSON(data);
        var user = $("input[name='user']").val();
        var music_id = $("input[name='music_id']").val();
//        if(data.music != music_id)
//            return;
//        console.log(data);
//        $( "#messages" ).append( "<strong>"+data.user+":</strong><p>"+data.message+"</p>" );
        var str = '<li style="width: 100%;display: flex;flex-direction: row;margin-top: 0.3vw;margin-bottom: 0.3vw;align-items: flex-end;">';
        str += '<img src="assets/images/profile/'+data.user['avatar']+'" style="width: 2vw;height:2vw;border-radius: 50%;">';
        str += '<div style="max-width: 79%;background-color: #23AE98;margin-left: 1%;margin-right: 1%;border-radius: 0.3vw;padding:0.1vw;padding-left: 0.3vw;padding-right: 0.3vw;color: white;font-family: \'dosis\';font-size: 0.9vw;">';
        str += '<span>'+ data.message +'</span> </div></li>';

        var str1 = '<li style="width: 100%;display: flex;flex-direction: row;margin-top: 0.3vw;margin-bottom: 0.3vw;justify-content: flex-end;align-items: flex-end">';
        str1 += '<div style="max-width: 79%;background-color: #FCF9CE;margin-left: 1%;margin-right: 1%;border-radius: 0.3vw;padding:0.1vw;padding-left: 0.3vw;padding-right: 0.3vw;font-family: \'dosis\';font-size: 0.9vw;">';
        str1 += '<span>'+data.message+'</span>\n</div>';
        str1 += '<img src="assets/images/profile/'+data.user['avatar']+'" style="width: 2vw;height:2vw;border-radius: 50%;"></li>';
//        console.log( JSON.parse(user)['id']);
        if(data.user['id'] ==  JSON.parse(user)['id']){
            $( "#messages" ).append( str1 );
            $(".msg").val('');
        }
        else
            $( "#messages" ).append( str );
    });
    $(".form-control.msg").on('keyup',function(e){
        if(e.keyCode == 13){
            e.preventDefault();
            var token = $("input[name='_token']").val();
            var user = $("input[name='uploader_id']").val();
            var music = $("input[name='music_id']").val();
            var msg = $(".msg").val();
//            console.log(user);

            if(music != ''){
                if(msg != ''){
                    $.ajax({
                        type: "POST",
                        url: '{!! URL::to("sendmessage") !!}',
                        dataType: "json",
                        data: {'_token':token,'message':msg,'user':user,'music':music},
                        success:function(data){
//                            console.log(data);
                            $(".msg").val('');
                        }
                    });
                }else{
                    alert("Please Add Message.");
                }
            }else{
                alert('Please choose music.');
            }

        }

    })
</script>
@stop
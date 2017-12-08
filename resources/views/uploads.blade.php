@extends('layouts.master')

@section('content')

<div class="content">

    <div class="row" style="display: flex;">
        <div class="col-lg-7 col-md-7 main_content">
            <!-- Main charts -->
            <div class="page-header">
                <div class="page-header-content">
                    <div class="page-title">
                        <h2>
                            @if(count($musics) > 0)
                                <img src="{{asset('assets/images/icons/icon_uploads.png')}}" class="play {{$musics[0]->id}}" onclick="displayDetails({{json_encode($musics[0])}}, this)" style="cursor: pointer" alt="">
                            @else
                                <img src="{{asset('assets/images/icons/icon_uploads.png')}}" style="cursor: pointer" alt="">
                            @endif
                            <span class="text-semibold subtitle">uploads.</span></h2>
                    </div>
                    <div class="heading-elements">
                        <div class="heading-btn-group">
                            <a href="#" class="btn btn-link btn-float has-text btn-prev">
                                <img src="{{asset('assets/images/icons/icon_prev.png')}}" alt="">
                            </a>
                            <a href="#" class="btn btn-link btn-float has-text btn-next">
                                <img src="{{asset('assets/images/icons/icon_next.png')}}" alt="">
                            </a>
                            <a href="#" class="btn btn-link btn-float has-text btn-shuffle">
                                <img src="{{asset('assets/images/icons/icon_reload.png')}}" alt="" style="width: 1.8vw">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-flat">
            @foreach($musics as $upload)
                <div class="row v jwplayer" id="audioplayer" data-id="{{$upload->id}}" data-file="{{ $upload->file_name }}">
                    {{--<audio id="music_{{$upload->id}}" class="jwengine" preload="true">--}}
                        {{--<source src="uploads/{{$upload->file_name}}">--}}
                        {{--<source id="audio_src_{{$upload->id}}">--}}
                    {{--</audio>--}}
                    <div class="m_avatar">
                        <div class="avatar_info">
                            <img src="{{asset('assets/images/icons/icon_avatar_1.png')}}" alt="" class="avatar-back avatar_0">
                            <img src="{{asset('assets/images/profile/'.$upload->avatar)}}" alt="" class="avatar-back avatar_1">
                            <button id="pButton" class="play {{$upload->id}}" onclick="displayDetails({{json_encode($upload)}}, this)"></button>
                        </div>
                        <div class="m_brief">{{$user->first_name}} {{$user->last_name}}</div>
                        <div class="m_name">{{$upload->title}}</div>
                    </div>
                    <div class="progressbar">
                        <div id="timeline">
                            <div id="playhead" class="playhead"></div>
                        </div>
                    </div>
                    <div class="m_action uploads" style="display: initial;">
                       <div class="m_action_icon">
                            <div class="first dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="dropdownMenu1" aria-haspopup="true" aria-expanded="true"><i class="fa fa-bars"></i></a>
                                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
                                    <li><a href="#" onclick="onReplace({{$upload->id}})" data-toggle="modal" data-target="#myModal">replace file</a></li>
                                    <li><a href="#">edit info</a></li>
                                    <li><a onclick="onDelSource({{$upload->id}})">Delete</a></li>
                                </ul>
                            </div>
                            <div class="second">
                                <a href="#"><i class="fa fa-chevron-right"></i></a>
                                <ul class="dropdown-menu dropdown-menu-right toggle">
                                    <li>
                                        <h3>leave feedback to download</h3>
                                    </li>
                                    <li><input type="radio" name="group" value='b1'>"Amazing! I can wait to play this!"</li>
                                    <li><input type="radio" name="group" value='b2'/>"This is great!"</li>
                                    <li><input type="radio" name="group" value='b3'/>"Thanks. will try it out!"</li>
                                    <li><input type="radio" name="group" value='b4'/>"Saving this for special moments"</li>
                                    <li style="padding-top: 10px;">
                                        <div style="display:inline-block"><i class="fa fa-plus" style="color: #989898"></i> &nbsp;<span>share with.</span></div>
                                        <div style="display:inline-block; float:right; margin-right: 20px;"><span>invite</span>&nbsp;&nbsp;<i class="fa fa-long-arrow-right" style="color: #00AA00"></i></div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        {{--<div class="share_group">--}}
                            {{--<div class="share_icon">--}}
                                {{--<a class=""><img class="lazy" src="{{asset('assets/images/icons/icon_dot_purple.png')}}" alt=""></a>--}}
                                {{--<a class=""><img class="lazy" src="{{asset('assets/images/icons/icon_dot_yellow.png')}}" alt=""></a>--}}
                            {{--</div>--}}
                            {{--<div class="share_title">--}}
                                {{--<a class=""><span>share with.</span><i class="fa fa-share-alt"></i></a>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    </div>
                </div>
            @endforeach
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
<!-- Replace Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="/replace" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h1 class="modal-title">File replace.</h1>
                </div>
                <div class="modal-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file" style="width: 13vw">
                                        select file… <input type="file" id="imgInp" name="source_file">
                                    </span>
                                </span>
                                <input type="text" style="height: 50px;" name="file_name" class="form-control" readonly>
                            </div>
                            <input type="hidden" name="replace_id" id="replace_id">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="Submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
<script type="text/javascript">
    var socket = io.connect( window.location.origin +':8890');
//    alert(window.location.href.substr(0,window.location.href.length-1) +':8890');
    socket.on('message', function (data) {
        data = jQuery.parseJSON(data);
        var user = $("input[name='user']").val();
        var music_id = $("input[name='music_id']").val();
//        if(data.music != music_id)
//            return;
       console.log(data);
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
            console.log(music);

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
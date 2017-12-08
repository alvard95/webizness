@extends('layouts.master')
@section('content')
<div class="content">
    <div class="row" style="display: flex">
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
                                <span class="text-semibold subtitle">inbox.</span></h2>
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
                        <a class="item-action" onclick="onFavorite({{$music->in_id}})">
                            @if($music->favorite == 1)
                                <img class="lazy" src="{{ asset("assets/images/icons/icon_favourite2.png")}}" />
                            @else
                                <img class="lazy" src="{{ asset("assets/images/icons/favourite_unselect.png")}}" />
                            @endif
                        </a>
                        <a class="item-action" onclick="onDelete({{$music->file_id}})"><img class="lazy" src="assets/images/icons/icon_delete.png" style="width: 1vw" /></a>
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
        @component('shared.info_panel')
        @endcomponent
    </div>
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
<script type="text/javascript">
    var socket = io.connect( window.location.href.substr(0,window.location.href.length-1) +':8890');
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
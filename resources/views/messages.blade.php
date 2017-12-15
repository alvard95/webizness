@extends('layouts.master')

@section('content')

    
<style>

</style>

    <div class="row">
        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" >
        <div class="col-md-3" id = "message_threats">
            <div class="message_title">
                <span>
                    <i class="fa fa-envelope"></i>
                </span>
                <span>messages.</span>
            </div>
            <div class="search_wrapper">
                <input type="text" placeholder="Search..." class="form-control">
            </div>
            @if(isset($messages) && count($messages) > 0)
                @foreach($messages as $value)
                    <div id="{{$value->id}}" class="show_msg threat_item col-md-12">
                        <input type="hidden" class="id_from_user" value="{{$value->id}}" >
                        <div class="col-md-3 user_img">
                            <div class="user_img">
                                <img width="60" height="60" src="assets/images/profile/{{$value->avatar}}">
                            </div>
                        </div>
                        <div class="col-md-9 msg_content">
                            <div class="col-md-12">
                                <span class="user_name">{{ $value->first_name.' '. $value->last_name }}</span>
                            </div>
                            <div class="col-md-12">
                                
                                <span class="last_msg">{{ $value->message}}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="col-md-5" id = "message_box">
            <div class="friend_msg"></div>
        </div>
        <div class="col-md-4" id = "chat_details">
            <div class="recerver_user display_recerver_user">
                <div class="col-md-2 recerver_user_img">
                    
                </div>
                <div class="col-md-7 recerver_user_data">
                    <div >
                        
                        <div class="col-md-12">
                            <div class="recerver_user_name" style="float: right;">
                                
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="icons" style="float: right;">
                                <strong><i class="fa fa-facebook"></i></strong>
                                <strong><i class="fa fa-twitter"></i></strong>
                                <strong><i class="fa fa-instagram"></i></strong>
                                <strong><i class="fa fa-cloud"></i></strong>
                                <strong><i class="fa fa-headphones"></i></strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="recerver_icons">
                        <img class="lazy" src="assets/images/icons/qrcode.png" alt="" style="width: 55px;height: 55px;">
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
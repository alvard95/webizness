@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-3" id = "message_threats">
            <div class="message_title">
                <span>
                    <i class="fa fa-envelope"></i>
                </span>
                <h4>messages</h4>
            </div>
            <div class="search_wrapper">
                <input type="text" placeholder="Search..." class="form-control">
            </div>
            @if(isset($messages) && count($messages) > 0)
                @foreach($messages as $value)
                    <div class="threat_item">
                        <div class="user_img">
                            <img src="" alt="">
                        </div>
                        <div class="msg_content">
                            <h5 class="user_name">{{ $value->message_writers->first_name.' '. $value->message_writers->last_name }}</h5>
                            <p class="last_msg"></p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="col-md-6" id = "message_box">

        </div>
        <div class="col-md-3" id = "chat_details">

        </div>
    </div>

@endsection
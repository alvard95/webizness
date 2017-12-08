@extends('layouts.master')

@section('content')
    <script>
        var val = 0;
    </script>
    <div class="content">

        <div class="row">
            <div class="col-md-7 col-lg-7 main_content">
                <!-- Main charts -->
                <div class="page-header">
                    <div class="page-header-content">
                        <div class="page-title" style="display: flex;justify-content: space-between">
                            <h2><img src="{{asset('assets/images/icons/setting.png')}}" style="cursor: pointer;width: 1.7vw" alt="">
                                <span class="text-semibold subtitle">settings.</span>
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title" style="text-align: left;">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                                        account.</a>
                                </h4>
                            </div>
                            <div id="collapse1" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <div class="row" style="margin-left: 3vw;display: flex">
                                        <div class="setting_account_A">A</div>
                                        <div class="setting_account_left_A" style="display: flex;flex-direction: column">
                                            <span style="font-size: 0.5vw">ARTIST</span>
                                            <span style="font-size: 1vw;font-weight: bold;">{{ Auth::user()['first_name']." ".Auth::user()['lastname'] }}</span>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-left: 3vw;display: flex;margin-top: 0.2vw">
                                        <span style="color: #1F9B9B;font-size: 1.1vw">email.</span>
                                    </div>
                                    <div class="row setting_account_row" style="margin-left: 3vw;display: flex;">
                                        <div class="col-md-12" id="setting_second_email">
                                            <div class="row" >
                                                <div class="col-md-3" style="padding: 0px">
                                                    <span style="font-size: 0.8vw;">{{Auth::user()['email']}}</span>
                                                    {{--<span style="font-size: 0.8vw;">lossuruba@surubar.com</span>--}}
                                                </div>
                                                <div class="col-md-2" id="setting_second_email_label">
                                                    <span style="font-size: 0.8vw;font-weight: bold;">(primary)</span>
                                                    {{--<span style="font-size: 0.8vw;">(secondary)</span>--}}
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    @if(!is_null(Auth::user()['second_email'])&& Auth::user()['second_email'] !="" )
                                        <div class="row" style="display:flex;align-items:center;margin-left: 3vw;">
                                            <div class="col-md-3" style="padding: 0px">
                                                <span style="font-size: 0.8vw;">{{Auth::user()['second_email']}}</span>
                                            </div>
                                            <div class="col-md-2">
                                                <span style="font-size: 0.8vw;">(secondary)</span>
                                            </div>
                                        </div>
                                        <script>
                                            val = 1;
                                        </script>
                                    @endif

                                    <div class="row setting_account_row" style="margin-left: 3vw;display: flex; cursor: pointer" id="setting_add_email">
                                        <div style="padding: 0px;display: flex;align-items: center">
                                            <span style="font-size: 1.3vw;color: #1F9B9B">+</span>
                                            <span style="font-size: 0.8vw;margin-left: 0.2vw;font-weight: bold;">add an email address</span>
                                        </div>
                                    </div>
                                    <div class="row setting_account_row" style="margin-left: 3vw;display: flex;">
                                        <span style="color: #1F9B9B;font-size: 1vw;margin-top: 1vw;margin-bottom: 1vw">subscription.</span>
                                    </div>
                                    <div class="row setting_account_row" style="margin-left: 3vw;display: flex;margin-top: 0.5vw">
                                        <div class="col-md-2" style="padding: 0px">
                                            <div style="border:solid 1px #1F9B9B;border-radius: 0.3vw;width: 5.5vw;height:4.3vw;padding:0.2vw">
                                                <div style="background-color: #CCCCCC;height: 100%;width: 100%;border-radius: 0.3vw;display: flex;flex-direction: column;align-items: center;justify-content: space-between">
                                                    <span style="font-size: 0.5vw;color: #666666">ARTIST</span>
                                                    <span style="color: white;font-size: 1.5vw">ALF</span>
                                                    <span style="font-size: 0.5vw;color: #666666">LIMITED FREE</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-10 subscription" style="display: flex;flex-direction: column">
                                            <span style="font-size: 1vw;">upgrade to artist premium</span>
                                            <span style="font-size: 1vw">add extra storage</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title" style="text-align: left;">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                                        notifications</a>
                                </h4>
                            </div>
                            <div id="collapse2" class="panel-collapse collapse">
                                <div class="panel-body"></div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title" style="text-align: left;">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                                        payment method</a>
                                </h4>
                            </div>
                            <div id="collapse3" class="panel-collapse collapse">
                                <div class="panel-body"></div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title" style="text-align: left;">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
                                        password</a>
                                </h4>
                            </div>
                            <div id="collapse4" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div id="check_password_alert">


                                    </div>

                                    <div class="row" style="margin-left: 0vw">
                                        <div class="col-md-4">
                                            <div class="row" style="margin-top: 0.5vw">
                                                <input type="password" placeholder="Please input old password" class="form-control" id="oldPassword"/>
                                            </div>
                                            <div class="row" style="margin-top: 0.5vw">
                                                <input type="password" placeholder="Please input new password" class="form-control" id="newPassword"/>
                                            </div>
                                            <div class="row" style="margin-top: 0.5vw">
                                                <input type="password" placeholder="Please input confirm password" class="form-control" id="confirmPassword"/>
                                            </div>
                                            <div class="row" style="margin-top: 0.5vw">
                                                <button type="button" class="btn btn-primary" id="password_change_btn">Change</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title" style="text-align: left;">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse5" style="color: #15A7C8;font-size: 1.3vw">
                                        invite</a>
                                </h4>
                            </div>
                            <div id="collapse5" class="panel-collapse collapse">
                                <div class="panel-body"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-5 col-md-5">
                <!-- Main charts -->
                <div class="page-header" style="height: 25vw;display: flex;flex-direction: column;justify-content: center">
                    <div class="page-header-content right" style="margin-top: -5vw">
                        <div style="margin-left: 9%;margin-right: 10%;">
                            <div>
                                <span style="font-size: 5vw;color:#808080">88</span>
                                <span style="color: #52CEC2;font-size: 4vw">%</span>
                                <span style="color: #CCCCCC;font-size: 1.2vw;margin-left: 5%;margin-right: 2%">used</span>
                                <span style="font-size: 1.2vw;color: #666666">disk space</span>
                            </div>
                            <div style="width: 100%;height: 0.3vw;display: flex;justify-content: center;">
                                <div style="background-color: #CCCCCC;width: 83%;height: 0.4vw;margin-top: -1.7vw">
                                    <div style="background-color: #52CEC2;width: 88%;height:0.4vw"></div>
                                </div>
                            </div>
                            <div style="text-align: right;margin-top: -1.3vw">
                                <span style="margin-right: 2vw;font-size: 1vw;color:#666666">500MB</span>
                            </div>

                        </div>
                        <span class=""></span>
                    </div>
                </div>

                <section class="panel right_widget" >
                    <header class="panel-heading right_panel"  style="background-image: url(/assets/images/profile/{{Auth::user()["avatar"]}});">
                        <div class="right_qrcode row">
                            <div class="col-md-4" style="display: flex;justify-content: center;flex-direction: column;align-items: center;">
                                <img class="lazy" src="{{asset('assets/images/icons/qrcode.png')}}" alt="" style="width: 5vw;height: 5vw;">
                                <div class="label_artist"><span style="color: white;font-size: 0.8vw;font-family: 'dosis';">label Artist</span></div>
                            </div>
                            <div class="col-md-8" style="display: flex;align-items: center">
                                <div class="right_title"><strong>{{ Auth::user()['first_name']." ".Auth::user()['lastname'] }}</strong></div>
                            </div>

                        </div>
                        <div class="right_social row">
                            <a href="#"><strong><i class="fa fa-facebook"></i></strong></a>
                            <a href="#"><strong><i class="fa fa-twitter"></i></strong></a>
                            <a href="#"><strong><i class="fa fa-instagram"></i></strong></a>
                            <a href="#"><strong><i class="fa fa-cloud"></i></strong></a>
                            <a href="#"><strong><i class="fa fa-headphones"></i></strong></a>
                        </div>
                    </header>
                     <div class="panel-body right_body row">
            <span style="font-size: 0.8vw;color: #799a91;margin-bottom: 0.4vw;" id="music_ltime"></span>
            <p id="uname">Edu Imbernon & Los uruba</p>
            <div class="right_body_state">
                <div class="state_title" id="music_title">FORMENTERA</div>
                <div class="state_date" id="music_duration">8:25

                </div>
                <span style="font-size: 0.8vw;color: #799a91;margin-top: -0.4vw;position:absolute;right:2.2vw">minutes.</span>
            </div>
            <div class="right_message">
                {{--<textarea type="textarea" rows="5" name="message" id="message" style="--}}
                            {{--width: 98%;--}}
                            {{--resize: none;--}}
                            {{--border-radius: 5px;--}}
                            {{--border-color: #e6e6e6;--}}
                              {{--"></textarea>--}}
                <div class="chat-content." style="width: 98%;resize: none;border-radius: 5px;border-color: #e6e6e6;height:7vw;background-color: white;padding: 0.2vw;display: flex;flex-direction: column;justify-content: flex-end;">
                    {{--                            @if(role == 0)--}}
                    <ul style="padding:0px;overflow-y: scroll;" id="messages">

                    </ul>

                </div>
            </div>
            <div style="background-color: white;width:98%;margin-top: 0.3vw;border-radius: 5px;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                <input type="hidden" name="music_id" value="" >
                <input type="hidden" name="user" value="{{ Auth::user() }}" >
                <input type="hidden" name="uploader_id" value="" >
                <div style="display: flex;width: 100%;justify-content: center;align-items: center">
                    {{--<div style="background-color: #28ABB5;width: 12%;border-radius: 0.3vw;margin: 0.1vw;display: flex;justify-content: center;align-items: center;">--}}
                        <img src="{{asset('assets/images/icons/file.png')}}" style="width: 12%;height:90%;margin: 0.1vw;"/>
                        {{--</div>--}}
                    <input class="form-control msg" placeholder="type a message" style="border:0px;width: 75%"/>
                    <img src="{{asset('assets/images/icons/note.png')}}" style="width: 13%;height:90%;margin: 0.1vw;"/>
                    {{--<input type="button" value="Send" class="btn btn-success send-msg">--}}
                </div>

            </div>
            <ul class="tag_group">
                {{--<li><button type="button" class="btn"><strong>mastered</strong></button></li>--}}
                {{--<li><button type="button" class="btn"><strong>unreleased</strong></button></li>--}}
                {{--<li><button type="button" class="btn"><strong>wav</strong></button></li>--}}
                {{--<li><button type="button" class="btn"><strong>24bit</strong></button></li>--}}
                {{--<li><button type="button" class="btn"><strong>44.1k</strong></button></li>--}}
                {{--<li><button type="button" class="btn"><strong>-6db of headroom</strong></button></li>--}}
            </ul>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        $('#setting_add_email').click(function(){
            if(val == 0){
                $('#setting_second_email').append('<div class="row" style="display:flex;align-items:center">\n' +
                    '                                                <div class="col-md-3" style="padding: 0px"><form method="post" action="/add_second_email" id="add_second_email_form">\n' +
                    '                                                    <input type="email" name="email" class="form-control" placeholder="Please input email" onkeypress="return runScript(event)" required>\n' +
                    '                                                    {{--<span style="font-size: 0.8vw;">lossuruba@surubar.com</span>--}}\n' +
                    '                                                </form></div>\n' +
                    '                                                <div class="col-md-2">\n' +
                    '                                                    \n' +
                    '                                                    <span style="font-size: 0.8vw;">(secondary)</span>\n' +
                    '                                                </div>\n' +
                    '                                            </div>');
                val++;
            }

            else{
                return;
            }

        });

        function runScript(event){
            if(event.keyCode == 13){
                $('#add_second_email_form').submit();
            }
        }
    </script>

@endsection
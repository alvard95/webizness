<div class="col-lg-5 col-md-5">
    <!-- Main charts -->
    <div class="page-header">
        <div class="page-header-content right">
            <span class="huge-number">4</span>
            <span class=""></span>
        </div>
    </div>

    <section class="panel right_widget">
        <header class="panel-heading right_panel" style="background-image: url('../assets/images/profile/{{Auth::user()['avatar']}}');">
            {{--<img class="lazy" src="" alt="" class="right_image">--}}
            <div class="right_qrcode row">
                <div class="col-md-4" style="display: flex;flex-direction: column;justify-content: center;align-items: center;">
                    <img class="lazy" src="{{asset('assets/images/icons/qrcode.png')}}" alt="" style="width: 5vw;height: 5vw;">
                    <div class="label_artist"><span style="color: white;font-size: 0.8vw;font-family: 'dosis';">label Artist</span></div>
                </div>
                <div class="col-md-8" style="display: flex;align-items: center">
                    <div class="right_title" style="font-size: 2.5vw;white-space: nowrap;overflow: hidden;font-weight: bold;width: 95%" id="track_user">{{ Auth::user()['first_name']." ".Auth::user()['lastname'] }}</div>
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
                <div class="state_date" id="music_duration">8:25</div>
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
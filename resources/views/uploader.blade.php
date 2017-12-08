@extends('layouts.master')

@section('content')

<div class="content">

    <div class="row">
        <div class="col-lg-8 main_content">
            <!-- Main charts -->
            <div class="page-header">
                <div class="page-header-content">
                    <div class="page-title">
                        <h2><img src="{{asset('assets/images/icons/icon_upload.png')}}" alt=""> <span class="text-semibold subtitle">upload.</span></h2>
                    </div>
                </div>
            </div>
            <div class="panel panel-flat uploader">
                <form method="POST" action="/upload" enctype="multipart/form-data">
                 {{ csrf_field() }}
                    <!-- <div class="file_sel"> -->
                        <div class="form-group">
                        <!-- <label>Select File</label> -->
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file">
                                        select file… <input type="file" id="imgInp" name="file_source" required>
                                    </span>
                                </span>
                                <input type="text" style="height: 50px;" name="file_name" class="form-control" required>
                            </div>
                        </div>
                    <div class="panel panel-body up_body">
                        <h5>select.</h5>
                    </div>
                    <ul class="tag_group selects group_1">
                        <input type="hidden" name="release" id="release" value="0">
                        <li><button type="button" class="btn" onclick="signed(0)"><strong>unreleased</strong></button></li>
                        <li><button type="button" class="btn" onclick="signed(1)"><strong>signed</strong></button></li>
                        <li class="signed" id="signed" style="display: none !important;">
                            <span><input type="text" name="label" placeholder="label."></span>
                            <span><input type="date" name="date" placeholder="date."></span>
                        </li>
                    </ul>
                    <ul class="tag_group selects group_2">
                        <input type="hidden" name="file_type" id="file_type" value="mp3">
                        <li><button type="button" class="btn" onclick="fileType('wav')"><strong>wav</strong></button></li>
                        <li><button type="button" class="btn" onclick="fileType('aiff')"><strong>aiff</strong></button></li>
                        <li><button type="button" class="btn" onclick="fileType('mp3')"><strong>mp3</strong></button></li>
                        <li><button type="button" class="btn" onclick="fileType('acc')"><strong>acc</strong></button></li>
                        <li><button type="button" class="btn" onclick="fileType('flac')"><strong>flac</strong></button></li>
                    </ul>
                    <ul class="tag_group selects group_3">
                        <input type="hidden" name="master" id="master" value="mastered">
                        <li><button type="button" class="btn" onclick="onMaster('mastered')"><strong>mastered</strong></button></li>
                        <li><button type="button" class="btn" onclick="onMaster('premaster')"><strong>premaster</strong></button></li>
                        <li><button type="button" class="btn" onclick="onMaster('studio master')"><strong>studio master</strong></button></li>
                        <li><button type="button" class="btn" onclick="onMaster('not mastered')"><strong>not mastered</strong></button></li>
                    </ul>
                    <ul class="tag_group selects group_4">
                        <input type="hidden" name="bit" id="bit" value="24bit">
                        <li><button type="button" class="btn" onclick="onBit('24bit')"><strong>24bit</strong></button></li>
                        <li><button type="button" class="btn" onclick="onBit('16bit')"><strong>16bit</strong></button></li>
                        <li><button type="button" class="btn" onclick="onBit('32bit')"><strong>32bit</strong></button></li>
                    </ul>
                    <ul class="tag_group selects group_5">
                        <input type="hidden" name="size" id="size" value="44.1k">
                        <li><button type="button" class="btn" onclick="onSize('44.1k')"><strong>44.1k</strong></button></li>
                        <li><button type="button" class="btn" onclick="onSize('48k')"><strong>48k</strong></button></li>
                        <li><button type="button" class="btn" onclick="onSize('88.2k')"><strong>88.2k</strong></button></li>
                        <li><button type="button" class="btn" onclick="onSize('96k')"><strong>96k</strong></button></li>
                    </ul>
                    <select class="upload_select first" id="headroom" name="headroom" style="display: none">
                        <option>headroom</option>
                        <option>-01db</option>
                        <option>-02db</option>
                        <option>-03db</option>
                        <option>-04db</option>
                        <option>-05db</option>
                        <option>-06db</option>
                        <option>-07db</option>
                        <option>-08db</option>
                        <option>-09db</option>
                        <option>-10db</option>
                        <option>-11db</option>
                        <option>-12db</option>
                    </select>
                    <div>
                        <select class="upload_select second" name="genre">
                            <option>genre</option>
                            <option>Ambient</option>
                            <option>Breakbeat</option>
                            <option>Disco</option>
                            <option>Drum and Bass</option>
                            <option>Dub</option>
                            <option>Dance</option>
                            <option>Electro</option>
                            <option>Electronica</option>
                            <option>Hardcore</option>
                            <option>Hop</option>
                            <option>Industrial</option>
                            <option>Pop</option>
                            <option>Techno styles</option>
                            <option>Trance</option>
                        </select>
                        <span class="upload_select title">*not displayed.</span>
                    </div>
                    <div class="visible">
                        <div class="roundedOne">
                            <input type="checkbox" name="visible" id="roundedOne" />
                            <label for="roundedOne"></label>
                        </div>
                        <span>HD box</span>
                    </div>
                    <div class="upload_select note">
                        <div>note.</div>
                        <input type="textarea" name="note" class="upload_note"/>
                    </div>
                    <div class="group_send">
                        <div class="form-group">
                            <ul class="list-inline tame-toggle">
                                <li>send to groups now?</li>
                                <input type="hidden" name="group" id="group">
                                @foreach($group_info as $group)
                                    <li onclick="onGroup({{ $group->id }})">
                                        <div class="group_toggle">

                                            <a class="group_pop" rel="popover" data-original-title={{$group->name}} style="width:22px;height:22px;display:block;">
                                                <div style="width: 22px; height: 22px; background-color: {{ $group->color }}; border-radius: 50%;" ></div>
                                            </a>
                                        </div>
                                    </li>
                                @endforeach
                                {{--<li onclick="onGroup(2)">--}}
                                    {{--<div class="group_toggle">--}}
                                        {{--<div style="width: 22px; height: 22px; background-color: yellow; border-radius: 50%;"></div>--}}
                                    {{--</div>--}}
                                {{--</li>--}}
                            </ul>
                        </div>
                        <div class="form-group">
                            <label>send to contacts now?</label>
                            <input type="hidden" name="contacts_send" id="contacts_send" value="">
                            <div style="display: flex">
                                <div class="contacts_send">
                                    <?php $contact_val = []; $num=0;?>
                                    @foreach($contacts as $contact)
                                    @if($loop->iteration > 5) @break @endif
                                        @if($num < 5 && $contact->id != Auth::user()->id)
                                        <span class="contact_user" id="{{$contact->id}}" onclick="onContact({{$contact->id}}, 0)">
                                            <a class="contact_pop" rel="popover" data-original-title="{{$contact->first_name}}" style="width:50px;height:50px;display:block;">
                                            <img src="{{asset('assets/images/profile/'.$contact->avatar)}}" />
                                            </a>
                                        </span>
                                        <?php array_push($contact_val,$contact->id); $num++; ?>
                                        @endif
                                    @endforeach

                                </div>
                                <div class="plus filter" style="display: inline-block;">
                                    <!-- <a href="#">+</a> -->
                                    <a id="upload_contact_plus" style="display:block; width: 100%;height: 100%;font-size: 2vw;margin-left: 0.5vw;margin-top: -6px;color: #b3b3b3;">+</a>
                                    <div class="dropdown-menu dropdown-menu-right toggle" style="position: fixed;">
                                        <h3>Contacts.</h3>
                                        <ul>
                                            <!-- <li>
                                                <div class="searchbar">
                                                    <div class="filterline">
                                                        <div class="filterhead"></div>
                                                    </div>
                                                </div>
                                                <span style="margin-left: 120px;font-weight: 600;color:#48aa9d">6</span>
                                                <span style="margin-left: 10px;font-weight: 600;color:#777"> months</span>
                                                <span style="float:right; color: #65c5b9; font-weight: 800; font-size: 12px;">remove</span>
                                            </li> -->
                                            @foreach($contacts as $contact)
                                                <li onclick="onContact({{$contact->id}}, 1)" class="contact_drop">
                                                    <img src = "{{asset("assets/images/profile/".$contact->avatar)}}" />
                                                    &nbsp;&nbsp; {{$contact->first_name}} {{$contact->last_name}}
                                                </li>
                                            @endforeach
                                        </ul>
                                        <input type="hidden" value={{ json_encode($contact_val) }} id="contact" name="contact">
                                    </div>
                                </div>
                            </div>


                            <span class="submit_form"><button type="submit" class="btn btn-warning pull-right">submit</button></span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
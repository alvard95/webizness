<!DOCTYPE html>
<html>
<head>

    
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.3">
    <title>Music</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=0.3">

    <link href="{{asset('css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
    <!-- <link href="{{asset('css/app.css')}}" rel="stylesheet"> -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">

    <!-- Global stylesheets -->
	<link href="{{asset('css/bootstrap.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('css/core.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('css/components.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('css/colors.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('font-awesome/css/font-awesome.css')}}" rel="stylesheet" />
    {{--<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">--}}
    <!-- /global stylesheets -->

    <script type="text/javascript" src="{{asset('js/core/libraries/jquery.min.js')}}"></script>

</head>
    <body class="@if(!Auth::check()) login-container @endif  pace-done image-background">
    <div id="preloader">
        <div id="loading-animation">&nbsp;</div>
    </div>
        @if(Auth::check())
            @include('shared.header')
            @if(isset($contacts))
                <div id="contact_dialog" style="position: absolute;display:none;top: 0px;left: 0px;width: 100%;height: 100vh;z-index: 99999999;justify-content: center;align-items: center;">
                    <div class="contact_dialog">
                        <div style="position: absolute;padding: 0px;margin-top: -7%;font-size: 23px;">
                            Contacts.
                        </div>
                        <div id="contact_close" style="position: absolute;padding: 0px;margin-top: -7%;margin-left: 38%;font-size: 23px;">
                            <img class="lazy" src="{{ asset('/assets/images/60994.png') }}" alt = "close" style="width:20px;height:20px;cursor: pointer"/>
                        </div>
                        <div class="contact_dialog_layout_out">
                            <div class="contact_content_layout">
                                <div class="row" style="height: 60px;border-bottom-color: white;border-bottom-width: 1px;border-bottom-style: solid;">
                                    <div class="col-md-4 col-md-offset-2" style="display: flex;align-items: center;justify-content: center;height: 100%;">
                                        <input placeholder="search" class="form-control"/>
                                    </div>
                                    <div class="col-md-4 col-md-offset-2" style="display: flex;align-items: flex-end;justify-content: flex-start;height: 100%;padding-bottom: 10px;font-size: 1vw;">
                                        in groups
                                    </div>
                                </div>
                                <div class="row" style="overflow-y: scroll;overflow-x: hidden;display: flex;flex-direction: column;width: 99%;margin-left: 1%;height: 22vw;">
                                    @foreach($users as $user)
                                        <?php $flag = true ?>
                                        @if(Auth::user()->id != $user->id)
                                        @foreach($contacts as $contact)

                                            @if($user->id == $contact->id)
                                                <div class="contact_row row" data-id={{ $user->id }} data-name='{{ $user->first_name }}' data-img={{ $user->avatar }} data-sel="1" style="background-color:#CCB9A3">
                                                <?php $flag = false ?>
                                            @endif
                                        @endforeach
                                            @if($flag == true)
                                                <div class="contact_row row" data-id={{ $user->id }} data-name='{{ $user->first_name }}' data-img={{ $user->avatar }} data-sel="0">
                                            @endif
                                            <div class="col-md-2" style="display: flex;align-items: center;justify-content: center;height: 100%">
                                                <div style="width: 70px; height: 70px; background-color: white; border-radius: 50%;display: flex;align-items: center;justify-content: center;">
                                                    <div style="width: 50px; height: 50px; background-color: red; border-radius: 50%;display: flex;align-items: center;justify-content: center;">
                                                        <img class="lazy" src="assets/images/icons/avatar.png" style="width:100%;height: 100%;" alt="img"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6" style="display: flex;align-items: center;font-size: large;height: 100%">
                                                {{$user->first_name}} {{$user->last_name}}
                                            </div>
                                            <div class="col-md-4" style="display: flex;align-items: center;height: 100%">
                                                @if(isset($user->group_info) && count($user->group_info)>0)
                                                    @foreach($user->group_info as $colors)
                                                        @if(Auth::user()->id == $colors->creater)
                                                            <div style="width: 22px; height: 22px; background-color: {{ $colors->color }}; border-radius: 50%;"></div>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>


                            </div>
                        </div>
                        <div style="position: absolute;padding: 0px;font-size: 17px;color: darkgreen;margin-top: 86%;display: flex">
                            <span id="selected">0</span>/{{ count($users)-1 }} selected
                        </div>
                    </div>
                </div>
                </div>


            @endif
            <form method="POST" action="/add_group">
                {{ csrf_field() }}
                <input type="hidden" id="group_id_in_add_group" name="group_id_in_add_group" value=""/>
                @if( isset($uploader_dialog) )
                    <input type="hidden" name="uploader" id="uploader_dialog" value="0" />
                    @else
                    <input type="hidden" name="uploader" id="uploader_dialog" value="1" />
                @endif
                <div id="group_dialog" style="position: absolute;display:none;top: 0px;left: 0px;width: 100%;height: 100%;z-index: 99999999;justify-content: center;align-items: center;font-family: fontBold;background-color: rgba(0,0,0,0.5);">

                    <div class="group_dialog">
                        <div style="position: absolute;padding: 0px;margin-top: -7%;font-size: 23px;">
                            <input type="text" name="group_name" id="group_name_in_add_group" placeholder="add group name" style="border:0px;font-size: 1vw;font-family: fontBold;" class="form-control" required/>
                        </div>
                        <div id="group_close" style="position: absolute;padding: 0px;margin-top: -7%;margin-left: 38%;font-size: 23px;">
                            <img class="lazy" src="{{ asset('/assets/images/60994.png') }}" alt = "close" style="width:20px;height:20px;cursor: pointer"/>
                        </div>
                        <div class="contact_dialog_layout_out">
                            <div class="contact_content_layout">
                                <div class="row" style="height: 60px;border-bottom-color: white;border-bottom-width: 1px;border-bottom-style: solid;">
                                    <div class="col-md-4 col-md-offset-2" style="display: flex;align-items: center;justify-content: center;height: 100%;">
                                        <input placeholder="search" class="form-control" style="padding-left: 30px"/>
                                        <img src="{{asset('/assets/images/search.png')}}" style="width: 20px;height: 20px;position: absolute;left: 15px;" />
                                    </div>
                                    <div class="col-md-4 col-md-offset-2" style="display: flex;align-items: flex-end;justify-content: flex-start;height: 100%;padding-bottom: 10px;font-size: 1vw;">
                                        in groups
                                    </div>
                                </div>
                                <div class="row" style="overflow-y: scroll;overflow-x: hidden;display: flex;flex-direction: column;width: 99%;margin-left: 1%;height: 22vw;">
                                @foreach($user_list as $user)
                                    @if(Auth::user()->id != $user->id)
                                    <div class="group_row row" data-id={{ $user->id }} data-name={{ $user->first_name." ".$user->last_name }} data-img={{ $user->avatar }} data-sel="0">
                                        <div class="col-md-2" style="display: flex;align-items: center;justify-content: center;height: 100%">
                                            <div style="width: 3.8vw;height: 3.8vw; background-color: white; border-radius: 50%;display: flex;align-items: center;justify-content: center;">
                                                <div style="width: 2.7vw; height: 2.7vw; background-color: #E6E6E6; border-radius: 50%;display: flex;align-items: center;justify-content: center;">
                                                    <img class="lazy" src={{ asset('assets/images/profile/'.$user->avatar) }} style="width:100%;height:100%;border-radius:50%;" alt=""/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="display: flex;align-items: center;font-size: large;height: 100%">
                                            {{$user->first_name}} {{$user->last_name}}
                                        </div>
                                        <div class="col-md-4" style="display: flex;align-items: center;height: 100%">
                                            @foreach($user->group as $group)
                                                @if(Auth::user()->id == $group->creater)
                                                    <div style="width: 22px; height: 22px; background-color: {{ $group->color }}; border-radius: 50%;"></div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                                </div>
                            </div>
                            <div style="width: 29vw;height: 3vw;bottom:2vw;background-color: #E6E6E6;border-bottom-left-radius: 3vw;border-bottom-right-radius: 3vw;position:absolute;display: flex;justify-content: center;align-items: center;">
                                <button type="submit" class="btn" style="background-color: #FBB03B;border-color: #A87205;border-width: 1px;color:white;font-size: 17px;padding-top: 2px;padding-bottom: 2px;" > save. </button>
                            </div>
                        </div>
                        <div style="position: absolute;padding: 0px;font-size: 17px;color: darkgreen;margin-top: 86%;display: flex">
                            <span id="group_dialog_selected">0</span>/{{ count($user_list)-1 }} selected
                        </div>
                        <input type="hidden" value="" id="group_info" name="group_info">
                    </div>
                </div>
            </form>
            {{--Group Edit--}}
            @if(isset($group_name))
                <form method="post" action="/edit_group" style="font-family: fontMedium;">
                    {{ csrf_field() }}
                    <input type="hidden" value={{$group_name[0]->id}} name="group_id" />
                    <div id="group_edit_dialog" style="position: absolute;display:none;top: 0px;left: 0px;width: 100%;height: 100%;z-index: 99999999;justify-content: center;align-items: center;background-color: rgba(0,0,0,0.5);">
                        <div class="group_edit_dialog">
                            <div class="row"  style="height: 25%">
                                <div class="col-md-4" style="display: flex;justify-content: center;align-items: center;height: 100%"><span style="color: #808080;font-size: 1.2vw;">group name.</span></div>
                                <div class="col-md-7" style="height: 100%;display: flex;justify-content: flex-start;align-items: center;">
                                    <input type="text" name="group_name" class="form-control" style="width: 100%;border-width: 0px;font-size: 1.8vw;padding:0px;color:#808080;font-family: fontBold" placeholder="Input Group Name" value={{$group_name[0]->name}} required>
                                </div>
                                <div class="col-md-1" style="display: flex;justify-content: center;align-items: center;height: 100%">
                                    <img class="lazy" id="group_edit_close" src="{{ asset('assets/images/close.png') }}" style="width: 1.3vw;height: 1.3vw;margin-right: 1vw;cursor: pointer;">
                                </div>
                            </div>
                            <div class="row" style="height: 25%">
                                <div class="col-md-4" style="display: flex;justify-content: center;align-items: center;height: 100%"><span style="color: #808080;font-size: 1.2vw;">add subtitle.</span></div>
                                <div class="col-md-8" style="height: 100%;display: flex;justify-content: flex-start;align-items: center;">
                                    <input type="text" name="group_note" id="group_note" class="form-control" value="{{$group_name[0]->group_note}}" style="width:100%;border-width:0px;font-size:1.2vw;padding:0px;color:#808080" placeholder="group sub title field goes here." value="">
                                </div>
                            </div>
                            <div class="row" style="height: 25%">
                                <div class="col-md-4" style="display: flex;justify-content: center;align-items: center;height: 100%"><span style="color: #808080;font-size: 1.2vw;">delete group?.</span></div>
                                <div class="col-md-8" style="height: 100%;display: flex;justify-content: flex-start;align-items: center;">
                                    {{--<input type="text" name="group_note" class="form-control" style="width: 100%;border-width: 0px;font-size: 1.5vw;padding:0px;color:#808080" placeholder="group sub title field goes here." value="">--}}
                                    <input type="checkbox" class="toggle-control" id="toggle" name="group_del">
                                    <label for="toggle"></label>
                                </div>
                            </div>
                            <div class="row" style="height: 25%">
                                <div class="col-md-12" style="display: flex;justify-content: flex-end;align-items: center;height: 100%">
                                    <button type="submit" class="btn" style="background-color: #FBB03B;color: white;margin-right: 2vw;font-size: 1.0vw;padding: 0.6vw;padding-top: 0.2vw;padding-bottom: 0.2vw; ">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @endif
            <!-- Page container -->
            <div class="page-container">
                <!-- Page content -->
                <div class="page-content">
                    @include('shared.sidebar')
                    <!-- Main content -->
                    <div class="content-wrapper">
                        @yield('content')
                        @include('shared.footer')
                    </div>
                    <!-- /main content -->
                </div>

                <!-- /page content -->

            </div>


            <!-- /page container -->
            {{--<div class="dropdown-menu dropdown-menu-right toggle filter">--}}
                {{--<h3>filtered. <i class="fa fa-glass" style="color: rgb(250, 175, 58);"></i></h3>--}}
                {{--<ul>--}}
                    {{--<li>--}}
                        {{--&nbsp;&nbsp;default filter--}}
                        {{--<div class="filterbar">--}}
                            {{--<div class="filterline">--}}
                                {{--<div class="filterhead"></div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<span style="margin-left: 120px;font-weight: 600;color:#48aa9d">6</span>--}}
                        {{--<span style="margin-left: 10px;font-weight: 600;color:#777"> months</span>--}}
                        {{--<span style="float:right; color: #65c5b9; font-weight: 800; font-size: 12px;">remove</span>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<img class="lazy" src = "{{ asset("assets/images/icons/avatar.png")}}" />--}}
                        {{--&nbsp;&nbsp; Almost Human--}}
                        {{--<span style="top: 3px; left: 190px; font-weight: 600;color:#48aa9d;position:absolute;">3</span>--}}
                        {{--<span style="top: 3px; left: 230px; font-weight: 600;color:#48aa9d;position:absolute;">12</span>--}}
                        {{--<span style="top: 3px; left: 270px; font-weight: 600;color:#48aa9d;position:absolute;">24</span>--}}
                        {{--<div class="filterbar">--}}
                            {{--<div class="filterline">--}}
                                {{--<div class="filterhead"></div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<span style="float:right; color: #fff; font-weight: 800; font-size: 12px;"><i class="fa fa-close"></i></span>--}}
                    {{--</li>--}}
                    {{--@foreach($musics as $music)--}}
                    {{--@if($music->filter == 1)--}}
                    {{--<li>--}}
                        {{--<img class="lazy" src = "{{asset("assets/images/icons/avatar.png")}}" />--}}
                        {{--&nbsp;&nbsp; Almost Human--}}
                        {{--<span style="top: 3px; left: 190px; font-weight: 600;color:#48aa9d;position:absolute;">3</span>--}}
                        {{--<span style="top: 3px; left: 230px; font-weight: 600;color:#48aa9d;position:absolute;">12</span>--}}
                        {{--<span style="top: 3px; left: 270px; font-weight: 600;color:#48aa9d;position:absolute;">24</span>--}}
                        {{--<div class="filterbar">--}}
                            {{--<div class="filterline">--}}
                                {{--<div class="filterhead"></div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<span style="float:right; color: #fff; font-weight: 800; font-size: 12px;"><i class="fa fa-close"></i></span>--}}
                    {{--</li>--}}
                    {{--@endif--}}
                    {{--@endforeach--}}
                {{--</ul>--}}
            {{--</div>--}}

        @else
            <!-- Page container -->
            <div class="page-container">
                <!-- Page content -->
                <div class="page-content">
                    <!-- Main content -->
                    <div class="content-wrapper">
                        @yield('content')
                    @include('shared.footer')

                    </div>

                    <!-- /main content -->
                </div>
                <!-- /page content -->
            </div>
            <!-- /page container -->
        @endif
    </body>



        <!-- Core JS files -->



    {{----}}
    <script type="text/javascript" src="{{asset('js/plugins/loaders/pace.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/core/libraries/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/loaders/blockui.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap-datepicker.min.js')}}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script type="text/javascript" src="{{asset('js/plugins/visualization/d3/d3.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/visualization/d3/d3_tooltip.js')}}"></script>
    <!-- <script type="text/javascript" src="{{asset('js/plugins/forms/styling/switchery.min.js')}}"></script> -->
    <script type="text/javascript" src="{{asset('js/plugins/forms/styling/uniform.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/forms/selects/bootstrap_multiselect.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/ui/moment/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/core/app.js')}}"></script>
    <!--<script type="text/javascript" src="{{asset('js/pages/dashboard.js')}}"></script>    -->

    <!-- Theme JS files -->
    <script type="text/javascript" src="{{asset('js/plugins/tables/datatables/datatables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/tables/datatables/extensions/row_reorder.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/tables/datatables/extensions/responsive.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/forms/selects/select2.min.js')}}"></script>

    <script type="text/javascript" src="{{asset('js/pages/datatables_extension_row_reorder.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/pages/datatables_advanced.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/notifications/bootbox.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/pages/form_inputs.js')}}"></script>
    <!--<script type="text/javascript" src="{{asset('js/pages/form_select2.js')}}"></script>-->
    <!-- Theme JS files -->
    <script type="text/javascript" src="{{asset('js/core/libraries/jquery_ui/widgets.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/core/libraries/jquery_ui/touch.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/sliders/slider_pips.min.js')}}"></script>

    <script type="text/javascript" src="{{asset('js/core/app.js')}}"></script>

    <script type="text/javascript" src="{{asset('js/main.js')}}"></script>
    <!-- /theme JS files -->
    <script src="{{asset("js/bootstrap-tooltip.js")}}"></script>
    <script src="{{asset("js/bootstrap-popover.js")}}"></script>
    {{--Lazy--}}
    <script type="text/javascript" src="{{ asset('js/lazy/jquery.lazy.min.js') }}"></script>




</html>
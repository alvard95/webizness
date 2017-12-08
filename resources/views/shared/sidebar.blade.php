<!-- Main sidebar -->
<div class="sidebar sidebar-main" style="width: 17vw;">
    <div class="sidebar-content">

        <!-- Main navigation -->
        <div class="sidebar-category sidebar-category-visible">
            <div class="category-content no-padding">
                <ul class="navigation navigation-main navigation-accordion">

                    <!-- Main -->
                    <li class="navigation-header">
                        <span>
                            <div style="margin: auto;width: 73%;border-radius: 50%;display: flex">

                                <div style="width:100%;height: 100%;display: flex;justify-content: center;align-items: center">
                                    <div style="width: 17vw;height: 17vw;display: flex;justify-content: center;align-items: center" id="sidebar_img_div">
                                        <img src="{{asset('assets/images/profile/'.Auth::user()['avatar'])}}" alt="" style="width:100%;height: 100%;border-radius: 50%" id="sidebar_img">
                                    </div>


                                    <div style="width: 73%;height: 2.5vw;background-color: white;position: absolute;bottom:3vw;opacity: 0.7;cursor: pointer;display: none;justify-content: center" id="sidebar_edit">
                                        <label style="font-size: 1.3vw;color: black;text-transform:none;cursor: pointer" for="upload-photo">edit</label>
                                        <input type="file" name="photo" id="upload-photo" style="opacity: 0;position: absolute;z-index: -1" accept="image/*" onchange="changeImg()"/>
                                    </div>
                                </div>
                            </div>

                        </span>

                        @if($check_count != 0)
                            {{--<span></span>--}}
                            <span class="s_count" style="margin-top: 1.7vw;margin-bottom: 1vw;">
                                <span id="unread_count">{{ $check_count }}</span>
                                <img src="{{asset('assets/images/icons/icon_dot_brown.png')}}" alt="" class="online" style="position: absolute;bottom: 1.7vw;margin-left: -0.5vw;">
                                <span class="demo">new demos</span>
                            </span>
                        @else
                            <span class="hello_demo">
                                <span class="demo1">hello demo.</span>
                            </span>
                        @endif
                    </li>
                    @if(strpos(Route::getFacadeRoot()->current()->uri(), 'bills')!==false)
                     <li class="" style="margin-top: 0px">
                    @else
                     <li style="margin-top: 0px">
                    @endif                    
                        <a href="/upload"><img src="{{asset('assets/images/icons/icon_dot_lightblue.png')}}" style="width: 1vw;height: 1vw" alt=""> <span class="navigation-menu">uploads <span class="counts">({{ $upload_count }})</span></span></a></li>
                    
                    @if(strpos(Route::getFacadeRoot()->current()->uri(), 'records')!==false)
                     <li class="" style="margin-top: 0px">
                    @else
                     <li style="margin-top: 0px">
                    @endif
                        <a href="/"><img src="{{asset('assets/images/icons/icon_dot_green.png')}}" style="width: 1vw;height: 1vw" alt=""> <span class="navigation-menu">inbox <span class="counts">({{ $inbox }})</span></span></a></li>

                    @if(strpos(Route::getFacadeRoot()->current()->uri(), 'dispute')!==false)
                     <li class="" style="margin-top: 0px">
                    @else
                     <li style="margin-top: 0px">
                    @endif
                        <a href="/favourite"><img src="{{asset('assets/images/icons/icon_favourite.png')}}" style="width: 1vw;height: 1vw" alt=""> <span class="navigation-menu">favorites <span class="counts">({{ $favorite_count }})</span></span></a></li>

                    <li><a href=""></a></li>

                    @foreach($group_info as $group)
                    @if(strpos(Route::getFacadeRoot()->current()->uri(), 'payment')!==false)
                     <li class="" style="margin-top: 0px">
                    @else
                     <li style="margin-top: 0px">
                    @endif
                        <a href="/group/{{ $group->id }}" style="display: flex;align-items: center"><div style="width: 1vw; height: 1vw; background-color: {{ $group->color }}; border-radius: 50%;"></div>  <span class="navigation-menu">{{$group->name}} <span class="counts">({{ $group->count }})</span></span></a></li>
                    @endforeach
                    {{--@if(strpos(Route::getFacadeRoot()->current()->uri(), 'payment')!==false)--}}
                     {{--<li class="">--}}
                    {{--@else--}}
                     {{--<li>--}}
                    {{--@endif--}}
                        {{--<a href=""><img src="{{asset('assets/images/icons/icon_dot_yellow.png')}}" alt=""> <span class="navigation-menu">family <span class="counts">(0)</span></span></a></li>--}}
                    {{--<li id="add_group_li" style="display: none;">--}}
                        {{--<div style="display:flex;padding: 8px 4vw !important;">--}}
                            {{--<form method="POST" action="/add_group">--}}
                                {{--<div style="display: flex">--}}
                                    {{--{{ csrf_field() }}--}}
                                    {{--<input type="color" id="html5colorpicker" onchange="clickColor(0, -1, -1, 5)" value="#ff0000" name="color" style="width: 28px; height: 22px;border-radius: 50%;margin-top: 9px;"/>--}}
                                    {{--<input type="text" class="form-control" name="name" style="margin-left: 1vw;border-top: none;border-left: none;border-right: none;"/>--}}
                                    {{--<button type="submit" class="btn">Add Group</button>--}}
                                {{--</div>--}}
                            {{--</form>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    @if(strpos(Route::getFacadeRoot()->current()->uri(), 'payment')!==false)
                     <li class="">
                    @else
                     <li>
                    @endif
                        <a id="update_group"><span class="counts"><h1>+</h1></span></a></li>
                    <!-- /main -->


                    
                </ul>
            </div>
        </div>
        <!-- /main navigation -->

        
    </div>

    <div class="sidebar-category sidebar-category-visible about-sector">
        <div class="category-content no-padding">
            <ul class="navigation navigation-main navigation-accordion">

                <!-- Main -->
                @if(strpos(Route::getFacadeRoot()->current()->uri(), 'line')!==false)
                    <li class="">
                @else
                    <li>
                @endif
                    <a href="/phoneline"><img class="lazy" src="{{asset('assets/images/icons/qrcode.png')}}" alt=""> <span class="qr_des">share.</span></a></li>
                <!-- /main -->

                
            </ul>
        </div>
    </div>
</div>
{{--<div id="myModal" class="modal fade" role="dialog">--}}
    {{--<div class="modal-dialog"  style="width: 70%">--}}

        {{--<!-- Modal content-->--}}
        {{--<div class="modal-content">--}}
            {{--<div class="modal-header">--}}
                {{--<button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                {{--<h4 class="modal-title">Edit Animal</h4>--}}
            {{--</div>--}}
            {{--<div class="modal-body">--}}
            {{--</div>--}}
            {{--<div class="modal-footer">--}}
                {{--<button type="submit" class="btn btn-success" id="save">Save</button>--}}
                {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
<!-- /main sidebar -->

{{--Angel--}}
<script>
    function changeImg(){
        var property = document.getElementById("upload-photo").files[0];
        var image_name = property.name;
        var image_extension = image_name.split('.').pop().toLowerCase();
        if(jQuery.inArray(image_extension,['gif','png','jpg','jpeg']) == -1){
            alert("Invalid Image File");
        }
        var image_size = property.size;
        if(image_size > 2000000)
        {
            alert("Image File Size is very big");
        }else{
            var form_data = new FormData();
            form_data.append('file',property);
            $.ajax({
                url:'upload_img',
                method:'POST',
                data:form_data,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(){
                    $('#sidebar_img_div').html('<img src="assets/images/LAB.gif" alt="" style="width:30%;height: 30%;border-radius: 50%">');
                },
                success:function(data){
                    location.reload();
//                    $('#sidebar_img_div').html('<img src="'+JSON.parse(data)+'" alt="" style="width:100%;height: 100%;border-radius: 50%" id="sidebar_img">');
//                    $('#sidebar_img').hover(function(){
//                        $("#sidebar_edit").css("display","flex");
//                    })
//
//                    $('#sidebar_edit').hover(function(){
//                        $("#sidebar_edit").css("display","flex");
//                    })
//
//                    $('#sidebar_img').mouseout(function(){
//                        $("#sidebar_edit").css("display","none");
//                    })
//
//                    $('#sidebar_edit').mouseout(function(){
//                        $("#sidebar_edit").css("display","none");
//                    })
                }
            })
        }
    }
</script>

$(document).ready(function() {
    var audioElement;
    var samePlay = false;
    $(".tame-toggle li").click(function() {
        var object = $(this).find("input"); // hidden

        if (!$(this).hasClass("active")) {
            $(this).addClass("active");
        } else {
            $(this).removeClass("active");
        }
    });

//Angel
    $("#upload_contact_plus").on('click',function(){
        // console.log("upload contact plus");
        $("#contact_dialog").css("display","flex");
    });

    // $("#contact_dialog").on('click',function(){
    //     $("#contact_dialog").css("display","none");
    // });

    $("#contact_close").on('click',function(){
        $("#contact_dialog").css("display","none");
    });

    $("#group_close").on('click',function(){
        $("#group_dialog").css("display","none");
    });

    $("#group_edit_close").on('click',function(){
        $("#group_edit_dialog").css("display","none");
    });
    //End
    
    // $("#update_group").click(function(){
    //    $("#myModal").show();
    // });

    $(".contacts_send .contact_user").click(function() {
        if (!$(this).hasClass("active")) {
            $(this).addClass("active");
        } else {
            $(this).removeClass("active");
        }
    });
    $(".contact_drop").click(function() {
        if (!$(this).hasClass("active")) {
            $(this).addClass("active");
        } else {
            $(this).removeClass("active");
        }
    });
    $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [label]);
    });
//Angel
    $("#update_group").on('click',function(){
        // alert();
        $("#group_dialog").css('display','flex');
    });

    $("#group_edit").on('click',function(){
        // alert();
        $("#group_edit_dialog").css('display','flex');
    });


    //End Angel

    $('.btn-file :file').on('fileselect', function(event, label) {
        var input = $(this).parents('.input-group').find(':text'),
            log = label;
        if (input.length) {
            input.val(log);
        } else {
            if (log) alert(log);
        }
    });

    $('#search_icon').click(function(){
        // console.log($('#search').val());
        self.window.location = '/'+$('#search').val();
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#img-upload').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp").change(function() {
        readURL(this);
    });


    // chat script

    $( ".show_msg" ).on( "click", function() {
        to_user = $(this).attr("id");
        var _token = $("#_token").val();
        $.ajax({
            url: "show_msg",
            type: "post",
            data: {
                    "_token": _token,
                    "to_user": to_user
                } ,
            success: function (result) {
                $('.friend_msg').html('');
                $('.recerver_user_img').html('');
                $('.recerver_user_name').html('');
                $('.recerver_user').removeClass('display_recerver_user');
                console.log(result);
                var messages = result.twoMessages;
                var recerver_user = result.recerver_user;
                for(var i=0;i<messages.length;i++){
                    console.log(messages[i])
                    if(messages[i].user_id == result.auth_id){
                       $('.friend_msg').append('<div class="col-md-10"  style="float:right">'+
                            '<div class="alert col-md-12"  >'+
                                '<div class="col-md-2 user_img" style="float:right"  >'+
                                    '<img width="40" height="40" src="assets/images/profile/'+messages[i].avatar+'">'
                                +'</div><div class="col-md-8" style="float:right;padding-top:  10px;"  ><span style="float:right">'+
                                    messages[i].message
                                +'</span></div>'
                            +'</div>'
                        +'</div>')
                    }else{
                       $('.friend_msg').append('<div class="col-md-10"  style="float:left">'+
                            '<div class="alert col-md-12 ">'+
                                '<div class="col-md-2 user_img" style="float:left; "  >'+
                                    '<img width="40" height="40" src="assets/images/profile/'+messages[i].avatar+'">'
                                +'</div><div class="col-md-8 to_message" style="padding-top:  10px;padding-bottom: 10px;"  ><span style="float:left">'+
                                    messages[i].message
                                +'</span></div>'
                            +'</div>'
                        +'</div>')
                    }
                }
                if(recerver_user){
                    $('.recerver_user_img').append('<img width="55" height="55" src="assets/images/profile/'+recerver_user.avatar+'">');
                    $('.recerver_user_name').append('<span style="float:left">'+ recerver_user.first_name + ' ' + recerver_user.last_name +'</span>');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
               console.log(textStatus, errorThrown);
            }


        });

    });






});
// /// File Input

// audio Player
$(".jwplayer button").click(function() {
    // var music = this.parentElement.parentElement.parentElement.getElementsByTagName("audio")[0];
    var parent = $(this).parents('#audioplayer');
    var pButton = $(this)[0];
    // console.log(pButton);
    // console.log($(this));

    if (!$(this).parents(".jwplayer").hasClass("active")) {
        stop();
        $(".jwplayer.active").removeClass("active");
        $(this).parents(".jwplayer").addClass("active");
        $('#playhead', $(parent)).addClass("active");
    }
    if ((audioElement.paused == true || samePlay == true) && pButton.classList[0] == 'play') {
        $(parent).css('background-color', '#b1a28f');
        $('#playhead', $(parent)).css('background-color', '#faaf3a');
        $('.item-action > .fa-heart-o').css('color', '#faaf3a');
        $('.m_brief', $(parent)).css('color', 'white');
        $('.m_name', $(parent)).css('color', 'white');
        audioElement.play();
        $('#playhead', $(parent)).addClass("active");
        // remove play, add pause
        pButton.className = "";
        pButton.className = "pause";
    } else { // pause music
        $(parent).css('background-color', '#e6e6e6');
        $('#playhead', $(parent)).css('background-color', '#cccccc');
        $('.item-action > .fa-heart-o').css('color', '#d8d8d8');
        $('.m_brief', $(parent)).css('color', '#828282');
        $('.m_name', $(parent)).css('color', '#808080');
        audioElement.pause();
        // remove pause, add play
        pButton.className = "";
        pButton.className = "play";
    }

    audioElement.addEventListener("timeupdate", function() {
        timeUpdate(parent);
    },true);
    // Gets audio file duration
    audioElement.addEventListener("canplaythrough", function() {
        duration = audioElement.duration;
    }, false);
});
/// bootstrap popup close.
$('.dropdown-menu').find('form').click(function(e) {
    e.stopPropagation();
});

$(".btn-prev").click(function() {
    if ($(".jwplayer.active").prev(".jwplayer").length == 0) return false;
    stop();
    playPrev();
});
$(".btn-next").click(function() {
    if ($(".jwplayer.active").next(".jwplayer").length == 0) return false;
    stop();

    playNext();
});
$(".btn-shuffle").click(function() {
    if ($(this).hasClass("on")) $(this).removeClass("on");
    else $(this).addClass("on");
});
$(".page-title h2 img").click(function() {
    playFirst();
});
$(".filter-control").change(function() {
    document.location = "/records/" + $("#month").val() + "/" + $("#phone").val()
});

$(".item-cell").click(function() {

    if ($(this).hasClass("active")) $(this).removeClass("active");
    else $(this).addClass("active");
});

$(".second").click(function() {
    var dropdown = $(this).find("ul");
    if (dropdown.hasClass("active")) dropdown.removeClass("active").hide();
    else {
        if ($("ul.active").length) $("ul.active").hide().removeClass("active");
        else dropdown.addClass("active").show();
    }
});

$(".filtered a").click(function() {
    var obj = $(this).parent();
    // var dropdown = obj.find("div.toggle");
    var dropdown = $('.toggle.filter');
    if (dropdown.hasClass("active")) dropdown.removeClass("active").hide();
    else {
        if ($("div.toggle.active").length) $("div.toggle.active").hide().removeClass("active");
        else dropdown.addClass("active").show();
    }
});

$("ul.tag_group li").click(function() {
    if (!($(this).hasClass("signed"))) {
        $(this).parent().find(".active").removeClass("active");
        $(this).find("button").addClass("active");
    }
});

$(window).resize(function() {
    initialize();
});

initialize();

function initialize() {
    var width = $("#audioplayer").width();
    var height = $(window).height();

    var temp = parseInt(width) - parseInt($(".m_avatar").width()) - parseInt($(".m_action").width());
    // console.log("temp");
    // console.log(parseInt($(".m_avatar").width()));
    // console.log(parseInt($(".m_action").width()));
    if (temp < 40 && parseInt($(".m_action").width()) < parseInt($(".m_avatar").width())/2)
        $('.progressbar').hide();
    else{
        $(".progressbar").show().width(temp - 25);
    }
    // size responsive{

}
// Audio player
// var music = document.getElementsByTagName("audio")[0]; // id for audio element
// if (audioElement)
//     var duration = audioElement.duration; // Duration of audio clip, calculated here for embedding purposes
var pButton = document.getElementById('pButton'); // play button
// var pButton = document.getElementsByClassName('play')[0];


var playhead = document.getElementById('playhead'); // playhead
var timeline = document.getElementById('timeline'); // timeline

// timeline width adjusted for playhead
if (timeline)
    var timelineWidth = timeline.offsetWidth - playhead.offsetWidth;

// makes timeline clickable
$(".progressbar #timeline").on("click", function(event) {
    var music = audioElement;
    var duration = audioElement.duration; // Duration of audio clip, calculated here for embedding purposes
    $(this).find(".playhead").addClass("active");
    moveplayhead(event);
    audioElement.currentTime = duration * clickPercent(event);
    $(this).find(".playhead").removeClass("active");
});

// returns click as decimal (.77) of the total timelineWidth
function clickPercent(event) {
    return (event.clientX - getPosition(timeline)) / timelineWidth;
}

// makes playhead draggable
//playhead.addEventListener('mousedown', mouseDown, false);
window.addEventListener('mouseup', mouseUp, false);

// Boolean value so that audio position is updated only when the playhead is released
var onplayhead = false;

// mouseDown EventListener
$(".playhead").mousedown(function() {
    var parent = $(this).parents(".jwplayer");
    var music = $(this).parents(".jwplayer").find("audio")[0];
    onplayhead = true;
    $(this).addClass("active");
    window.addEventListener('mousemove', moveplayhead, true);
    audioElement.removeEventListener('timeupdate', timeUpdate(parent), false);
});

// mouseUp EventListener
// getting input from all mouse clicks
function mouseUp(event) {
    var parent = $(".playhead.active").parents(".jwplayer");
    var music = $(".playhead.active").parents(".jwplayer").find("audio")[0];
    if (onplayhead == true) {
        moveplayhead(event);
        window.removeEventListener('mousemove', moveplayhead, true);
        // change current time
        audioElement.currentTime = duration * clickPercent(event);
        audioElement.addEventListener('timeupdate', timeUpdate(parent), false);
    }
    onplayhead = false;
    $(".playhead").removeClass("active");
}
// mousemove EventListener

// Moves playhead as user drags
function moveplayhead(event) {
    var playhead = $(".playhead.active")[0];
    var newMargLeft = event.clientX - getPosition(timeline);

    if (newMargLeft >= 0 && newMargLeft <= timelineWidth) {
        playhead.style.marginLeft = newMargLeft + "px";
    }
    if (newMargLeft < 0) {
        playhead.style.marginLeft = "0px";
    }
    if (newMargLeft > timelineWidth) {
        playhead.style.marginLeft = timelineWidth + "px";
    }
}

function playFirst() {
    var parent = $(".jwplayer:eq(0)");

    var music = parent[0].getElementsByTagName("audio")[0];
    var pButton = parent[0].getElementsByTagName("button")[0];
    stop();

    $(".jwplayer.active").removeClass("active");
    $("#playhead.active").removeClass("active");
    parent.addClass("active");

    if (audioElement.paused) {
        $(parent).css('background-color', '#b1a28f');
        $('#playhead', $(parent)).addClass("active");
        $('#playhead', $(parent)).css('background-color', '#faaf3a');
        $('.item-action > .fa-heart-o').css('color', '#faaf3a');
        $('.m_brief', $(parent)).css('color', 'white');
        $('.m_name', $(parent)).css('color', 'white');
        audioElement.play();
        // remove play, add pause
        pButton.className = "";
        pButton.className = "pause";
    } else { // pause music
        $(parent).css('background-color', '#e6e6e6');
        $('#playhead', $(parent)).css('background-color', '#cccccc');
        $('.item-action > .fa-heart-o').css('color', '#d8d8d8');
        $('.m_brief', $(parent)).css('color', '#828282');
        $('.m_name', $(parent)).css('color', '#808080');
        audioElement.pause();
        // remove pause, add play
        pButton.className = "";
        pButton.className = "play";
    }
//change
    audioElement.addEventListener("timeupdate", function() {
        timeUpdate(parent);
    });
    // Gets audio file duration
    audioElement.addEventListener("canplaythrough", function() {
        duration = audioElement.duration;
    }, false);

}

function playPrev() {
    var parent = $(".jwplayer.active").prev(".jwplayer");

    var music = parent[0].getElementsByTagName("audio")[0];
    var pButton = parent[0].getElementsByTagName("button")[0];
    stop();

    $(".jwplayer.active").removeClass("active");
    $("#playhead.active").removeClass("active");
    parent.addClass("active");

    if(typeof audioElement === 'undefined'){
        audioElement = document.createElement('audio');
        audioElement.setAttribute('src', window.location.origin+'/uploads/'+$(parent).attr('data-file'));
        audioElement.setAttribute('id',$(parent).attr('data-id'));
        audioElement.setAttribute('class',"jwengine");
        audioElement.setAttribute('preload',"true");
        musicFile = $(parent).attr('data-file');
        audioElement.load();
    }else{
        if(musicFile != $(parent).attr('data-file') || audioElement.paused == true){
            audioElement.setAttribute('src', window.location.origin+'/uploads/'+$(parent).attr('data-file'));
            audioElement.setAttribute('id',$(parent).attr('data-id'));
            audioElement.setAttribute('class',"jwengine");
            audioElement.setAttribute('preload',"true");
            musicFile = $(parent).attr('data-file');
            audioElement.load();
        }else{
            audioElement.paused = true;
        }
        // }
    }

    $.ajax({
        url:'/getMusicInfo',
        type:'POST',
        data:{'music_id':$(parent).attr('data-id')},
        success:function(data){
            console.log(data);
            var data_val = JSON.parse(data);
            $('#track_user').text(data_val.first_name+" "+data_val.last_name);

            var created_time = new Date(data_val.created_at);
            var today = new Date();
            var diffMs = (today-created_time); // milliseconds between now & Christmas
            var diffDays = Math.floor(diffMs / 86400000); // days
            var diffHrs = Math.floor((diffMs % 86400000) / 3600000); // hours
            var diffMins = Math.round(((diffMs % 86400000) % 3600000) / 60000); // minutes
            if(diffDays > 0){
                $('#music_ltime').text(diffDays+" days ago");
            }else if(diffHrs > 0){
                $('#music_ltime').text(diffHrs+" hrs ago");
            }else if(diffMins > 1){
                $('#music_ltime').text(diffMins+" mins ago");
            }else{
                $('#music_ltime').text("1 mins ago");
            }

            // console.log(data_val);

            $('#track_user').text(data_val.first_name + " "+ data_val.last_name);
            $('#music_title').text(data_val.title);

            // if(music['uploader_id'] != music['file_id']) {
                $("input[name='music_id']").val($(parent).attr('data-id'));
                $("input[name='uploader_id']").val(data_val['uploader_id']);
            // }
            // if(music['uploader_id'] != music['file_id']){
                var user = $("input[name='user']").val();
                $.ajax({
                    type:"POST",
                    url:'/get_message',
                    data: {'music_id':$(parent).attr('data-id'),'uploader_id':data_val['uploader_id']},
                    success:function(data){
                        // console.log(music['id']);
                        // console.log(music['file_id']);
                        // console.log(data);
                        $( "#messages" ).children().remove();
                        data.map(function(currectData,index){

                            // console.log(currectData);
                            //uploader
                            var str = '<li style="width: 100%;display: flex;flex-direction: row;margin-top: 0.3vw;margin-bottom: 0.3vw;align-items: flex-end;">';
                            str += '<img src="assets/images/profile/'+currectData.user_avatar+'" style="width: 2vw;height:2vw;border-radius: 50%;">';
                            str += '<div style="max-width: 79%;background-color: #23AE98;margin-left: 1%;margin-right: 1%;border-radius: 0.3vw;padding:0.1vw;padding-left: 0.3vw;padding-right: 0.3vw;color: white;font-family: \'dosis\';font-size: 0.9vw;">';
                            str += '<span>'+ currectData.message +'</span> </div></li>';

                            //me
                            var str1 = '<li style="width: 100%;display: flex;flex-direction: row;margin-top: 0.3vw;margin-bottom: 0.3vw;justify-content: flex-end;align-items: flex-end">';
                            str1 += '<div style="max-width: 79%;background-color: #FCF9CE;margin-left: 1%;margin-right: 1%;border-radius: 0.3vw;padding:0.1vw;padding-left: 0.3vw;padding-right: 0.3vw;font-family: \'dosis\';font-size: 0.9vw;">';
                            str1 += '<span>'+currectData.message+'</span>\n</div>';
                            str1 += '<img src="assets/images/profile/'+currectData.user_avatar+'" style="width: 2vw;height:2vw;border-radius: 50%;"></li>';
                            // console.log( JSON.parse(user));
                            if(currectData.user_id ==  JSON.parse(user)['id'])
                                $( "#messages" ).append( str1 );
                            else
                                $( "#messages" ).append( str );
                        })

                     }
                })
            }
        });

    if (audioElement.paused) {
        $(parent).css('background-color', '#b1a28f');
        $('#playhead', $(parent)).addClass("active");
        $('#playhead', $(parent)).css('background-color', '#faaf3a');
        $('.item-action > .fa-heart-o').css('color', '#faaf3a');
        $('.m_brief', $(parent)).css('color', 'white');
        $('.m_name', $(parent)).css('color', 'white');
        audioElement.play();
        // remove play, add pause
        pButton.className = "";
        pButton.className = "pause";


        $.ajax({
            url:'/getMusicInfo',
            type:'POST',
            data:{'music_id':$(parent).attr('data-id')},
            success:function(data){
                console.log(data);
                var data_val = JSON.parse(data);
                $('#track_user').text(data_val.first_name+" "+data_val.last_name);

                var created_time = new Date(data_val.created_at);
                var today = new Date();
                var diffMs = (today-created_time); // milliseconds between now & Christmas
                var diffDays = Math.floor(diffMs / 86400000); // days
                var diffHrs = Math.floor((diffMs % 86400000) / 3600000); // hours
                var diffMins = Math.round(((diffMs % 86400000) % 3600000) / 60000); // minutes
                if(diffDays > 0){
                    $('#music_ltime').text(diffDays+" days ago");
                }else if(diffHrs > 0){
                    $('#music_ltime').text(diffHrs+" hrs ago");
                }else if(diffMins > 1){
                    $('#music_ltime').text(diffMins+" mins ago");
                }else{
                    $('#music_ltime').text("1 mins ago");
                }

                // if(music['uploader_id'] != music['file_id']) {
                $("input[name='music_id']").val($(parent).attr('data-id'));
                $("input[name='uploader_id']").val(data_val['uploader_id']);
                // }
                // if(music['uploader_id'] != music['file_id']){
                var user = $("input[name='user']").val();
                $.ajax({
                    type:"POST",
                    url:'/get_message',
                    data: {'music_id':$(parent).attr('data-id'),'uploader_id':data_val['uploader_id']},
                    success:function(data){
                        // console.log(music['id']);
                        // console.log(music['file_id']);
                        // console.log(data);
                        $( "#messages" ).children().remove();
                        data.map(function(currectData,index){

                            // console.log(currectData);
                            //uploader
                            var str = '<li style="width: 100%;display: flex;flex-direction: row;margin-top: 0.3vw;margin-bottom: 0.3vw;align-items: flex-end;">';
                            str += '<img src="assets/images/profile/'+currectData.user_avatar+'" style="width: 2vw;height:2vw;border-radius: 50%;">';
                            str += '<div style="max-width: 79%;background-color: #23AE98;margin-left: 1%;margin-right: 1%;border-radius: 0.3vw;padding:0.1vw;padding-left: 0.3vw;padding-right: 0.3vw;color: white;font-family: \'dosis\';font-size: 0.9vw;">';
                            str += '<span>'+ currectData.message +'</span> </div></li>';

                            //me
                            var str1 = '<li style="width: 100%;display: flex;flex-direction: row;margin-top: 0.3vw;margin-bottom: 0.3vw;justify-content: flex-end;align-items: flex-end">';
                            str1 += '<div style="max-width: 79%;background-color: #FCF9CE;margin-left: 1%;margin-right: 1%;border-radius: 0.3vw;padding:0.1vw;padding-left: 0.3vw;padding-right: 0.3vw;font-family: \'dosis\';font-size: 0.9vw;">';
                            str1 += '<span>'+currectData.message+'</span>\n</div>';
                            str1 += '<img src="assets/images/profile/'+currectData.user_avatar+'" style="width: 2vw;height:2vw;border-radius: 50%;"></li>';
                            // console.log( JSON.parse(user));
                            if(currectData.user_id ==  JSON.parse(user)['id'])
                                $( "#messages" ).append( str1 );
                            else
                                $( "#messages" ).append( str );
                        })

                    }
                })

                $('.tag_group').children().remove();
                $('.tag_group').append('<li><button type="button" class="btn"><strong>' + data_val.master + '</strong></button></li>');
                $('.tag_group').append('<li><button type="button" class="btn"><strong>' + data_val.bit + '</strong></button></li>');
                $('.tag_group').append('<li><button type="button" class="btn"><strong>' + data_val.size + '</strong></button></li>');
                if (data_val.release == 1) {
                    $('.tag_group').append('<li><button type="button" class="btn"><strong>released</strong></button></li>');
                } else {
                    $('.tag_group').append('<li><button type="button" class="btn"><strong>unreleased</strong></button></li>');
                }
                var type = String(data_val.file_name).split('.');
                $('.tag_group').append('<li><button type="button" class="btn"><strong>' + type[type.length - 1].toUpperCase() + '</strong></button></li>');
                $('.tag_group').append('<li><button type="button" class="btn"><strong>' + data_val.headroom + '</strong></button></li>');//change
                if(data_val != undefined) {
                    if ($(parent).attr('data-id') != null) {
                        $.ajax({
                            type: "GET",
                            url: '/check/' + $(parent).attr('data-id'),
                            success: function (msg) {
                                // console.log("msg" + msg);
                                $('#unread_count').text(msg);
                            }
                        });
                    }
                }
            }
        });

        var music1 = JSON.parse(parent.attr('data-id'));
        // console.log(music1);

    } else { // pause music
        $(parent).css('background-color', '#e6e6e6');
        $('#playhead', $(parent)).css('background-color', '#cccccc');
        $('.item-action > .fa-heart-o').css('color', '#d8d8d8');
        $('.m_brief', $(parent)).css('color', '#828282');
        $('.m_name', $(parent)).css('color', '#808080');
        audioElement.pause();
        // remove pause, add play
        pButton.className = "";
        pButton.className = "play";
    }

    audioElement.addEventListener("timeupdate", function() {
        timeUpdate(parent);
    });
    // Gets audio file duration
    audioElement.addEventListener("canplaythrough", function() {
        duration = audioElement.duration;
    }, false);

}

function playNext() {
    var parent = $(".jwplayer.active").next(".jwplayer");

    var music = parent[0].getElementsByTagName("audio")[0];
    var pButton = parent[0].getElementsByTagName("button")[0];
    stop();

    $(".jwplayer.active").removeClass("active");
    $("#playhead.active").removeClass("active");
    parent.addClass("active");

    if(typeof audioElement === 'undefined'){
        audioElement = document.createElement('audio');
        audioElement.setAttribute('src', window.location.origin+'/uploads/'+$(parent).attr('data-file'));
        audioElement.setAttribute('id',$(parent).attr('data-id'));
        audioElement.setAttribute('class',"jwengine");
        audioElement.setAttribute('preload',"true");
        musicFile = $(parent).attr('data-file');
        audioElement.load();
    }else{
        if(musicFile != $(parent).attr('data-file') || audioElement.paused == true){
            audioElement.setAttribute('src', window.location.origin+'/uploads/'+$(parent).attr('data-file'));
            audioElement.setAttribute('id',$(parent).attr('data-id'));
            audioElement.setAttribute('class',"jwengine");
            audioElement.setAttribute('preload',"true");
            musicFile = $(parent).attr('data-file');
            audioElement.load();
        }else{
            audioElement.paused = true;
        }
        // }
    }

    // console.log("playnext id"+$(parent).attr('data-id'));

    $.ajax({
        url:'/getMusicInfo',
        type:'POST',
        data:{'music_id':$(parent).attr('data-id')},
        success:function(data){
            var data_val = JSON.parse(data);
            $('#track_user').text(data_val.first_name+" "+data_val.last_name);

            var created_time = new Date(data_val.created_at)
            var today = new Date();
            var diffMs = (today-created_time); // milliseconds between now & Christmas
            var diffDays = Math.floor(diffMs / 86400000); // days
            var diffHrs = Math.floor((diffMs % 86400000) / 3600000); // hours
            var diffMins = Math.round(((diffMs % 86400000) % 3600000) / 60000); // minutes
            if(diffDays > 0){
                $('#music_ltime').text(diffDays+" days ago");
            }else if(diffHrs > 0){
                $('#music_ltime').text(diffHrs+" hrs ago");
            }else if(diffMins > 1){
                $('#music_ltime').text(diffMins+" mins ago");
            }else{
                $('#music_ltime').text("1 mins ago");
            }
        }
    })



    if (audioElement.paused) {
        $(parent).css('background-color', '#b1a28f');
        $('#playhead', $(parent)).addClass("active");
        $('#playhead', $(parent)).css('background-color', '#faaf3a');
        $('.item-action > .fa-heart-o').css('color', '#faaf3a');
        $('.m_brief', $(parent)).css('color', 'white');
        $('.m_name', $(parent)).css('color', 'white');
        audioElement.play();
        // remove play, add pause
        pButton.className = "";
        pButton.className = "pause";


        $.ajax({
            url:'/getMusicInfo',
            type:'POST',
            data:{'music_id':$(parent).attr('data-id')},
            success:function(data){
                console.log(data);
                var data_val = JSON.parse(data);
                $('#track_user').text(data_val.first_name+" "+data_val.last_name);

                var created_time = new Date(data_val.created_at);
                var today = new Date();
                var diffMs = (today-created_time); // milliseconds between now & Christmas
                var diffDays = Math.floor(diffMs / 86400000); // days
                var diffHrs = Math.floor((diffMs % 86400000) / 3600000); // hours
                var diffMins = Math.round(((diffMs % 86400000) % 3600000) / 60000); // minutes
                if(diffDays > 0){
                    $('#music_ltime').text(diffDays+" days ago");
                }else if(diffHrs > 0){
                    $('#music_ltime').text(diffHrs+" hrs ago");
                }else if(diffMins > 1){
                    $('#music_ltime').text(diffMins+" mins ago");
                }else{
                    $('#music_ltime').text("1 mins ago");
                }
                $('#track_user').text(data_val.first_name + " "+ data_val.last_name);
                $('#music_title').text(data_val.title);


                // if(music['uploader_id'] != music['file_id']) {
                $("input[name='music_id']").val($(parent).attr('data-id'));
                $("input[name='uploader_id']").val(data_val['uploader_id']);
                // }
                // if(music['uploader_id'] != music['file_id']){
                var user = $("input[name='user']").val();
                $.ajax({
                    type:"POST",
                    url:'/get_message',
                    data: {'music_id':$(parent).attr('data-id'),'uploader_id':data_val['uploader_id']},
                    success:function(data){
                        // console.log(music['id']);
                        // console.log(music['file_id']);
                        // console.log(data);
                        $( "#messages" ).children().remove();
                        data.map(function(currectData,index){

                            // console.log(currectData);
                            //uploader
                            var str = '<li style="width: 100%;display: flex;flex-direction: row;margin-top: 0.3vw;margin-bottom: 0.3vw;align-items: flex-end;">';
                            str += '<img src="assets/images/profile/'+currectData.user_avatar+'" style="width: 2vw;height:2vw;border-radius: 50%;">';
                            str += '<div style="max-width: 79%;background-color: #23AE98;margin-left: 1%;margin-right: 1%;border-radius: 0.3vw;padding:0.1vw;padding-left: 0.3vw;padding-right: 0.3vw;color: white;font-family: \'dosis\';font-size: 0.9vw;">';
                            str += '<span>'+ currectData.message +'</span> </div></li>';

                            //me
                            var str1 = '<li style="width: 100%;display: flex;flex-direction: row;margin-top: 0.3vw;margin-bottom: 0.3vw;justify-content: flex-end;align-items: flex-end">';
                            str1 += '<div style="max-width: 79%;background-color: #FCF9CE;margin-left: 1%;margin-right: 1%;border-radius: 0.3vw;padding:0.1vw;padding-left: 0.3vw;padding-right: 0.3vw;font-family: \'dosis\';font-size: 0.9vw;">';
                            str1 += '<span>'+currectData.message+'</span>\n</div>';
                            str1 += '<img src="assets/images/profile/'+currectData.user_avatar+'" style="width: 2vw;height:2vw;border-radius: 50%;"></li>';
                            // console.log( JSON.parse(user));
                            if(currectData.user_id ==  JSON.parse(user)['id'])
                                $( "#messages" ).append( str1 );
                            else
                                $( "#messages" ).append( str );
                        })

                    }
                })

                $('.tag_group').children().remove();
                $('.tag_group').append('<li><button type="button" class="btn"><strong>' + data_val.master + '</strong></button></li>');
                $('.tag_group').append('<li><button type="button" class="btn"><strong>' + data_val.bit + '</strong></button></li>');
                $('.tag_group').append('<li><button type="button" class="btn"><strong>' + data_val.size + '</strong></button></li>');
                if (data_val.release == 1) {
                    $('.tag_group').append('<li><button type="button" class="btn"><strong>released</strong></button></li>');
                } else {
                    $('.tag_group').append('<li><button type="button" class="btn"><strong>unreleased</strong></button></li>');
                }
                var type = String(data_val.file_name).split('.');
                $('.tag_group').append('<li><button type="button" class="btn"><strong>' + type[type.length - 1].toUpperCase() + '</strong></button></li>');
                $('.tag_group').append('<li><button type="button" class="btn"><strong>' + data_val.headroom + '</strong></button></li>');//change
                if(data_val != undefined) {
                    if ($(parent).attr('data-id') != null) {
                        $.ajax({
                            type: "GET",
                            url: '/check/' + $(parent).attr('data-id'),
                            success: function (msg) {
                                // console.log("msg" + msg);
                                $('#unread_count').text(msg);
                            }
                        });
                    }
                }
            }
        });

    } else { // pause music
        $(parent).css('background-color', '#e6e6e6');
        $('#playhead', $(parent)).css('background-color', '#cccccc');
        $('.item-action > .fa-heart-o').css('color', '#d8d8d8');
        $('.m_brief', $(parent)).css('color', '#828282');
        $('.m_name', $(parent)).css('color', '#808080');
        audioElement.pause();
        // remove pause, add play
        pButton.className = "";
        pButton.className = "play";
    }



    audioElement.addEventListener("timeupdate", function() {
        timeUpdate(parent);
    },false);

    // Gets audio file duration
    audioElement.addEventListener("canplaythrough", function() {
        duration = audioElement.duration;
    }, false);

}

function playShuffle() {
    var parent = $(".jwplayer.active");

    var music = parent[0].getElementsByTagName("audio")[0];
    var pButton = parent[0].getElementsByTagName("button")[0];
    stop();

    $(".jwplayer.active").removeClass("active");
    $("#playhead.active").removeClass("active");
    parent.addClass("active");

    if(typeof audioElement === 'undefined'){
        audioElement = document.createElement('audio');
        audioElement.setAttribute('src', window.location.origin+'/uploads/'+$(parent).attr('data-file'));
        audioElement.setAttribute('id',$(parent).attr('data-id'));
        audioElement.setAttribute('class',"jwengine");
        audioElement.setAttribute('preload',"true");
        musicFile = $(parent).attr('data-file');
        audioElement.load();
    }else{
        if(musicFile != $(parent).attr('data-file') || audioElement.paused == true){
            audioElement.setAttribute('src', window.location.origin+'/uploads/'+$(parent).attr('data-file'));
            audioElement.setAttribute('id',$(parent).attr('data-id'));
            audioElement.setAttribute('class',"jwengine");
            audioElement.setAttribute('preload',"true");
            musicFile = $(parent).attr('data-file');
            audioElement.load();
        }else{
            audioElement.paused = true;
        }
        // }
    }

    if (audioElement.paused) {
        $(parent).css('background-color', '#b1a28f');
        $('#playhead', $(parent)).addClass("active");
        $('#playhead', $(parent)).css('background-color', '#faaf3a');
        $('.item-action > .fa-heart-o').css('color', '#faaf3a');
        $('.m_brief', $(parent)).css('color', 'white');
        $('.m_name', $(parent)).css('color', 'white');
        audioElement.play();
        // remove play, add pause
        pButton.className = "";
        pButton.className = "pause";

        var music1 = JSON.parse(parent.attr('data-id'));
        // console.log(music1);
        $('.tag_group').children().remove();
        $('.tag_group').append('<li><button type="button" class="btn"><strong>' + music1.master + '</strong></button></li>');
        $('.tag_group').append('<li><button type="button" class="btn"><strong>' + music1.bit + '</strong></button></li>');
        $('.tag_group').append('<li><button type="button" class="btn"><strong>' + music1.size + '</strong></button></li>');
        if (music1.release == 1) {
            $('.tag_group').append('<li><button type="button" class="btn"><strong>released</strong></button></li>');
        } else {
            $('.tag_group').append('<li><button type="button" class="btn"><strong>unreleased</strong></button></li>');
        }
        var type = music1.file_name.split('.');
        $('.tag_group').append('<li><button type="button" class="btn"><strong>' + type[type.length - 1].toUpperCase() + '</strong></button></li>');
        $('.tag_group').append('<li><button type="button" class="btn"><strong>' + audioElement.headroom + '</strong></button></li>');//change
        if(music != undefined) {
            if (music.uploads_id != null) {
                $.ajax({
                    type: "GET",
                    url: '/check/' + music1.uploads_id,
                    success: function (msg) {
                        // console.log("msg" + msg);
                        $('#unread_count').text(msg);
                    }
                });
            }
        }
    } else { // pause music
        $(parent).css('background-color', '#e6e6e6');
        $('#playhead', $(parent)).css('background-color', '#cccccc');
        $('.item-action > .fa-heart-o').css('color', '#d8d8d8');
        $('.m_brief', $(parent)).css('color', '#828282');
        $('.m_name', $(parent)).css('color', '#808080');
        audioElement.pause();
        // remove pause, add play
        pButton.className = "";
        pButton.className = "play";
    }

    audioElement.addEventListener("timeupdate", function() {
        timeUpdate(parent);
    });
    // Gets audio file duration
    audioElement.addEventListener("canplaythrough", function() {
        duration = audioElement.duration;
    }, false);

}

function stop() {
    $('.jwplayer').css('background-color', '');
    $('.playhead').css('background-color', '#cccccc');
    $('.item-action > .fa-heart-o').css('color', '#d8d8d8');
    $('.m_brief').css('color', '#828282');
    $('.m_name').css('color', '#808080');
    $('button.pause').removeClass('pause').addClass('play');
    var music = $('audio', $(".jwplayer.active"))[0];
    if (typeof audioElement != 'undefined') audioElement.pause();
}

// timeUpdate
// Synchronizes playhead position with current point in audio
function timeUpdate(object) {
    var playhead = $(".playhead.active")[0];
    if(typeof playhead == 'undefined'){ return false; }
    // var music = $('audio', $(object))[0];
    var pButton = $('button', $(object))[0];
    var duration = audioElement.duration;
    var playPercent = timelineWidth * (audioElement.currentTime / duration);

    playhead.style.marginLeft = playPercent + "px";
    if (audioElement.currentTime == duration) {
        pButton.className = "";
        pButton.className = "play";
        audioElement.currentTime = 0;
        playhead.style.marginLeft = 0 + "px";
        $('.jwplayer').css('background-color', '');
        $('.playhead').css('background-color', '#cccccc');
        $('.item-action > .fa-heart-o').css('color', '#d8d8d8');
        $('.m_brief').css('color', '#828282');
        $('.m_name').css('color', '#808080');
        stop();
        if ($(".btn-shuffle").hasClass("on")) playShuffle();
        else {
            if ($(".jwplayer.active").next(".jwplayer").length == 0) return false;

            playNext();
        }
    }
}

//Play and Pause
function play() {
    // start music
    if (audioElement.paused) {
        $('#audioplayer').css('background-color', '#b1a28f');
        $('#playhead').css('background-color', '#faaf3a');
        $('.item-action > .fa-heart-o').css('color', '#faaf3a');
        $('.m_brief').css('color', 'white');
        $('.m_name').css('color', 'white');
        audioElement.play();
        // remove play, add pause
        pButton.className = "";
        pButton.className = "pause";
    } else { // pause music
        $('#audioplayer').css('background-color', '#e6e6e6');
        $('#playhead').css('background-color', '#cccccc');
        $('.item-action > .fa-heart-o').css('color', '#d8d8d8');
        $('.m_brief').css('color', '#828282');
        $('.m_name').css('color', '#808080');
        audioElement.pause();
        // remove pause, add play
        pButton.className = "";
        pButton.className = "play";
    }
}

// getPosition
// Returns elements left position relative to top-left of viewport
function getPosition(el) {
    return el.getBoundingClientRect().left;
}
//--- End Audio

function showFillDispute(id, datetime, reference, type, operator, amount) {
    $("#record_id").val(id);
    $("#modal_reference").val(reference);
    $("#modal_reference2").val(reference);
    $("#modal_type").val(type);

    var dateformat = new Date(datetime);
    var date = dateformat.getFullYear() + "/" + (dateformat.getMonth() + 1) + "/" + dateformat.getDate();
    var time = dateformat.getHours() + "/" + dateformat.getMinutes() + "/" + dateformat.getSeconds();
    $("#modal_date").val(date);
    $("#modal_time").val(time);
    $("#modal_operator").val(operator);
    $("#modal_amount").val(amount);
}


function onValidateComment() {
    var comment = $("#comment").val();
    if (comment.length < 320) {
        $("#modal-comment-error").show();
        return;
    }
    $("#modal-comment-error").hide();
    $("#modal-1").hide();
    $("#modal-2").show();
    $("p#str_dispute:last").html($("#comment").val());
}

function onSendToken() {
    var phone = $("#phone").val();
    var _token = $("#_token").val();
    $.post("/sendtoken", { phone: phone, _token: _token },
        function(result) {
            if (result == "OK") {
                $("#modal-2").hide();
                $("#modal-3").show();
            } else {
                $("#modal-token-error").show();
            }
        });
}

function onVerifyToken() {
    var record_id = $("#record_id").val();
    var sms_token = $("#modal_sms_token").val();
    var email_token = $("#modal_email_token").val();
    var comment = $("#comment").val();
    var amount = $("#modal_amount").val();
    var _token = $("#_token").val();

    if (sms_token == "") {
        $("#modal-dispute-error").show();
        return;
    }
    if (email_token == "") {
        $("#modal-dispute-error").show();
        return;
    }

    $.post("/filldispute", { record_id: record_id, comment: comment, amount: amount, _token: _token, sms_token: sms_token, email_token: email_token },
        function(result) {
            if (result == "OK") {
                $("#modal-3").hide();
                $("#modal-4").show();
            } else {
                $("#modal-dispute-error").show();
            }
        });

}


function closeModal() {
    $("#modal-1").show();
    $("#modal-2").hide();
    $("#modal-3").hide();
    $("#modal-4").hide();
}

function showRecordDetail(record_id) {
    var _token = $("#_token").val();

    $.ajax({
        url: '/getrecorddetail',
        type: 'POST',
        data: { _token: _token, record_id: record_id },
        dataType: 'JSON',
        success: function(data) {
            $("#modal_id").val(data.id);
            $("#modal_reference").val(data.reference);
            $("#modal_type").val(data.call_type);

            var dateformat = new Date(data.created_at);
            var date = dateformat.getFullYear() + "/" + (dateformat.getMonth() + 1) + "/" + dateformat.getDate();
            var time = dateformat.getHours() + "/" + dateformat.getMinutes() + "/" + dateformat.getSeconds();
            $("#modal_date").val(date);
            $("#modal_time").val(time);
            $("#modal_operator").val(data.operator);
            $("#modal_amount").val(data.number);
        }
    });
}
// ////// File Upload Select Condition
function signed(flag) {
    // alert(flag);
    if (flag == 1) {
        document.getElementById('release').value = '1';
        document.getElementById('signed').style.display = 'block';
    } else {
        document.getElementById('release').value = '0';
        document.getElementById('signed').style.cssText = 'display: none !important';
    }
}

function fileType(type) {
    // alert(type);
    document.getElementById('file_type').value = type;
}

function onMaster(category) {
    // alert(category);
    document.getElementById('master').value = category;
    if (category == 'premaster') {
        document.getElementById('headroom').style.display = 'block';
        // alert(document.getElementById('headroom').value);
    } else
        document.getElementById('headroom').style.display = 'none';
}

function onBit(bit) {
    // alert(bit);
    document.getElementById('bit').value = bit;
}

function onSize(size) {
    // alert(size);
    document.getElementById('size').value = size;
}
var contacts = [];
var contacts_list = [];

function onContact(id, state) {
    if (state == 0) {
        if (contacts.indexOf(id) == -1)
            contacts.push(id);
        else {
            index = contacts.indexOf(id);
            contacts.splice(index, 1);
        }
        document.getElementById('contacts_send').value = contacts;
        // console.log(contacts);
    } else {
        if (contacts_list.indexOf(id) == -1)
            contacts_list.push(id);
        else {
            var index = contacts_list.indexOf(id);
            contacts_list.splice(index, 1);
        }
        document.getElementById('contacts_send').value = contacts_list;
        // console.log(contacts_list);
    }
}
var groups = [];

function onGroup(id) {
    if (groups.indexOf(id) == -1)
        groups.push(id);
    else {
        var index = groups.indexOf(id);
        groups.splice(index, 1);
    }
    document.getElementById('group').value = groups;
}

function onFavorite(id) {
    $.ajax({
        type: "GET",
        url: '/favorite/' + id,
        success: function(msg) {
            //alert(msg);
            location.reload();
        }
    });
}

var musicFile;
function displayDetails(music, obj) {
    console.log(music);
    $('#uname').text(music.username);
    $('#music_title').text(music.title);
    //Add Music
    var audio_id = "#audio_src_" + music.file_id;
    var music_id = "#music_" + music.file_id;
    // $(audio_id).attr("src","http://192.168.0.71/uploads/24850.wav");
    // $(music_id).load();
    // console.log($(music_id));
    //
    // $(music_id).trigger('play');
    if(typeof audioElement === 'undefined'){
        audioElement = document.createElement('audio');
        audioElement.setAttribute('src', window.location.origin+'/uploads/'+music.file_name);
        audioElement.setAttribute('id',music_id);
        audioElement.setAttribute('class',"jwengine");
        audioElement.setAttribute('preload',"true");
        musicFile = music.file_name;
        audioElement.load();
        samePlay = false;
    }else{
        if(musicFile != music.file_name || audioElement.paused == true){
            if(musicFile != music.file_name)
                audioElement.setAttribute('src', window.location.origin+'/uploads/'+music.file_name);
            audioElement.setAttribute('id',music_id);
            audioElement.setAttribute('class',"jwengine");
            audioElement.setAttribute('preload',"true");
            musicFile = music.file_name;
            // audioElement.load();
            if(musicFile == music.file_name){
                samePlay = true;
            }else{
                samePlay = false;
            }
        }else{
            audioElement.paused = true;
            samePlay = false;
        }
        // }
    }

    $('#track_user').text(music.first_name+" "+music.last_name);

    var created_time = new Date(music.created_at)
    var today = new Date();
    var diffMs = (today-created_time); // milliseconds between now & Christmas
    var diffDays = Math.floor(diffMs / 86400000); // days
    var diffHrs = Math.floor((diffMs % 86400000) / 3600000); // hours
    var diffMins = Math.round(((diffMs % 86400000) % 3600000) / 60000); // minutes
    if(diffDays > 0){
        $('#music_ltime').text(diffDays+" days ago");
    }else if(diffHrs > 0){
        $('#music_ltime').text(diffHrs+" hrs ago");
    }else if(diffMins > 1){
        $('#music_ltime').text(diffMins+" mins ago");
    }else{
        $('#music_ltime').text("1 mins ago");
    }
    // $('#music_ltime').text(diffDays+" days "+diffHrs+" hrs " + diffMins+ "mins");

    // audioElement.play();
    // console.log(audioElement);

    // var duration = $(obj).closest('#audioplayer').find(audioElement)[0].duration;
    var duration = audioElement.duration;
    audioElement.addEventListener("canplay",function(){
        duration = audioElement.duration;
        var minutes = Math.floor(duration / 60);
        var seconds = parseInt(duration - minutes * 60);
        $('#music_duration')[0].childNodes[0].nodeValue = minutes + ':' + seconds;
    });


    $('.tag_group').children().remove();
    $('.tag_group').append('<li><button type="button" class="btn"><strong>' + music.master + '</strong></button></li>');
    $('.tag_group').append('<li><button type="button" class="btn"><strong>' + music.bit + '</strong></button></li>');
    $('.tag_group').append('<li><button type="button" class="btn"><strong>' + music.size + '</strong></button></li>');
    if (music.release == 1) {
        $('.tag_group').append('<li><button type="button" class="btn"><strong>released</strong></button></li>');
    } else {
        $('.tag_group').append('<li><button type="button" class="btn"><strong>unreleased</strong></button></li>');
    }
    var type = music.file_name.split('.');
    $('.tag_group').append('<li><button type="button" class="btn"><strong>' + type[type.length - 1].toUpperCase() + '</strong></button></li>');
    $('.tag_group').append('<li><button type="button" class="btn"><strong>' + music.headroom + '</strong></button></li>');
    // $('.tag_group').append('<li><button type="button" class="btn"><strong>' + music.note + '</strong></button></li>');
    // $("#message").val(music.note);
    // console.log(music);
    if(music['uploader_id'] != music['file_id']) {
        $("input[name='music_id']").val(music['file_id']);
        $("input[name='uploader_id']").val(music['uploader_id']);
    }
    if(music['uploader_id'] != music['file_id']){
        var user = $("input[name='user']").val();
        $.ajax({
            type:"POST",
            url:'/get_message',
            data: {'music_id':music['file_id'],'uploader_id':music['uploader_id']},
            success:function(data){
                // console.log(music['id']);
                // console.log(music['file_id']);
                // console.log(data);
                $( "#messages" ).children().remove();
                data.map(function(currectData,index){

                    // console.log(currectData);
                    //uploader
                    var str = '<li style="width: 100%;display: flex;flex-direction: row;margin-top: 0.3vw;margin-bottom: 0.3vw;align-items: flex-end;">';
                    str += '<img src="assets/images/profile/'+currectData.user_avatar+'" style="width: 2vw;height:2vw;border-radius: 50%;">';
                    str += '<div style="max-width: 79%;background-color: #23AE98;margin-left: 1%;margin-right: 1%;border-radius: 0.3vw;padding:0.1vw;padding-left: 0.3vw;padding-right: 0.3vw;color: white;font-family: \'dosis\';font-size: 0.9vw;">';
                    str += '<span>'+ currectData.message +'</span> </div></li>';

                    //me
                    var str1 = '<li style="width: 100%;display: flex;flex-direction: row;margin-top: 0.3vw;margin-bottom: 0.3vw;justify-content: flex-end;align-items: flex-end">';
                    str1 += '<div style="max-width: 79%;background-color: #FCF9CE;margin-left: 1%;margin-right: 1%;border-radius: 0.3vw;padding:0.1vw;padding-left: 0.3vw;padding-right: 0.3vw;font-family: \'dosis\';font-size: 0.9vw;">';
                    str1 += '<span>'+currectData.message+'</span>\n</div>';
                    str1 += '<img src="assets/images/profile/'+currectData.user_avatar+'" style="width: 2vw;height:2vw;border-radius: 50%;"></li>';
       // console.log( JSON.parse(user));
                    if(currectData.user_id ==  JSON.parse(user)['id'])
                        $( "#messages" ).append( str1 );
                    else
                        $( "#messages" ).append( str );
                })

            }
        })
    }
    if( music.uploads_id != null){
        $.ajax({
            type: "GET",
            url: '/check/' + music.uploads_id,
            success: function(msg) {
                // console.log("msg"+msg);
                $('#unread_count').text(msg);
            }
        });
    }

}

function unFavorite(id) {
    $.ajax({
        type: "GET",
        url: '/unfavorite/' + id,
        success: function(msg) {
            alert(msg);
            location.reload();
        }
    });
}

function onDelete(id,trash = 0) {
    if(trash == 0){
        $.ajax({
            type: "GET",
            url: document.URL+'delete/' + id,
            success: function(msg) {
                location.reload();
            }
        });
    }else{

        $.ajax({
            type: "GET",
            url: '/trashDelete/' + id,
            success: function(msg) {
                location.reload();
            }
        });
    }

}

function onFilter(id) {
    $.ajax({
        type: "GET",
        url: 'filter/' + id,
        success: function(msg) {
            alert(msg);
            location.reload();
        }
    });
}

function onDelSource(id) {
    $.ajax({
        type: 'GET',
        url: '/upload/delete/' + id,
        success: function(msg) {
            // console.log(msg);
            location.reload();
        }
    });
}

function onReplace(id) {
    document.getElementById('replace_id').value = id;
}

//Angel
var upload_contact_count = 0;
var upload_contact = [];
var contact_list = [];
var contact_first = 0;

$('.contact_row').click(function(){
    if($(this).attr('data-sel') == "0"){
        $(this).attr("style",'background-color:#CCB9A3');
        $(this).attr('data-sel',"1");
        upload_contact_count ++;
        // console.log(upload_contact_count);

        // contact_list.push('<span class="contact_user" id="'+$(this).attr("data-id")+ '" onclick="onContact('+$(this).attr("data-id")+', 0)">\n' +
        //     '<a class="contact_pop" rel="popover" data-original-title="'+$(this).attr("data-name")+'" style="width: 50px;height: 50px;display: block;">\n' +
        //     '<img src="assets/images/profile/'+$(this).attr('data-img')+'" /> </a>\n' +
        //     '</span>');
        // var content = "";
        // for(var i=0;i<contact_list.length;i++){
        //     content +=contact_list[i];
        // }
        // $('.contacts_send').children().remove();
        $('.contacts_send').append('<span class="contact_user" id="'+$(this).attr("data-id")+ '" onclick="onContact('+$(this).attr("data-id")+', 0)">\n' +
            '<a class="contact_pop" rel="popover" data-original-title="'+$(this).attr("data-name")+'" style="width: 50px;height: 50px;display: block;">\n' +
            '<img src="assets/images/profile/'+$(this).attr('data-img')+'" /> </a>\n' +
            '</span>');
        function onContact(id, state) {
            if (state == 0) {
                if (contacts.indexOf(id) == -1)
                    contacts.push(id);
                else {
                    index = contacts.indexOf(id);
                    contacts.splice(index, 1);
                }
                document.getElementById('contacts_send').value = contacts;
                // console.log(contacts);
            } else {
                if (contacts_list.indexOf(id) == -1)
                    contacts_list.push(id);
                else {
                    var index = contacts_list.indexOf(id);
                    contacts_list.splice(index, 1);
                }
                document.getElementById('contacts_send').value = contacts_list;
                // console.log(contacts_list);
            }
        }

        $('#'+$(this).attr("data-id")).on('click',function() {
            if (!$(this).hasClass("active")) {
                $(this).addClass("active");
            } else {
                $(this).removeClass("active");
            }
        });
        $(".contact_pop").popover();
        //upload_contact = JSON.parse($("#contact").val());
        upload_contact.push($(this).attr('data-id'));
        $("#contact").val( JSON.stringify(upload_contact) );
        $("#selected").text(upload_contact_count);

    }
    else{
        $(this).attr("style",'background-color:#E6E6E6');
        $(this).attr('data-sel',"0");
        var id = '#'+$(this).attr('data-id');
        $(id).remove();
        upload_contact_count --;
        // console.log(upload_contact_count);
        upload_contact = JSON.parse($("#contact").val());
        for(var i=0;i<upload_contact.length;i++){
            if(upload_contact[i] == $(this).attr('data-id'))
                upload_contact.splice(i,1);
        }
        $("#contact").val( JSON.stringify(upload_contact) );
        $("#selected").text(upload_contact_count);
    }
})

// Array.prototype.remove = function() {
//     var what, a = arguments, L = a.length, ax;
//     while (L && this.length) {
//         what = a[--L];
//         while ((ax = this.indexOf(what)) !== -1) {
//             this.splice(ax, 1);
//         }
//     }
//     return this;
// };

var add_group_arr=[];
var add_group_count=0;
$('.group_row').click(function(){

    if($(this).attr('data-sel') == "0"){
        $(this).attr("style",'background-color:#CCB9A3');
        $(this).attr('data-sel',"1");
        add_group_count ++;
        // console.log(upload_contact_count);
        //upload_contact = JSON.parse($("#contact").val());
        add_group_arr.push($(this).attr('data-id'));
        $("#group_info").val( JSON.stringify(add_group_arr) );
        $("#group_dialog_selected").text(add_group_count);

    }
    else{
        $(this).attr("style",'background-color:#E6E6E6');
        $(this).attr('data-sel',"0");
        add_group_count --;
        //console.log(upload_contact_count);
        add_group_arr = JSON.parse($("#group_info").val());
        for(var i=0;i<add_group_arr.length;i++){
            if(add_group_arr[i] == $(this).attr('data-id'))
                add_group_arr.splice(i,1);
        }
        $("#group_info").val( JSON.stringify(add_group_arr) );
        $("#group_dialog_selected").text(add_group_count);
    }
})

$(function (){
    $(".group_pop").popover();
    $(".contact_pop").popover();
});

$("#search").keyup(function(event){
    if(event.keyCode == 13){
        // alert( $("#search").val() );
        window.location = "/search/"+ $("#search").val();
    }
})


$('#text-semibold').hover(function(){
    $('#group_edit').css('display','flex');
},function(){
    setTimeout(function () {
        $('#group_edit').css('display','none');
    },5000);
});

$("#add_person_in_group").on('click',function(){
    // console.log($(this).attr('data-id'));
    $('#group_id_in_add_group').val($(this).attr('data-id'));
    $('#group_name_in_add_group').val($(this).attr('data-name'));
    $("#group_dialog").css('display','flex');
})


/*====================================
            Preloader
======================================*/

$(window).load(function() {

    var preloaderDelay = 350,
        preloaderFadeOutTime = 800;

    function hidePreloader() {
        var loadingAnimation = $('#loading-animation'),
            preloader = $('#preloader');
        initialize();
        loadingAnimation.fadeOut();
        preloader.delay(preloaderDelay).fadeOut(preloaderFadeOutTime);
    }

    hidePreloader();

});

$('.search_AZ').click(function(){
    $('.search_AZ.active').removeClass('active');
    $(this).addClass('active');
})

$('#sidebar_img').hover(function(){
    $("#sidebar_edit").css("display","flex");
})

$('#sidebar_edit').hover(function(){
    $("#sidebar_edit").css("display","flex");
})

$('#sidebar_img').mouseout(function(){
    $("#sidebar_edit").css("display","none");
})

$('#sidebar_edit').mouseout(function(){
    $("#sidebar_edit").css("display","none");
})


//Setting Page
$('#password_change_btn').click(function(){
    $.ajax({
        url:'/check_old_password',
        type:'POST',
        data:{ 'oldPassword': $('#oldPassword').val() },
        success:function(data){
            // console.log(JSON.parse(data) );
            if(JSON.parse(data)){
                if($('#newPassword').val() == $('#confirmPassword').val() && $('#newPassword').val().length>5){
                    $.ajax({
                        url: '/update_password',
                        type: 'POST',
                        data: {'newPassword': $('#newPassword').val()},
                        success:function(data1){
                            if(JSON.parse(data1) == "success"){
                                $('#check_password_alert').children().remove();
                                $('#check_password_alert').append('<div class="alert alert-success"><strong>Success!</strong>&nbsp; Successful.</div>');
                            }else{
                                $('#check_password_alert').children().remove();
                                $('#check_password_alert').append('<div class="alert alert-danger"><strong>Error!</strong>&nbsp; Sorry. Updating Failed. </div>');
                            }
                        }
                    });
                }else{
                    $('#check_password_alert').children().remove();
                    $('#check_password_alert').append('<div class="alert alert-danger"><strong>Error!</strong>&nbsp; Please input new password again.</div>');
                }
            }else{
                $('#check_password_alert').children().remove();
                $('#check_password_alert').append('<div class="alert alert-danger"><strong>Error!</strong>&nbsp; The Old Password is incorrect.</div>');
            }
        }
    })
})

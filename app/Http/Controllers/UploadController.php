<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use App\Models\Inbox;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

//Push Notification
use App\Helpers\ApnsHelper;

class UploadController extends Controller
{
	public function index()
	{
		$user = Auth::user();
        $musics = DB::table('uploads')
            ->join('users as uploader', 'uploads.uploader_id', '=', 'uploader.id')
//            ->where('receiver.id', '=', $user->id)
            ->where('uploads.ondelete', '=', 0)
            ->where('uploads.uploader_id', $user->id)
            ->orderBy('uploads.id', 'desc')
            ->select('uploads.id as file_id', 'uploader.*', 'uploads.*')->get();

		$uploads = DB::table('uploads')->where('uploader_id', $user->id)->where('ondelete', 0)->orderBy('created_at', 'desc')->get();

        $inbox = DB::table('inboxs')->where([['receiver',$user['id']],['ondelete',0]])->count();
        $favorite_count = DB::table('inboxs')->where([['favorite',1],['ondelete',0],['receiver',$user['id']]])->count();
		$upload_count = DB::table('uploads')->where([['uploader_id','=',$user['id']],['ondelete','=',0]])->count();
		$check_count = Inbox::where([['receiver',$user['id']],['check',0],['ondelete',0]])->count();

        $group_info = array();
        $group_info1 = DB::table('groups')->where('creater',$user['id'])->get();
        foreach($group_info1 as $group_val){
            $group_val->count = DB::table('group_musics')->where('group_id',$group_val->id)->count();
            array_push($group_info, $group_val);
        }

        $user_list = DB::table('users')->get();
        $i = 0;
        foreach($user_list as $userItem){
            $user_list[$i]->group = DB::table('group_user')->join('groups','group_user.group_id','=','groups.id')->where('group_user.user_id',$userItem->id)->get();
            $i++;
        }
		return view('uploads', ['musics' => $musics,'uploader_dialog'=>"1", 'user' => $user,'user_list'=>$user_list, 'uploads' => $uploads,'inbox' => $inbox, 'favorite_count'=>$favorite_count, 'upload_count'=>$upload_count, 'check_count'=>$check_count,'group_info'=>$group_info]);
	}

    public function uploader()
    {
        $user = Auth::user();
        $contacts = DB::table('users')
//                      ->join('contacts', 'users.id', '=', 'contacts.receiver')
//                      ->where('contacts.sender', $user->id)
//                      ->where('contacts.state', '=', '1')
                      ->select('users.*')
                      ->get();
        $musics = DB::table('inboxs')
            ->join('users as receiver', 'inboxs.receiver', '=', 'receiver.id')
            ->join('uploads', 'inboxs.uploads_id', '=', 'uploads.id')
            ->join('users as uploader', 'uploads.uploader_id', '=', 'uploader.id')
            ->where('receiver.id', '=', $user->id)
            ->where('inboxs.ondelete', '=', 0)
            ->select('uploads.id as file_id', 'inboxs.id as in_id', 'inboxs.*', 'uploader.*','uploads.*')->get();

        $inbox = DB::table('inboxs')->where([['receiver',$user['id']],['ondelete',0]])->count();
        $favorite_count = DB::table('inboxs')->where([['favorite',1],['ondelete',0],['receiver',$user['id']]])->count();
		$upload_count = DB::table('uploads')->where([['uploader_id','=',$user['id']],['ondelete','=',0]])->count();
		$check_count = Inbox::where([['receiver',$user['id']],['check',0],['ondelete',0]])->count();

        $group_info = array();
        $group_info1 = DB::table('groups')->where('creater',$user['id'])->get();
        foreach($group_info1 as $group_val){
            $group_val->count = DB::table('group_musics')->where('group_id',$group_val->id)->count();
            array_push($group_info, $group_val);
        }

//		$group_user = DB::table('group_user')->where('')
        $get_users = DB::table('users')->get();
        $users = array();
        foreach ($get_users as $get_user){
            $val = DB::table('group_user')->join('groups','group_user.group_id','=','groups.id')->where('group_user.user_id',$get_user->id)->get();
            $val1 = $get_user;
//            if($val != null && count($val) > 0){
                $val1->group_info = $val;
//            }

            array_push($users,$val1);
        }


        $user_list = DB::table('users')->get();
        $i = 0;
        foreach($user_list as $userItem){
            $user_list[$i]->group = DB::table('group_user')->join('groups','group_user.group_id','=','groups.id')->where('group_user.user_id',$userItem->id)->get();
            $i++;
        }
    	return view('uploader', ['contacts' => $contacts,'user_list'=>$user_list, 'musics' => $musics,'inbox' => $inbox, 'favorite_count'=>$favorite_count, 'upload_count'=>$upload_count,
            'check_count'=>$check_count,'group_info'=>$group_info,'users'=>$users]);
    }

    public function fileUpload(Request $request)
    {
//        var_dump(explode(',',$request->input('contacts_send')));exit;
    	$user = Auth::user();
    	$destinationPath = 'uploads';
    	$file = $request->file('file_source');
    	$extension = $file->getClientOriginalExtension();
    	$size = $file->getClientSize();
    	$fileName = rand(11111, 99999) . '.'. $extension;
    	$upload_success = $file->move($destinationPath, $fileName);
        // DB
        $title = $request->input('file_name');
        $headroom = $request->input('headroom');
        $contact = explode(',',$request->input('contacts_send'));
        if($headroom != "headroom")
            $headroom .= " headroom";
        
    	$upload = new Upload([
    		'uploader_id' => $user->id,
    		'title' => $title,
    		'file_name' => $fileName,
    		'file_type' => $request->input('file_type'),
            'release' => $request->input('release'),
            'label' => $request->input('label'),
            'date' => $request->input('date'),
            'master' => $request->input('master'),
            'headroom' => $headroom,
            'bit' => $request->input('bit'),
            'size' => $request->input('size'),
            'display' => $request->input('visible'),
//            'note' => $request->input('note'),
    		// 'date' => Carbon::now(),
    	]);
        $upload->save();
        //Push Notification
        $arr_tokens = array();
        $arr_msgs = array();

        // Group Send
        $group = $request->input('group');

        $v_group_members = array();
//        var_dump($group);exit;
        if($group) {
            $upload = Upload::orderBy('id', 'desc')->get();
            $arr = explode(',', $group);
//            var_dump($arr);exit;
            $users = DB::table('groups')
                       ->join('group_user', 'groups.id', '=', 'group_user.group_id')
                       ->join('users', 'users.id', '=', 'group_user.user_id')
                       ->where('groups.creater', $user->id)
                       ->whereIn('groups.id', $arr)
                       ->select('users.*')->get();

            foreach ($arr as $g) {
                $group_memebers = DB::table("group_user")->where('group_id', $g)->get();
                if($group_memebers != null && count($group_memebers) >0 ){
                    foreach ($group_memebers as $member){
//                        var_dump($member->user_id);
                        if($member->user_id != $user->id){
//                            $inbox = new Inbox(['uploads_id' => $upload[0]['id'], 'receiver' => $member->user_id]);
//                            $inbox->save();
                            DB::table('inboxs')->insert(['uploads_id' => $upload[0]['id'], 'receiver' => $member->user_id]);
                            if($request->input('note') != null)
                            DB::table('messages')->insert(['user_id'=>$user["id"],'receiver_id'=>$member->user_id,'message'=>$request->input('note'),'music_id'=>$upload[0]['id']]);
                            array_push($v_group_members, $member->user_id);

                            $user1 = DB::table('users')->where('id',$member->user_id)->get();
                            if(!is_null($user1[0]->ios_token)){
                                array_push($arr_tokens,$user1[0]->ios_token);
                                $msg = "Dear ".$user1[0]->first_name." ".$user1[0]->last_name."\n"."Your Inbox was added ".$title;
                                array_push($arr_msgs, $msg);
                            }
                        }

                    }
                }

                DB::table('group_musics')->insert(['upload_id' => $upload[0]['id'], 'group_id' => $g]);
            }
            //var_dump($users);exit;
        }
        // Contact send
        //$contacts_send = $request->input('$contact');
//        var_dump($contact);exit;
        if(count($contact) > 0 && $contact[0]!="" ) {
//            $contact_array = explode(',', $contact);
            $upload = Upload::orderBy('id', 'desc')->get();
            foreach ($contact as $contact1) {
                // var_dump($contact1);exit;
                if(!in_array($contact1,$v_group_members)){
                    DB::table('inboxs')->insert(['uploads_id' => $upload[0]['id'], 'receiver' => $contact1]);
                    if($request->input('note') != null)
                    DB::table('messages')->insert(['user_id'=>$user["id"],'receiver_id'=>$contact1,'message'=>$request->input('note'),'music_id'=>$upload[0]['id']]);

                    $user1 = DB::table('users')->where('id',$contact1)->get();
//                    var_dump(is_null($user[0]->ios_token) );exit;
                    if( !is_null($user1[0]->ios_token) ){
                        array_push($arr_tokens,$user1[0]->ios_token);

                        $msg = "Dear ".$user1[0]->first_name." ".$user1[0]->last_name."\n"."Your Inbox was added ".$title;
                        array_push($arr_msgs, $msg);
                    }

                }
//                if(!DB::table('inboxs')->where([['uploads_id', $upload[0]['id']],['receiver', $contact1]])->get())

            }
        }

        ApnsHelper::apns_send($arr_tokens,true,$arr_msgs);
		return redirect('/upload');
    }

    public function push(){
        $arr_tokens = array();
        $arr_msgs = array();
        $arr_tokens[0] = "91cc16b617a77f98e9667da079d86c5255e2085b34d4f46bac6fb9f05b41b6e7";
        $arr_msgs[0] = "Test";
        ApnsHelper::apns_send($arr_tokens,true,$arr_msgs);
    }

    public function replace(Request $request)
    {
        $id = $request->input('replace_id');
        $file = $request->file('source_file');
        if($file == null)
            return redirect('/upload');
        $extension = $file->getClientOriginalExtension();
        $size = $file->getClientSize();
        $fileName = rand(11111, 99999) . '.' . $extension;
        $destinationPath = 'uploads';
        $upload = Upload::find($id);
        $upload_success = $file->move($destinationPath, $fileName);
        $upload->file_name = $fileName;
        $upload->save();
        return redirect('/upload');
    }

    public function delete($id)
    {
        $upload = Upload::find($id);
        $upload->ondelete = 1;
        $upload->save();
        return response()->json('Successful');
    }

    public function upload_img(Request $request){
        $file = $request->file("file");
        $destinationPath = 'assets/images/profile/';
        if($file != ''){
//            $test = explode(".",$file);
            $extension = $file->getClientOriginalExtension();
            $file_name = rand(111111,999999).'.'.$extension;
            $user = Auth::user();
            DB::table('users')->where('id',$user['id'])->update(['avatar'=>$file_name]);
            $upload_success = $file->move($destinationPath, $file_name);
            echo json_encode($destinationPath.$file_name);
        }else{
            echo json_encode($destinationPath."avatar.png");
        }

    }

    //Ajax
    public function getMusicInfo(Request $request){
        $music_id = $request->input('music_id');
        $result = DB::table('uploads')
                    ->join('users','uploads.uploader_id','=','users.id')
                    ->where('uploads.id',$music_id)->select('users.*','uploads.*')->first();
        echo json_encode($result);
    }
}

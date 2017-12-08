<?php

namespace App\Http\Controllers;

use App\Models\Inbox;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MongoDB\Driver\ReadConcern;
use phpDocumentor\Reflection\Types\Null_;
use Illuminate\Support\Facades\Mail;

class InboxController extends Controller
{

    public function sendMail(){
        Mail::raw('Sending emails with Mailgun and Laravel is easy!', function($message)
        {
            $message->subject('Mailgun and Laravel are awesome!');
            $message->from('HelloDemo@support.com', 'HelloDemo');
            $message->to('angel8280@yandex.com');
        });
    }
    public function index()
    {
    	$user = Auth::user();
    	//var_dump(json_encode($user) );exit;
		$musics = DB::table('inboxs')
					->join('users as receiver', 'inboxs.receiver', '=', 'receiver.id')
					->join('uploads', 'inboxs.uploads_id', '=', 'uploads.id')
					->join('users as uploader', 'uploads.uploader_id', '=', 'uploader.id')
					->where('receiver.id', '=', $user->id)
					->where('inboxs.ondelete', '=', 0)
					->orderBy('inboxs.id', 'desc')
					->select('uploads.id as file_id', 'inboxs.id as in_id', 'inboxs.*','uploader.*','uploads.*')->get();
        $inbox = DB::table('inboxs')->where([['receiver',$user['id']],['ondelete',0]])->count();
        $favorite_count = DB::table('inboxs')->where([['favorite',1],['ondelete',0],['receiver',$user['id']]])->count();
		$upload_count = DB::table('uploads')->where([['uploader_id','=',$user['id']],['ondelete','=',0]])->count();
		$check_count = Inbox::where([['receiver',$user['id']],['check',0],['ondelete',0]])->count();//check : 0 => unread, 1 => read

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
//		var_dump($user_list);exit;

		return view('inbox', ['musics' => $musics, 'user' => $user,'user_list'=>$user_list, 'inbox' => $inbox, 'favorite_count'=>$favorite_count, 'upload_count'=>$upload_count,'check_count'=>$check_count,'group_info'=>$group_info ]);
    }
    public function trash()
    {
        $user = Auth::user();
        $musics = DB::table('inboxs')
                    ->join('users as receiver', 'inboxs.receiver', '=', 'receiver.id')
                    ->join('uploads', 'inboxs.uploads_id', '=', 'uploads.id')
                    ->join('users as uploader', 'uploads.uploader_id', '=', 'uploader.id')
                    ->where('receiver.id', '=', $user->id)
                    ->where('inboxs.ondelete', '=', 1)
                    ->select('uploads.id as file_id', 'uploads.*', 'uploader.*', 'inboxs.favorite', 'inboxs.filter')->orderBy('inboxs.updated_at', 'desc')->get();
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

        return view('trash', ['musics' => $musics, 'user' => $user,'user_list'=>$user_list, 'inbox' => $inbox, 'favorite_count'=>$favorite_count, 'upload_count'=>$upload_count, 'check_count'=>$check_count,'group_info'=>$group_info]);
    }
    public function favourite()
    {
    	$user = Auth::user();
        $musics = DB::table('inboxs')
            ->join('users as receiver', 'inboxs.receiver', '=', 'receiver.id')
            ->join('uploads', 'inboxs.uploads_id', '=', 'uploads.id')
            ->join('users as uploader', 'uploads.uploader_id', '=', 'uploader.id')
            ->where('receiver.id', '=', $user->id)
            ->where('inboxs.ondelete', '=', 0)
            ->select('uploads.id as file_id', 'inboxs.id as in_id', 'inboxs.*', 'uploader.*','uploads.*')->get();
		$favorites = DB::table('inboxs')
					->join('users as receiver', 'inboxs.receiver', '=', 'receiver.id')
					->join('uploads', 'inboxs.uploads_id', '=', 'uploads.id')
					->join('users as uploader', 'uploads.uploader_id', '=', 'uploader.id')
					->where('receiver.id', '=', $user->id)
					->where('inboxs.favorite', '=', 1)
                    ->where('inboxs.ondelete', '=', 0)
					->select('uploads.id as file_id', 'uploads.*', 'inboxs.id as in_id', 'inboxs.*', 'uploader.*')->get();

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

		return view('favorite', ['musics' => $musics, 'user' => $user,'user_list'=>$user_list, 'favorites' => $favorites,'inbox' => $inbox, 'favorite_count'=>$favorite_count,'upload_count'=>$upload_count, 'check_count'=>$check_count,'group_info'=>$group_info ]);
    }

    public function onFavorite($id)
    {
    	$inbox = Inbox::find($id);
    	if($inbox->favorite == 0) {
    		$inbox->favorite = 1;
            $inbox->save();
        }else{
            $inbox->favorite = 0;
            $inbox->save();
        }
    	return response()->json('Successful');
    }
    public function unFavorite($id)
    {
        $inbox = Inbox::find($id);
        if($inbox->favorite == 1) {
            $inbox->favorite = 0;
            $inbox->save();
        }
        return response()->json("Successful");
    }
    public function friends($group_id) {
     	$user = Auth::user();
		$musics = DB::table('group_musics')
                    ->join('uploads as t1', 'group_musics.upload_id', '=', 't1.id')
					->join('users', 't1.uploader_id', '=', 'users.id')
//					->join('users as uploader', 'uploads.uploader_id', '=', 'uploader.id')
//					->where('group_musics.upload_id', '=', $user->id)
					->where([['group_musics.group_id', '=', $group_id]])
					->select('t1.id as file_id', 'users.*','t1.*')->get();
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

        $group_name = DB::table('groups')->where('id',$group_id)->get();//My Group info

        $user_list = DB::table('users')->get();
        $i = 0;
        foreach($user_list as $userItem){
            $user_list[$i]->group = DB::table('group_user')->join('groups','group_user.group_id','=','groups.id')->where('group_user.user_id',$userItem->id)->get();
            $i++;
        }

        $group_user_list = DB::table('group_user')->join('users','group_user.user_id','=','users.id')->where('group_user.group_id',$group_id)->get();
//        var_dump($group_user_list);exit();
		return view('friends', ['musics' => $musics,'group_name'=>$group_name,'group_user_list'=>$group_user_list, 'user' => $user,'user_list'=>$user_list,'inbox' => $inbox, 'favorite_count'=>$favorite_count, 'upload_count'=>$upload_count, 'check_count'=>$check_count,'group_info'=>$group_info ]);
    }

    public function delete($id)
    {
        // $date = new DateTime();
        // $result = $date->format('Y-m-d H:i:s');
    	$inbox =  Inbox::where('uploads_id',$id)->update(['ondelete'=>1]);
    	echo response()->json('Successful');
    }

    public function trashDelete($id)
    {
//        $result = $date->format('Y-m-d H:i:s');
        $inbox =  DB::table('inboxs')->where('uploads_id',$id)->delete();
        echo response()->json('Successful');
    }

    public function filter($id)
    {

        $inbox =  DB::table('inboxs')->where('uploads_id',$id);
        $inbox->filter = 1;
        $inbox->save();
        echo response()->json("Successful");
    }
    
    //Angel
    public function check($id)
    {
        if(isset($id)){
            $user = Auth::user();
            Inbox::where('uploads_id',$id)->update(['check'=>1]);
            $unread = DB::table('inboxs')->where([['receiver',$user['id']],['ondelete',0],['check',0]])->count();
            echo json_encode($unread);
        }else{
            echo json_encode("no");
        }

    }

    public function search($search)
    {
        $user = Auth::user();
        $musics = DB::table('inboxs')
            ->join('users as receiver', 'inboxs.receiver', '=', 'receiver.id')
            ->join('uploads', 'inboxs.uploads_id', '=', 'uploads.id')
            ->join('users as uploader', 'uploads.uploader_id', '=', 'uploader.id')
            ->where('receiver.id', '=', $user->id)
            ->where('inboxs.ondelete', '=', 0)
            ->orWhere('uploads.title','like',$search)
            ->orWhere('uploads.file_name','like',$search)
            ->orWhere('uploads.note','like',$search)
            ->orderBy('inboxs.updated_at', 'asc')
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

        $user_list = DB::table('users')->get();
        $i = 0;
        foreach($user_list as $userItem){
            $user_list[$i]->group = DB::table('group_user')->join('groups','group_user.group_id','=','groups.id')->where('group_user.user_id',$userItem->id)->get();
            $i++;
        }
        return view('search', ['musics' => $musics, 'user' => $user, 'inbox' => $inbox,'user_list' => $user_list, 'favorite_count'=>$favorite_count, 'upload_count'=>$upload_count,'check_count'=>$check_count,'group_info'=>$group_info, 'user_list'=>$user_list, ]);
    }

    function random_color() {
        return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }



    public function add_group(Request $request){
        $user = Auth::user();
        $color = '#'.$this->random_color();
        $group_id_in_add_group = $request->input('group_id_in_add_group');
        $group_name = $request->input('group_name');
        $group_info = json_decode($request->input('group_info'));
        $val = DB::table('groups')->where([['name',$group_name],['creater',$user->id]])->get();

        $upload_info = $request->input('uploader');

        $group_num = DB::table('groups')->where('creater',$user->id)->count();
        $group_id = array();
        if(count($val) == 0 && $group_num < 10 && ($group_id_in_add_group == null && $group_id_in_add_group == "") ){
            DB::table('groups')->insert(['name' => $group_name, 'color' => $color,'creater'=>$user->id ]);
            $group_id = DB::table('groups')->where([['name',$group_name],['creater',$user->id]])->get();
//            var_dump($group_info);exit;
            if($group_info != null || count($group_info) >0 )
                foreach ($group_info as $group){
//                    if(DB::table('group_user')->where('user_id',$group)->count() == 0 )
                        DB::table('group_user')->insert(['group_id'=>$group_id[0]->id,'user_id'=>$group]);
                }
            return $this->friends($group_id[0]->id);
        }else if($group_id_in_add_group != ""){
//var_dump($group_info);exit;
            if($group_info != null || count($group_info) >0 )
                foreach ($group_info as $group){
//                    if(DB::table('group_user')->where('user_id',$group)->count() == 0 )
                        DB::table('group_user')->insert(['group_id'=>$group_id_in_add_group,'user_id'=>$group]);
                }
            if($upload_info == 0)
                    return $this->friends($group_id_in_add_group);
            else {
                $user = Auth::user();
                $contacts = DB::table('users')
                    ->join('contacts', 'users.id', '=', 'contacts.receiver')
                    ->where('contacts.sender', $user->id)
                    ->where('contacts.state', '=', '1')
                    ->select('users.*')
                    ->get();
                $musics = DB::table('inboxs')
                    ->join('users as receiver', 'inboxs.receiver', '=', 'receiver.id')
                    ->join('uploads', 'inboxs.uploads_id', '=', 'uploads.id')
                    ->join('users as uploader', 'uploads.uploader_id', '=', 'uploader.id')
                    ->where('receiver.id', '=', $user->id)
                    ->where('inboxs.ondelete', '=', 0)
                    ->select('uploads.id as file_id',  'inboxs.id as in_id', 'inboxs.*', 'uploader.*','uploads.*')->get();

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
        }else{
            if($upload_info == 0)
                return $this->index();
            else {
                $user = Auth::user();
                $contacts = DB::table('users')
                    ->join('contacts', 'users.id', '=', 'contacts.receiver')
                    ->where('contacts.sender', $user->id)
                    ->where('contacts.state', '=', '1')
                    ->select('users.*')
                    ->get();
                $musics = DB::table('inboxs')
                    ->join('users as receiver', 'inboxs.receiver', '=', 'receiver.id')
                    ->join('uploads', 'inboxs.uploads_id', '=', 'uploads.id')
                    ->join('users as uploader', 'uploads.uploader_id', '=', 'uploader.id')
                    ->where('receiver.id', '=', $user->id)
                    ->where('inboxs.ondelete', '=', 0)
                    ->select('uploads.id as file_id', 'inboxs.id as in_id', 'inboxs.*', 'uploader.*',  'uploads.*')->get();

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
        }
    }

    //Angel
    public function edit_group(Request $request){
        $group_id = $request->input('group_id');
        $group_name = $request->input('group_name');
        $group_note = $request->input('group_note');
        $group_del = $request->input('group_del');

        if($group_del != null && $group_del == "on"){
            DB::table('groups')->where('id',$group_id)->delete();
            return $this->index();
        }
        else{
            DB::table('groups')->where('id',$group_id)->update(['name'=>$group_name,'group_note'=>$group_note]);
//
            return $this->friends($group_id);
        }

    }

    public function get_message(Request $request){
        $uploader_id = $request->input('uploader_id');
        $music_id = $request->input('music_id');
       $messages = DB::table('messages')->where('music_id',$music_id)->where(function($query) use ($uploader_id){
           $query->where('user_id',$uploader_id)
               ->orWhere('receiver_id',$uploader_id);
       })->get();
        // $messages = DB::table('messages')->where([['music_id',$music_id],['receiver_id',Auth::user()['id']]])->get();
        $all_messages = array();
        foreach ($messages as $message){
            $message->user_avatar = DB::table('users')->where('id',$message->user_id)->first()->avatar;
            $message->receiver_avatar = DB::table('users')->where('id',$message->receiver_id)->first()->avatar;
            array_push($all_messages,$message);
        }
        return $all_messages;
    }
}

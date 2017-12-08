<?php

namespace App\Http\Controllers;

use App\Models\Inbox;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Passwords\CanResetPassword;

class SettingController extends Controller
{
    public function index(Request $request){
        $user = Auth::user();

        $inbox = DB::table('inboxs')->where([['receiver',$user['id']],['ondelete',0]])->count();
        $check_count = Inbox::where([['receiver',$user['id']],['check',0],['ondelete',0]])->count();
        $favorite_count = DB::table('inboxs')->where([['favorite',1],['ondelete',0],['receiver',$user['id']]])->count();
        $upload_count = DB::table('uploads')->where([['uploader_id','=',$user['id']],['ondelete','=',0]])->count();

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
        return view('setting',['user_list'=>$user_list,'check_count'=>$check_count,'favorite_count'=>$favorite_count, 'upload_count'=>$upload_count,'inbox'=>$inbox,'group_info'=>$group_info]);
    }

    public function checkOldPassword(Request $request){
        $oldPassword = $request->input('oldPassword');
        echo json_encode(Auth::attempt(array('password'=>$oldPassword)));
    }

    public function updatePassword(Request $request){
        $new_password = $request->input('newPassword');
        $user = Auth::user();
        $result = DB::table('users')->where('id',$user['id'])->update(['password'=>bcrypt('password')]);
//        echo json_encode($result);
        if($result){
            echo json_encode("success");
        }else{
            echo json_encode("error");
        }

    }

    public function addSecondEmail(Request $request){
        $user = Auth::user();
//        var_dump($user);
        $email = $request->input('email');
        DB::table('users')->where('id',$user->id)->update(['second_email'=>$email]);
        return $this->index($request);
    }
}

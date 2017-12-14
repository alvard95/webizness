<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use LRedis;
use Illuminate\Http\Request;
use App\Models\Inbox;
use App\Models\User;
use App\Models\Messages;

class ChatController extends Controller {


	public function showMessages(){


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
		$writers = [];

		$first = DB::table('messages')
			->select('user_id')
			->where('receiver_id','=',$user->id)
			->where('user_id','!=',$user->id)
		;

		$users = DB::table('messages')
			->union($first)
			->select('receiver_id')
			->where('user_id','=',$user->id)
			->where('receiver_id','!=', $user->id)
			->get();

		foreach ($users as $value){
			$user = User::find($value->receiver_id);

			$user_message = DB::table( 'users' )
				->select( 'users.*' , 'messages.id as msg_id' , 'messages.message' )
		        ->join( 'messages', function ( $join ) {
		            $join
		            	->on( 'users.id', '=', 'messages.user_id' )
		            	->orOn( 'users.id', '=', 'messages.receiver_id' );
		        })
		        ->where('users.id', $value->receiver_id)
		        ->orderBy('messages.id', 'desc')
		        ->first(); 

			array_push($writers,$user_message);
		}

		$data = [
			'user_list'=>$user_list,
			'check_count'=>$check_count,
			'favorite_count'=>$favorite_count,
			'upload_count'=>$upload_count,
			'inbox'=>$inbox,
			'messages'=>$writers,
			'group_info'=>$group_info
		];
		return view('messages', $data);
	}



	public function showMsg(Request $request){
		$to_user = $request['to_user'];

        $twoMessages = Messages::select('*')
            ->leftJoin('users', function ($join) use($to_user) {
                $join->on('messages.user_id', '=', 'users.id');
            })
            ->leftJoin('uploads', function ($join) use($to_user) {
                $join->on('messages.music_id', '=', 'uploads.id');
            })
            ->where('messages.receiver_id','=',$to_user)
            ->where('messages.user_id','=',Auth::id())
            ->orWhere('messages.receiver_id','=',Auth::id())
            ->where('messages.user_id', '=', $to_user)
            ->get();

        $recerver_user = User::find($to_user);

		return response()->json([
			'auth_id' => Auth::id(),
			'recerver_user' => $recerver_user,
		    'twoMessages' => $twoMessages
		]);
	}

    public function sendMessage(){
        $auth = Auth::user();
//        var_dump($auth);exit;
        $redis = LRedis::connection();
        $user = Request::input('user');

        $msg = Request::input('message');
        $music = Request::input('music');
        $data = ['message' => $msg, 'user' => $auth, 'music'=>$music];

        DB::table('messages')->insert(['user_id'=>$auth["id"],'receiver_id'=>$user,'message'=>$msg,'music_id'=>$music]);
//        $user = DB::table('users')->where('id',$user)->first();
//        echo json_encode( $data);
//        var_dump($auth["id"]);exit;
        $redis->publish('message', json_encode($data));
        return response()->json([]);
    }
}
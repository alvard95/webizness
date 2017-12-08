<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Request;
use LRedis;


class ChatController extends Controller {

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
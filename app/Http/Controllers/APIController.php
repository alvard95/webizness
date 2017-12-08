<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Inbox;
use App\Models\APILog;
use App\Models\User;
use App\Models\Upload;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Input;

class APIController extends Controller {
    public function __construct(Request $request){
//        $fp = fopen('upload/data.txt', 'w');
//        fwrite($fp, json_encode($_SERVER));
//        fwrite($fp, json_encode($_FILES));
//        fwrite($fp, json_encode($_REQUEST));
//        fclose($fp);
//        var_dump("test");exit;
        $this->token = $request->get('token', '');
        $this->user_model = new User();
        $this->upload_model = new Upload();
//        $this->uploads_model = new Uploads();
        $this->inbox_model = new Inbox();
//        $this->log_model = new APILog();

        $this->data = array(
            'error' => false
        );

    }

    //common
    private function _JsonOutput(){
        header("access-control-allow-origin: *");
        header('Content-Type: application/json');
        echo json_encode($this->data);
        exit;
    }

    private function generateToken() {
        return md5(uniqid(rand(), true));
    }

    public function updateDeviceToken(Request $request,$user_id){
        if($request->input('io_token', false)){
            IoToken::updateToken($user_id, $request->input('io_token'));
        }
        if($request->input('android_token', false)){
            AndroidToken::updateToken($user_id, $request->input('android_token'));
        }
    }

    public function uploadImage() {

        $file = array(
            'image'=> Input::file('image')
        );

        $rules = array(
            'image'=>'required'
        );

        $validator = Validator::make($file, $rules);

        if($validator->fails()) {
            $messages = $validator->messages();
            $error_messages = $messages->all();

            return null;
        }
        else {
            $url = $this->upload_model->image_upload($file['image']);

            return $url;

        }
    }

    public function generatePasscode() {
        $code = "";
        for ($i=0; $i < 6; $i++) {
            $code = $code.rand(0, 9);
        }
        return $code;
    }


    /*
    * User
    */

    //---register---
    public function postRegister(Request $request){
        $user = array(
            'firstname' => $request->input('firstname', ''),
            'lastname' => $request->input('lastname', ''),
            'username' => $request->input('username', ''),
            'email' => $request->input('email', ''),
            'password' => $request->input('password', ''),
            'create_at' => date('Y-m-d H:i:s'),
            'remember_token' => $this->generateToken(),
            'verify_code' => $this->generatePasscode(),
        );

        $rules = array(
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
            $messages = $validator->messages();
            $this->data = array(
                'error' => true,
                'error_code' => 1,
                'message' => implode("\n", $messages->all()),
            );
        }else{

            $db_user = User::where('email', $request->input('email'))
                ->first();

            if($db_user){
                $res = EMAIL_ALREADY_EXISTED;
            }else{
                // $user['image'] = $this->uploadImage();
                $user['password'] = bcrypt($user['password']);

                $user_id = $this->user_model->addUser($user);

                if($user_id){
                    $res = USER_CREATED_SUCCESSFULLY;
                }else{
                    $res = USER_CREATE_FAILED;
                }
            }

            if ($res == USER_CREATED_SUCCESSFULLY) {
                $this->data["error"] = false;
                $this->data["data"] = User::where('email', $request->input('email'))->first()->toArray();
                unset($this->data['user']['password']);

                $this->updateDeviceToken($request,$user_id);

                $this->data["message"] = "You are successfully registered";
            } else if ($res == USER_CREATE_FAILED) {
                $this->data["error"] = true;
                $this->data["error_code"] = 2;
                $this->data["message"] = "Oops! An error occurred while registering";
            } else if ($res == EMAIL_ALREADY_EXISTED) {
                $this->data["error"] = true;
                $this->data["error_code"] = 3;
                $this->data["message"] = "Sorry, this email already existed";
            }

        }
        $this->_JsonOutput();
    }

    //---update profile
    public function postUpdateProfile(Request $request){
        $this->checkToken();
        $this->log_model->log_d("postUpdateProfile", Input::all());

        $user = array(
            'user_id' => $request->input('user_id', ''),
            'firstname' => $request->input('firstname', ''),
            'lastname' => $request->input('lastname', ''),
            'email' => $request->input('email', ''),
            'updated_at' => date('Y-m-d H:i:s'),
        );

        $rules = array(
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
            $messages = $validator->messages();
            $this->data = array(
                'error' => true,
                'error_code' => 1,
                'message' => implode("\n", $messages->all()),
            );
        }else{

            $user['image'] = $this->uploadImage();
            $updated_user = $this->user_model->updateUser($user);

            if($updated_user){
                $res = USER_UPDATED_SUCCESSFULLY;
            }else{
                $res = USER_UPDATED_FAILED;
            }

            if ($res == USER_UPDATED_SUCCESSFULLY) {
                $db_user = User::where('id', $request->input('user_id'))
                    ->first();
                if ($db_user['image'])
                    $db_user['image'] = url('/')."/upload".$db_user['image'];

                $this->data["error"] = false;
                $this->data["data"] = $db_user;
                $this->data["message"] = "You are successfully updated";
            } else if ($res == USER_UPDATED_FAILED) {
                $this->data["error"] = true;
                $this->data["error_code"] = 2;
                $this->data["message"] = "Oops! An error occurred while updating";
            } else if ($res == USER_NOT_REGISTERED) {
                $this->data["error"] = true;
                $this->data["error_code"] = 3;
                $this->data["message"] = "Sorry, you are not registered user";
            } else if ($res == EXPIRED_TOKEN) {
                $this->data['error'] = true;
                $this->data['error_code'] = 4;
                $this->data['message'] = "Your credential was expired";
            }

        }
        $this->_JsonOutput();
    }

    //---login---
    public function postLogin(Request $request){

        $rules = array(
            'email' => 'required',
            'password' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            $messages = $validator->messages();
            $this->data = array(
                'error' => true,
                'error_code'=>'1',
                'message' => $messages->all(),
            );
//            echo json_encode("test");exit;
        }else{

            $db_user = $this->user_model->getUserByEmail($request->input('email'));
//            $user_id = $this->user_model->getUserByUserid();
//            var_dump($db_user);exit;
            if($db_user) {
                if ($db_user['password'] == password_hash($request->input('password'), PASSWORD_BCRYPT)) {
                    $this->data["error"] = false;
                    $this->data["data"] = $db_user;
                    $this->user_model->where('id',$db_user['id'])->update(["ios_token" => $request->input("ios_token")]);
                    $this->updateDeviceToken($db_user['id']);

                }
                else if (Auth::attempt(['email'=> $request->input('email'),'password'=>$request->input('password')])) {
                    $this->data["error"] = false;
                    $this->data["data"] = $db_user;
                    $this->user_model->where('id',$db_user['id'])->update(["ios_token" => $request->input("ios_token")]);
                    $this->updateDeviceToken($request,$db_user['id']);

                }
                else{
                    $this->data['error'] = true;
                    $this->data['error_code'] = 2;
                    $this->data['message'] = "Email or Password is incorrect";
                }
            }else{
                $this->data['error'] = true;
                $this->data['error_code'] = 3;
                $this->data['message'] = "Email or Password is incorrect";
            }
        }
        $this->_JsonOutput();
    }

    //---login with social (facebook, google+, linkedin)---
    public function postSclogin(Request $request){
        $user = array(
            'email' => $request->input('email', ''),
            'firstname' => $request->input('firstname', ''),
            'lastname' => $request->input('lastname', ''),
            'phone' => $request->input('phone', ''),
            'image' => $request->input('image', ''),
            'remember_token' => $this->generateToken(),
        );

        $rules = array(
            'email' => 'required|email',
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
            $messages = $validator->messages();
            $this->data = array(
                'error' => true,
                'error_code' => 1,
                'message' => implode("\n", $messages->all()),
            );
        }else{
            $db_user = User::where('email', $request->input('email'))
                ->first();

            /**
             * normal register
             */
            if($db_user){
                $res = EMAIL_ALREADY_EXISTED;
            }else{

                $user_id = $this->user_model->addUser($user);
                if($user_id){
                    $res = USER_CREATED_SUCCESSFULLY;
                }else{
                    $res = USER_CREATE_FAILED;
                }

            }
            $this->log_model->log_d("postSclogin", $res);

            if ($res == USER_CREATED_SUCCESSFULLY) {
                $this->data["error"] = false;
                $this->data["data"] = $this->user_model->getUserByEmail($user['email']);

                $this->updateDeviceToken($this->data["data"]['id']);

                $this->data["message"] = "You are successfully registered";
            } else if ($res == USER_CREATE_FAILED) {
                $this->data["error"] = true;
                $this->data["error_code"] = 2;
                $this->data["message"] = "Oops! An error occurred while registering";
            } else if ($res == EMAIL_ALREADY_EXISTED) {
                $this->data["error"] = false;
                $user = $this->user_model->getUserByEmail($user['email']);

                $this->data["data"] = $user;

                $this->updateDeviceToken($this->data["data"]['id']);
                $this->data["message"] = "Sorry, this email already existed";

            }

        }
        $this->_JsonOutput();
    }


    //---forgot password---
    public function postForgotpassword(Request $request){
        $rules = array(
            'email' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
            $messages = $validator->messages();
            $this->data = array(
                'error' => true,
                'error_code' => 1,
                'message' => $messages->all(),
            );
            $this->_JsonOutput();
        }

        $result = $this->user_model->forgotPassword($request->input('email'), $request->input('security_question'), $request->input('security_answer'));
        if($result['error'] === true){
            $this->data = array(
                'error' => true,
                'error_code' => 2,
                'message' => $result['message'],
            );
        }else{
            $link = URL::to('reset-password/'.$result['message']);
            $from = "admin@admin.com";
            $params = array(
                'email' => $result['email'],
                'subject' => "Forgot password",
                'message' => "Please reset your password at this link, {$link}",
                'headers' => 'From: '.$from . "\r\n" .
                    'Reply-To: '.$from . "\r\n" .
                    'X-Mailer: PHP/' . phpversion()
            );
            $result = @mail($params['email'], $params['subject'], $params['message'], $params['headers']);

            $this->log_model->log_d("postForgotpassword", $result);
            $this->data['message'] = "Sent link to your email. Please check!";
        }

        $this->_JsonOutput();

    }

    //---login---
    public function postPhoneVerify(Request $request){
        $rules = array(
            'user_id' => 'required',
            'verify_code' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
            $messages = $validator->messages();
            $this->data = array(
                'error' => true,
                'error_code'=>'1',
                'message' => $messages->all(),
            );
        }else{
            $db_user = $this->user_model->checkPhoneVerify($request->input('user_id'), $request->input('verify_code'));

            if($db_user) {
                if ($db_user['image'])
                    $db_user['image'] = url('/')."/upload".$db_user['image'];

                $this->data["error"] = false;
                $this->data['data'] = $db_user;
            }else{
                $this->data['error'] = true;
                $this->data['error_code'] = 2;
                $this->data['message'] = "Invalid verification code";
            }
        }
        $this->_JsonOutput();
    }

    public function postAddPromoCode(Request $request){
        $this->checkToken();

        $rules = array(
            'user_id' => 'required',
            'promo_code' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
            $messages = $validator->messages();
            $this->data = array(
                'error' => true,
                'error_code'=>'1',
                'message' => $messages->all(),
            );
        }else{
            $db_user = $this->user_model->addPromoCode($request->input('user_id'), $request->input('promo_code'));

            if($db_user) {
                if ($db_user['image'])
                    $db_user['image'] = url('/')."/upload".$db_user['image'];

                $this->data["error"] = false;
                $this->data['data'] = $db_user;
            }else{
                $this->data['error'] = true;
                $this->data['error_code'] = 2;
                $this->data['message'] = "Invalid verification code";
            }
        }
        $this->_JsonOutput();
    }

    public function postSendPhone(Request $request){
        $this->checkToken();

        $user = array(
            'user_id' => $request->input('user_id', ''),
            'phone' => $request->input('phone', ''),
            'verify_code' => $this->generatePasscode(),
        );

        $rules = array(
            'phone' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
            $messages = $validator->messages();
            $this->data = array(
                'error' => true,
                'error_code'=>'1',
                'message' => $messages->all(),
            );
        }else{
            $db_user = $this->user_model->updatePasscode($user['user_id'], $user['verify_code']);
            if($db_user) {
                $this->sendSMS($user['phone'], $user['verify_code']);
                $this->data["error"] = false;

            }else{
                $this->data['error'] = true;
                $this->data['error_code'] = 2;
                $this->data['message'] = "The Phone number is already exist";
            }
        }
        $this->_JsonOutput();
    }

    public function postVerifyPhoneUpdate(Request $request){
        $this->checkToken();
        $rules = array(
            'phone' => 'required',
            'verify_code' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
            $messages = $validator->messages();
            $this->data = array(
                'error' => true,
                'error_code'=>'1',
                'message' => $messages->all(),
            );
        }else{
            $db_user = $this->user_model->updatePhone($request->input('user_id'), $request->input('verify_code'), $request->input('phone'));

            if($db_user) {
                if ($db_user['image'])
                    $db_user['image'] = url('/')."/upload".$db_user['image'];

                $this->data["error"] = false;
                $this->data['data'] = $db_user;
            }else{
                $this->data['error'] = true;
                $this->data['error_code'] = 2;
                $this->data['message'] = "Invalid verification code";
            }
        }
        $this->_JsonOutput();
    }

    public function checkToken(Request $request) {
        $rules = array(
            'user_id' => 'required',
            'token' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
            $messages = $validator->messages();
            $this->data = array(
                'error' => true,
                'error_code'=>'1',
                'message' => $messages->all(),
            );
            $this->_JsonOutput();
        }else{
            $db_user = User::where('id', $request->input('user_id'))->first();

            if ($db_user['remember_token'] != $request->input('token')) {
                $res = EXPIRED_TOKEN;
                $this->data['error'] = true;
                $this->data['error_code'] = 3;
                $this->data['message'] = "Your credential was expired";

                $this->_JsonOutput();
            }
        }
    }

    public function postSendsms(Request $request){
        $sid = 'ACe95847f83af2e53d7401247ce804bf3c';
        $token = '39f8bf7f4cdcc542cebdea32088d783f';
        $client = new Twilio\Rest\Client($sid, $token);

        // Use the client to do fun stuff like send text messages!
        $client->account->messages->create(
        // the number you'd like to send the message to
            '+13078000356',
            array(
                // A Twilio phone number you purchased at twilio.com/console
                'from' => '+17083406992',
                // the body of the text message you'd like to send
                'body' => 'Hey Jenny! Good luck on the bar exam!'
            )
        );
    }



    /*
    *   Uploads
    */
    public function postGetUploads(Request $request){
        // $this->checkToken();
        $rules = array(
            'user_id' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            $messages = $validator->messages();
            $this->data = array(
                'error' => true,
                'error_code'=>'1',
                'message' => $messages->all(),
            );
        }else{
            $hotels= $this->upload_model->getUploads($request->input('user_id'));

            if($hotels) {
                $this->data["error"] = false;
                $this->data['data'] = $hotels;
            }else{
                $this->data['error'] = true;
                $this->data['error_code'] = 2;
                $this->data['message'] = "There's no uploads";
            }

        }
        $this->_JsonOutput();
    }

    /*
    *   Inbox
    */
    public function postGetInbox(Request $request){
        // $this->checkToken();
        $rules = array(
            'user_id' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
            $messages = $validator->messages();
            $this->data = array(
                'error' => true,
                'error_code'=>'1',
                'message' => $messages->all(),
            );
        }else{
            $hotels= $this->inbox_model->getInbox($request->input('user_id'));

            if($hotels) {
                $this->data["error"] = false;
                $this->data['data'] = $hotels;
            }else{
                $this->data['error'] = true;
                $this->data['error_code'] = 2;
                $this->data['message'] = "There's no uploads";
            }

        }
        $this->_JsonOutput();
    }

    //Angel
    public function postGetMenu(Request $request){
        $user_id = $request->input('user_id');
        //group_list, upload, demo number
        $demo_num = $this->inbox_model->where([['ondelete',0],['check',0],['receiver',$user_id]])->count();
        $inbox_num = $this->inbox_model->where([['ondelete',0],['receiver',$user_id]])->count();
        $upload_num = $this->upload_model->where([['uploader_id',$user_id],['ondelete',0]])->count();
        $favorite_num = $this->inbox_model->where([['ondelete',0],['receiver',$user_id],['favorite',1]])->count();

        $groups = DB::table('groups')->where([['creater',$user_id]])->get();
        $group_list = array();
        foreach ($groups as $group){
            $val = DB::table('group_musics')->where([['group_id',$group->id]])->count();
            $group->music_num = $val;
            array_push($group_list, $group);
        }

        $this->data['error'] = false;
        $this->data['data'] = ['demo_num'=>$demo_num, 'inbox_num'=>$inbox_num, 'upload_num' =>$upload_num, 'favorite_num'=>$favorite_num, 'group_list'=>$group_list ];
        $this->_JsonOutput();
//        var_dump($inbox_num);exit;
    }

    public function postGetFavourite(Request $request){
        // $this->checkToken();
        $rules = array(
            'user_id' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            $messages = $validator->messages();
            $this->data = array(
                'error' => true,
                'error_code'=>'1',
                'message' => $messages->all(),
            );
        }else{
            $hotels= $this->inbox_model->getFavourites($request->input('user_id'));

            if($hotels) {
                $this->data["error"] = false;
                $this->data['data'] = $hotels;
            }else{
                $this->data['error'] = true;
                $this->data['error_code'] = 2;
                $this->data['message'] = "There's no uploads";
            }

        }
        $this->_JsonOutput();
    }

    public function postRemoveMusic(Request $request){
        $user_id = $request->input('user_id');
        $type = $request->input('type');
        $music_id = $request->input('music_id');
        switch ($type){
            case "uploads":
                $upload = Upload::find($music_id);
                $upload->ondelete = 1;
                $upload->save();
                $this->postGetUploads($request);
                break;
            case "inbox":
                DB::table('inboxs')->where([['id',$music_id],['receiver',$user_id]])->update(['ondelete'=>1]);
                $this->postGetInbox($request);
                break;
            case "favourite":
                DB::table('inboxs')->where([['id',$music_id],['receiver',$user_id]])->update(['ondelete'=>1]);
                $this->postGetFavourite($request);
                break;
            default:
                $this->data['error'] = true;
                $this->data['error_code'] = 2;
                $this->data['message'] = "There's no uploads";
                $this->_JsonOutput();
                break;
        }

    }

    public function postGetGroupMusic(Request $request){
//        $user_id = $request->input('user_id');
        $group_id = $request->input('group_id');

            $uploads= DB::table('group_musics'.' as t3')
                ->join("uploads as t1","t3.upload_id","=","t1.id")
                ->join("users as t2", "t1.uploader_id", "=", "t2.id")
                ->where([['t3.group_id',$group_id]])
                ->select('t1.*', 't2.first_name', 't2.last_name', 't2.avatar')
                ->orderBy('created_at', 'desc')
                ->get();
//            var_dump($uploads);exit;
            foreach ($uploads as $key => &$upload) {
                if ($upload->avatar) {
                    $upload->avatar = url('/')."/assets/images/icons/".$upload->avatar;
                }
                // $upload->music_url = url('/')."/uploads/".$upload->file_name;
                $upload->music_url = url('/')."/uploads/".$upload->file_name;
                $upload->artist = $upload->first_name . " " . $upload->last_name;
            }




//            $hotels= $this->inbox_model->getInbox($request->input('user_id'));

            if($uploads) {
                $this->data["error"] = false;
                $this->data['data'] = $uploads;
            }else{
                $this->data['error'] = true;
                $this->data['error_code'] = 2;
                $this->data['message'] = "There's no uploads";
            }


        $this->_JsonOutput();
    }

    public function postSetFavorite(Request $request){
        $id = $request->input('inbox_id');
//        $music_id = $request->input('favorite_id');
        $result = DB::table('inboxs')->where('id',$id)->first();
        $final_result = 0;
        if($result->favorite == 1){
            DB::table('inboxs')->where('id',$id)->update(['favorite'=>0]);
        }else{
            DB::table('inboxs')->where('id',$id)->update(['favorite'=>1]);
            $final_result = 1;
        }
        $this->data['result'] = $final_result;
        $this->_JsonOutput();
    }


}

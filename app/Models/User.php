<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'username', 'email', 'password', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    /**
     * The database table used by the model.
     *
     * @var string
     */

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }
    public function getReminderEmail()
    {
        return $this->email;
    }
    public function updateProfile($email, $phone, $password) {
        
    }

    public function getUsers(){
        $users = DB::table($this->table)
            ->get();
        return $users;
    }

    //Add New User
    public function addUser($user){
        DB::table($this->table)->insert(
            $user
        );
        $user_id = DB::getPdo()->lastInsertId();
        return $user_id;
    }

    //Get an User By Email
    public function getUserByEmail($email){
        $query = DB::table($this->table)
            ->where('email', $email);

        $user = $query->first();

        return (array) $user;
    }

    //Get an User By User ID
    public function getUserByUserid($user_id){
        $query = DB::table($this->table)
            ->where('id', $user_id);

        $user = $query->first();

        return (array) $user;
    }

    //Get an User By Phone Number
    public function getUserByPhone($phone, $verify_code, $token){
        DB::table($this->table)
            ->where('phone', $phone)
            ->update(
                array('verify_code' => $verify_code,
                    'remember_token' => $token)
            );

        $query = DB::table($this->table)
            ->where('phone', $phone);

        $user = $query->first();

        return (array) $user;
    }

    //Phone Verify
    public function checkPhoneVerify($user_id, $verify_code){
        $query = DB::table($this->table)
            ->where('id', $user_id)
            ->where('verify_code', $verify_code);

        $user = $query->first();

        if ($user) {
            DB::table($this->table)
                ->where('id', $user_id)
                ->update(
                    array('verify' => 1)
                );
        }

        return (array) $user;

    }

    public function updatePasscode($user_id, $verify_code){

        $res = DB::table($this->table)
            ->where('id', $user_id)
            ->update(
                array(
                    'verify_code' => $verify_code,
                )
            );

        return $res;

    }

    public function updatePhone($user_id, $verify_code, $phone){
        $query = DB::table($this->table)
            ->where('id', $user_id)
            ->where('verify_code', $verify_code);

        $user = $query->first();

        if ($user) {
            DB::table($this->table)
                ->where('id', $user_id)
                ->update(
                    array(
                        'verify' => 1,
                        'phone' => $phone
                    )
                );
        }

        return (array) $user;

    }

    //Add New User
    public function addPromoCode($user_id, $promo_code) {
        DB::table($this->table)->insert(
            array('user_id'=>$user_id, 'promo_code'=>$promo_code)
        );
        $user_id = DB::getPdo()->lastInsertId();
        return $user_id;
    }

    public function updateUser($user){

        $user_id = $user['user_id'];
        unset($user['user_id']);

        $res = DB::table($this->table)
            ->where('id', $user_id)
            ->update(
                $user
            );

        return $res;
    }

    public function updateProfileImage($image_url, $user_id){
        $result = DB::table($this->table)
            ->where('id', $user_id)
            ->update([
                'image'=>$image_url
            ]);

        return $result;
    }




    public function forgotPassword($email){
        $user = User::where('email', $email)
            ->first();
        $result = array('error' => false);
        if(!$user){
            $result['error'] = true;
            $result['message'] = 'Invalid user.';
        }else{
            $forgotToken = md5($this->microtime_float().$email);
            User::where('id', $user->id)
                ->update(
                    array(
                        'forgot_token' => $forgotToken
                    )
                );
            $result['message'] = $forgotToken;
            $result['email'] = $user->email;
        }
        return $result;
    }

    function microtime_float() {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Support\Facades\DB;

class Upload extends Model
{
    protected $table="uploads";
    protected $fillable=['id','uploader_id', 'title', 'file_name', 'release', 'label', 'date', 'file_type', 'master', 'headroom', 'bit', 'size', 'display', 'note'];

    public function getUploads($user_id) {

        $uploads= DB::table($this->table.' as t1')
            ->join("users as t2", "t1.uploader_id", "=", "t2.id")
            ->where([['t1.uploader_id', $user_id],['t1.ondelete',0]])
            ->select('t1.*', 't2.first_name', 't2.last_name', 't2.avatar')
            ->orderBy('created_at', 'desc')
            ->get();
        foreach ($uploads as $key => &$upload) {
            if ($upload->avatar) {
                $upload->avatar = url('/')."/assets/images/icons/".$upload->avatar;
            }
            // $upload->music_url = url('/')."/uploads/".$upload->file_name;
            $upload->music_url = url('/')."/uploads/".$upload->file_name;
            $upload->artist = $upload->first_name . " " . $upload->last_name;
        }
        return $uploads;
    }

    public function getHotelInfobyID($hotel_id) {

        $hotel_info = DB::table($this->table)
            ->where('id', $hotel_id)
            ->get();
        return $hotel_info;
    }
}

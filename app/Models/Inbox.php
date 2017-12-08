<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Support\Facades\DB;

class Inbox extends Model
{
    protected $table="inboxs";
    public function getInbox($user_id) {

        $uploads= DB::table($this->table.' as t1')
            ->join("uploads as t3", "t3.id", "=", "t1.uploads_id")
            ->join("users as t2", "t3.uploader_id", "=", "t2.id")
            ->where([['t1.receiver', $user_id],['t1.ondelete',0]])
            ->select('t1.*', 't2.first_name', 't2.last_name', 't2.avatar', 't3.title', 't3.file_name')
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

    public function getFavourites($user_id) {

        $uploads= DB::table($this->table.' as t1')
            ->join("uploads as t3", "t3.id", "=", "t1.uploads_id")
            ->join("users as t2", "t3.uploader_id", "=", "t2.id")
            ->where([['t1.receiver', $user_id],['t1.ondelete',0]])
            ->where('t1.favorite', 1)
            ->select('t1.*', 't2.first_name', 't2.last_name', 't2.avatar', 't3.title', 't3.file_name')
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($uploads as $key => &$upload) {
            if ($upload->avatar) {
                $upload->avatar = url('/')."/assets/images/icons/".$upload->avatar;
            }
            // $upload->music_url = url('/')."/uploads/".$upload->file_name;
            $upload->music_url = "http://test.hello-demo.com/uploads/".$upload->file_name;
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

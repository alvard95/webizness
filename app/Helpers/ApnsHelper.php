<?php
namespace App\Helpers;


class ApnsHelper
{
    public static function apns_send($tokens=array(),$development=true,$message=array(),$custom_data=array()){
        $badge=1;
        $sound='default';
        $custom_data = array("sender"=>"Angel");
        $apns_url = NULL;
        $apns_cert = NULL;
        $apns_port = 2195;

        if($development)
        {
            $apns_url = 'gateway.sandbox.push.apple.com';
            $apns_cert = env('PUSH_DEVELOPMENT_KEY');
        }
        else
        {
            $apns_url = 'gateway.push.apple.com';
            $apns_cert = env('PUSH_DEVELOPMENT_KEY');
        }

        $stream_context = stream_context_create();
        stream_context_set_option($stream_context, 'ssl', 'local_cert', $apns_cert);
        //stream_context_set_option($stream_context, 'ssl', 'passphrase', $pass);

        $apns = stream_socket_client('ssl://' . $apns_url . ':' . $apns_port, $error, $error_string, 300, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $stream_context);

        if($error) {
            //log_message('debug', "APN: Maybe some errors: $error: $error_string");
            print("APN: Maybe some errors: $error: $error_string");
        }

        if (!$apns) {

            if ($error) {
                //log_message('debug', "APN Failed". 'ssl://' . $apns_url . ':' . $apns_port. " to connect: $error $error_string");
                print("APN Failed". 'ssl://' . $apns_url . ':' . $apns_port. " to connect: $error $error_string");
            }
            else {
                //log_message('debug', "APN Failed to connect: Something wrong with context");
                print("APN Failed to connect: Something wrong with context");
            }

            return false;
        }
        else {
            //log_message('debug', "APN: Opening connection to: {ssl://" . $apns_url . ":" . $apns_port. "}");
            print("APN: Opening connection to: {ssl://" . $apns_url . ":" . $apns_port. "}");

            //  You will need to put your device tokens into the $device_tokens array yourself
            if(!empty($tokens)){
                // foreach($tokens as $device_token)
                for($i=0;$i<count($tokens);$i++)
                {

                    $payload = array();
                    $payload['aps'] = array('alert' => $message[$i], 'badge' => intval($badge),'badgeCount' => intval($badge), 'content-available' => 1, 'sound' => $sound);

                    $payload['custom'] = $custom_data;
                    $payload = json_encode($payload);

                    $apns_message = chr(0) . chr(0) . chr(32) . pack('H*', str_replace(' ', '', $tokens[$i])) . chr(0) . chr(strlen($payload)) . $payload;
                    $result = fwrite($apns, $apns_message, strlen($apns_message));
                }
            }
            //@socket_close($apns);
            @fclose($apns);
        }
    }
}
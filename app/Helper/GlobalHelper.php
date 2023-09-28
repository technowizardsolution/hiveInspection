<?php
namespace App\Helper;

use App\Jobs\PasswordResetFrequencyJob;
use App\Permission;
use App\User;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Twilio;
use URL;
use App\Notifications\PasswordResetFrequency;

class GlobalHelper
{
    /**
     * Developed By : Krunal
     * Date         :
     * Description  : Time ago
     */
    public static function humanTiming($time)
    {
        $time = time() - strtotime($time); // to get the time since that moment
        $time = ($time < 1) ? 1 : $time;
        $tokens = array(
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second',
        );

        foreach ($tokens as $unit => $text) {
            if ($time < $unit) {
                continue;
            }

            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '');
        }
    }

    /**
     * Developed By : Kaushal Adhiya
     * Date         : 19-11-2019
     * Description  : removeNull
     */
    public static function removeNull($array)
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key] = GlobalHelper::removeNull($value);
            } else {
                if (is_null($value)) {
                    $array[$key] = "";
                }

            }
        }
        return $array;
    }

    public static function removeNullMultiArray($model)
    {
        foreach ($model as $rsKey => $rs) {
            foreach ($rs as $key => $value) {
                if (is_null($value)) {
                    $model[$rsKey][$key] = "";
                }
            }
        }
        return $model;
    }

    /**
     * Developed By : Ajarudin Gugna
     * Date         :
     * Description  : Get formated date
     */
    public static function getFormattedDate($date)
    {
        if (!empty($date)) {
            $date = date_create($date);
            return date_format($date, "d-M-Y");
        } else {
            return "";
        }
    }

    /**
     * Developed By : Ajarudin Gugna
     * Date         :
     * Description  : Get user by id
     */
    public static function getUserById($id)
    {
        $user = User::where('id', '=', $id)
            ->first();
        return $user;
    }

    /**
     * Developed By : Krunal
     * Date         : 25-8-17
     * Description  : generateRandomNumber
     */
    public static function generateRandomNumber($length = 10)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Developed By : Jignasa
     * Date         :
     * Description  : sentence teaser
     * this function will cut the string by how many words you want
     */
    public static function word_teaser($string, $count)
    {
        $original_string = $string;
        $words = explode(' ', $original_string);

        if (count($words) > $count) {
            $words = array_slice($words, 0, $count);
            $string = implode(' ', $words);
        }

        return $string . '...';
    }

    /**
     * Developed By : Jignasa
     * Date         :
     * Description  : Get user profile image by id
     */
    public static function getUserImageById($id)
    {
        $user = User::select('profile_picture')->where('id', '=', $id)->first();
        if ($user && $user->profile_picture) {
            return URL::asset('/resources/uploads/profile') . '/' . $user->profile_picture;
        } else {
            return URL::asset('/resources/uploads/profile/default.jpg');
        }
    }

    /**
     * Description  : Use to convert large positive numbers in to short form like 1K+, 100K+, 199K+, 1M+, 10M+, 1B+ etc
     */
    public static function number_format_short($n)
    {

        if ($n >= 0 && $n < 1000) {
            // 1 - 999
            $n_format = floor($n);
            $suffix = '';
        } else if ($n >= 1000 && $n < 10000) {
            // 1k-999k
            $n_format = floor($n);
            $suffix = '';
        } else if ($n >= 10000 && $n < 1000000) {
            // 1k-999k
            $n_format = floor($n / 1000);
            $suffix = 'K+';
        } else if ($n >= 1000000 && $n < 1000000000) {
            // 1m-999m
            $n_format = floor($n / 1000000);
            $suffix = 'M+';
        } else if ($n >= 1000000000 && $n < 1000000000000) {
            // 1b-999b
            $n_format = floor($n / 1000000000);
            $suffix = 'B+';
        } else if ($n >= 1000000000000) {
            // 1t+
            $n_format = floor($n / 1000000000000);
            $suffix = 'T+';
        }

        return !empty($n_format . $suffix) ? $n_format . $suffix : 0;
    }

    /**
     * Developed By :
     * Date         :
     * Description  : Send FCM For android
     */
    public static function sendFCM($title, $message, $target = 0)
    {

        //$baseurl="http://".url();
        //FCM api URL
        $url = 'https://fcm.googleapis.com/fcm/send';
        //api_key available in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
        // $server_key = 'AAAA_76mKPk:APA91bHTGei6hpJBwQtjJaI3oUyhhmyOAQ593Qt3TVAhxbQ7oFNqW0phUFkG2JcX8MBvUOZe61oilBgVV-tCXuceUoHOqmdhbkMEA9z7hkF9iSfzWp_r64HRkySsKYu3mq0JGOr5uQLY';
        $server_key = 'AAAADnI9Pd4:APA91bHkrmP7xFttGicYyfssPHzU7NhoktuDUWbK3GJvdjUZbb8jlSwKo-KbJ1j76r7MnNO8_mO9a-0n6J9LPbYCS8x6atBxgaZTo8DZ7nkVusxk_8KTOETMBDXzKvz4PJZN_qnHp9uV';

        // if ($device_type == 1) { //need this field fro android
            $fields['notification'] = array();
            $fields['notification']['body'] = $message;
            $fields['notification']['title'] = $title;
            $fields['notification']['click_action'] = '.MainActivity';
            $fields['notification']['sound'] = 'default';
        // } else {
            $fields = array();
            $fields['data'] = array();
            $fields['data']['body'] = $message;
            $fields['data']['title'] = $title;
            $fields['data']['click_action'] = '.MainActivity';
            $fields['data']['sound'] = 'default';
        // }
        $fields['to'] = $target;
        $fields['content_available'] = true;
        $fields['priority'] = "high";

        $headers = array(
            'Content-Type:application/json',
            'Authorization:key=' . $server_key,
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === false) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }

    /**
     * Developed By :
     * Date         :
     * Description  : Send GCM for iphone
     */
    public static function sendGCM($title, $message, $deviceToken, $app_type, $notification_type, $detail)
    {

        // Put your device token here (without spaces):
        // $title = 'Hello';
        // $app_type = 'debug';
        // $deviceToken = '243540a20a1d934f7cd0fac714a45f9173eca6dfda978d116d14a7250d04f004';

        // Put your private key's passphrase here:
        $passphrase = '';

        // Put your alert message here:
        // $message = 'My cQpon push notification!';

        // $ctx = stream_context_create();
        // stream_context_set_option($ctx, 'ssl', 'local_cert', 'tys_debug_Push_certificate.pem');
        // stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

        // Open a connection to the APNS server
        if ($app_type == 'debug') {
            $ctx = stream_context_create();
            stream_context_set_option($ctx, 'ssl', 'local_cert', 'NextTec_PUSH.pem');
            stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
            $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

        } else {
            $ctx = stream_context_create();
            stream_context_set_option($ctx, 'ssl', 'local_cert', 'NextTec_PUSH.pem');
            stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
            $fp = stream_socket_client(
                'ssl://gateway.push.apple.com:2195', $err,
                $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

        }

        // if (!$fp)
        // exit("Failed to connect: $err $errstr" . PHP_EOL);
        //
        // echo 'Connected to APNS' . PHP_EOL;

        // Create the payload body
        $body['aps'] = array(
            'alert' => array(
                'title' => $title,
                'body' => $message,
                'notification_type' => $notification_type,
                'detail' => $detail,
            ),
            'mutable-content' => 1,
            'sound' => 'default',
            'content-available' => 1,
        );

        //$body['image'] = $image;

        // Encode the payload as JSON
        $payload = json_encode($body);
        // Build the binary notification
        if (strlen($deviceToken) == '64') {
            $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
        } else {
            $msg = chr(0) . pack('H*', str_replace(' ', '', sprintf('%u', CRC32($deviceToken)))) . pack('n', strlen($payload)) . $payload;
        }
        //$msg = chr(0) . pack('H*', str_replace(' ', '', sprintf('%u', CRC32($deviceToken)))) . pack('n', strlen($payload)) . $payload;

        // Send it to the server
        $result = fwrite($fp, $msg, strlen($msg));
        // if (!$result)
        // echo 'Message not delivered' . PHP_EOL;
        // else
        // echo 'Message successfully delivered' . PHP_EOL;

        // Close the connection to the server
        fclose($fp);
    }

    public static function sendFCMIOS($title, $message, $target = 0, $image = 0)
    {
        //$baseurl="http://".url();
        //FCM api URL
        $url = 'https://fcm.googleapis.com/fcm/send';
        //api_key available in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
        $server_key = 'AAAA_76mKPk:APA91bHTGei6hpJBwQtjJaI3oUyhhmyOAQ593Qt3TVAhxbQ7oFNqW0phUFkG2JcX8MBvUOZe61oilBgVV-tCXuceUoHOqmdhbkMEA9z7hkF9iSfzWp_r64HRkySsKYu3mq0JGOr5uQLY';

        $fields = array();
        $fields['notification'] = array();
        $fields['notification']['body'] = $message;
        $fields['notification']['title'] = $title;
        if ($image != "") {
            $fields['notification']['image'] = $image;
        }
        $fields['notification']['click_action'] = '.MainActivity';
        $fields['notification']['sound'] = 'default';

        $fields['content_available'] = true;
        $fields['data'] = array();
        $fields['data']['body'] = $message;
        $fields['data']['title'] = $title;
        if ($image != "") {
            $fields['data']['image'] = $image;
        }
        $fields['data']['click_action'] = '.MainActivity';
        $fields['data']['sound'] = 'default';
        // if(is_array($target)){
        // $fields['registration_ids'] = $target;
        // }else{
        $fields['to'] = $target;
        // }
        $fields['priority'] = "high";
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key=' . $server_key,
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === false) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }

    public static function getPermissionByCategory($category)
    {
        $getPermissions = Permission::where("category", $category)->where('status', '1')->get();
        return $getPermissions;
    }

    // Add data in fire base
    public static function firebaseSaveNotification($title, $message, $reciver_id, $sender_id)
    {
        $serviceAccount = ServiceAccount::fromJsonFile(env('FIREBASE_JSON_FILE_LOCATION'));
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri(env('FIREBASE_DATABASEURL'))
            ->create();

        $database = $firebase->getDatabase();

        $newPost = $database
            ->getReference('ewt')
            ->push([
                'title' => (string) $title,
                'message' => $message,
                'reciver_id' => (string) $reciver_id,
                'sender_id' => (string) $sender_id,
            ]);
        // dd($newPost->getvalue());
        return $newPost->getvalue();
    }

    public static function randomPasswordStrongPassword($len = 8)
    {

        //enforce min length 8
        if ($len < 8) {
            $len = 8;
        }

        //define character libraries - remove ambiguous characters like iIl|1 0oO
        $sets = array();
        $sets[] = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        $sets[] = '23456789';
        $sets[] = '~!@#$%^&*(){}[],./?';

        $password = '';

        //append a character from each set - gets first 4 characters
        foreach ($sets as $set) {
            $password .= $set[array_rand(str_split($set))];
        }

        //use all characters to fill up to $len
        while (strlen($password) < $len) {
            //get a random set
            $randomSet = $sets[array_rand($sets)];

            //add a random char from the random set
            $password .= $randomSet[array_rand(str_split($randomSet))];
        }

        //shuffle the password string before returning!
        return str_shuffle($password);
    }

    public static function getHourData($user_id)
    {
        $measurement = OpenTimeClose::where('user_id', $user_id)->get();
        $getHourData = array();
        if (count($measurement) != '0') {
            $getHour = $measurement;
            $k = 0;
            $week_day_id = $getHour[0]->week_day_id;
            for ($i = 0; $i < count($getHour); $i++) {
                if ($week_day_id == $getHour[$i]->week_day_id) {
                    $getHourData[$getHour[$i]->week_day_id][$k]['open_time'] = $getHour[$i]->open_time;
                    $getHourData[$getHour[$i]->week_day_id][$k]['close_time'] = $getHour[$i]->close_time;
                    $getHourData[$getHour[$i]->week_day_id][$k]['id'] = $getHour[$i]->time_sloat_id;
                    $k++;
                } else {
                    // $k = 0;
                    $week_day_id = $getHour[$i]->week_day_id;
                    $getHourData[$getHour[$i]->week_day_id][$k]['open_time'] = $getHour[$i]->open_time;
                    $getHourData[$getHour[$i]->week_day_id][$k]['close_time'] = $getHour[$i]->close_time;
                    $getHourData[$getHour[$i]->week_day_id][$k]['id'] = $getHour[$i]->time_sloat_id;
                    $k++;
                }
            }
            return $getHourData;
        } else {
            return $getHourData;
        }
    }

    public static function sendTwilioMessage($toMobileNumber, $ToMessage)
    {
        try {
            $toMobileNumber = trim($toMobileNumber);
            Twilio::message($toMobileNumber, $ToMessage);
        } catch (\Exception $e) {
            if ($e->getCode() === 21211) {
                return "The number " . $toMobileNumber . " is not a valid phone number.";
            } elseif ($e->getCode() === 21612) {
                return "The number " . $toMobileNumber . " has not a valid country code.";
            } else {
                return $e->getMessage();
            }
            throw $e;
        }
    }

    public static function passwordResetFrequency()
    {
        $user = User::find(1);
        // Start date
        $date1 = $user->last_login_at;
        // End date
        $date2 = date('Y-m-d H:i:s');
        $diff = strtotime($date2) - strtotime($date1);
        $days = (abs(round($diff / 86400, 0)));
        if ($user->password_reset_frequency < $days) {
            $user->notify(new PasswordResetFrequency($user));
            dispatch(new PasswordResetFrequencyJob($user));
        }
    }

}

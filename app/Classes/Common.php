<?php

namespace App\Classes;

use Illuminate\Support\Facades\Redis;
use DB;

class Common
{

    public function getmsg()
    {
        return 'hello';
    }

    public function callApi($method, $url, $data = false)
    {
        $curl = curl_init();
        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    if(is_array($data))
                        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
                    else
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        // Optional Authentication:
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);
        curl_close($curl);

        return json_decode($result, true);
    }

    public function storeAndGetData($key, $data = FALSE, $method = FALSE)
    {
        if ($method == "update" || $method == "delete")
            Redis::del($key);
        if (Redis::get($key)) {
            $data = Redis::get($key);
            return json_decode($data);
        } else {
            if ($data == FALSE)
                return FALSE;
            else {
                Redis::set($key, $data);
                return $data;
            }
        }
    }

    public function getFlowType()
    {
        return array(1 => "Mass Input", 2 => "Mass Output", 3 => "Others", 4 => "Energy");
    }
}

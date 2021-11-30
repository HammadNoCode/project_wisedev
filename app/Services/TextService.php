<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TextService
{
    public static function sendSMS($mobile, $message)
    {
        $url = 'https://api.txtlocal.com/send/';
        $query = '?apiKey=zHbLr0KTjN4-tK1qpvcYOwypFF6gxYoUQS28UmnKFh';
        $query .= "&numbers={$mobile}";
        $query .= '&sender=Cavalry Care';
        $query .= "&message={$message}";
        $query .= "&test=true";
        return (object) Http::get($url . $query)->json();
    }
}

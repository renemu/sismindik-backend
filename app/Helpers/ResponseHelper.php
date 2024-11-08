<?php

namespace App\Helpers;

class ResponseHelper
{
  public static function json($status = 200, $data = false, $message = false)
  {
    $response = collect();
    if($message){
      $response->put('message', $message);
    }

    if ($status !== 200) {
      $response->put('error', true);
    }
    $response->put('data', $data);
    
    return response()->json($response, $status);
  }
}

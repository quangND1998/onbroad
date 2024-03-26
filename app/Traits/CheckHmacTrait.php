<?php
namespace App\Traits;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
trait CheckHmacTrait{

    public function getUserStore($shop){
        return User::where('store_name', $shop)->first();
    }

    public function validateRequestShopify($request){
       
        try{
            $arr = [];
            $hmac = $request['hmac'];
            unset($request['hmac']);
            foreach($request as $key => $value){
                $key=str_replace("%","%25",$key);
                $key=str_replace("&","%26",$key);
                $key=str_replace("=","%3D",$key);
                $value=str_replace("%","%25",$value);
                $value=str_replace("&","%26",$value);
              
                $arr[] = $key."=".$value;
            }
            $str = implode('&', $arr);
            $ver_hmac =  hash_hmac('sha256',$str,config('shopify.shopify_api_secret'), false);
            return $ver_hmac === $hmac;
        
        }
        catch(Exception $e){
            Log::info('Problem with verify hmac from request');
            Log::info($e->getMessage().' '.$e->getLine());

            throw $e;
        }
    }
    
}
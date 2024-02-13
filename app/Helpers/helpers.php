<?php
  
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
/*use JWTAuth;
use App\User;
use JWTAuthException;*/
  
/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('is_login')) {
    function is_login(){
    	$is_login = false;
        return $is_login;
    }
}
  

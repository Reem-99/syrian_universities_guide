<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Collage;
use App\Models\CollageAdmin;
class admin_collage
{
    public function handle(Request $request, Closure $next)
    {
        try{
        $user= JWTAuth::parseToken()->authenticate();
        }catch(\Exception $e){
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokevInvalidException){
                return response()->json(['success'=>false , 'msg'=>'INVALID_TOKEN']);
            }
            else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokevExpiredException){
                return response()->json(['success'=>false , 'msg'=>'EXPIRED_TOKEN']);
            }
            else {
                return response()->json(['success'=>false , 'msg'=>'TOKEN_NOTFOUND']);
            }
        }
         if (!$user){
            return response()->json(['success'=>false , 'msg'=>trans('Unauthenticated')]); 
        }
        
        if ($user->jobtype == 'مسؤول عام' || $user->jobtype == 'مسؤول كلية'){
        return $next($request);
        }
        
        else {
            $message=['msg'=>"Unauthenticated"];
            return response($message); 
        }
    }
}
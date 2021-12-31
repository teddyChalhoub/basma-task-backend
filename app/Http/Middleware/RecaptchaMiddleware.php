<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RecaptchaMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try{

            $recaptchaToken = $request->header('recaptchaToken');
            $secret = env("RECAPTCHA_SECRET");
            $response = Http::post("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$recaptchaToken");
            if($response['success']){
                return $next($request);
            }else{
               throw new Exception("Incorrect please try again");
            }

        }catch(Exception $e){
            return response()->json([
                "success"=>false,
                "message"=>$e->getMessage()
            ],401);
        }

    }
}

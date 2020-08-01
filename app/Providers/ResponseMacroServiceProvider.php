<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     * Register the application's response macros.
     *
     * @return void
     */
    public function boot()
    {
        /*
         * If you would like to define a custom response that
         * you can re-use in a variety of your routes and controllers,
         * you may use the macro method on the Response facade. 
         * 
         *  This returns {'status':boolean, 'code':numeric, 'message':string, 'data': null or object or array} 
         */
        Response::macro('successResponse', function ($data, $message, $statusCode) {
            return Response::json([
                'status' => true, // true
                'message' => $message,  // success message
                'data' => $data // null or application-specific data would go here
            ], $statusCode);
        });

        Response::macro('errorResponse', function ($data, $message, $statusCode) {
            return Response::json([
                'status' => false, // false
                'message' => $message, // error message
                'data' => $data // null or optional error payload
            ], $statusCode);
        });

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}

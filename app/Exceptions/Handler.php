<?php

namespace App\Exceptions;

use App\Http\Helpers\AppHelper;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;



class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception               $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {

            if (method_exists($exception, 'getStatusCode')) {

                $statusCode = $exception->getStatusCode();

                if(!env('APP_DEBUG', false)) {
                    if (!$request->user() && AppHelper::isFrontendEnabled()) {
                        $locale = Session::get('user_locale');
                        App::setLocale($locale);

                        if ($statusCode == 404) {
                            return response()->view('errors.front_404', [], 404);
                        }

                        if ($statusCode == 500) {

                            return response()->view('errors.front_500', [], 500);
                        }

                    }
                }

                if ($request->user()) {
                    if ($statusCode == 404) {
                        return response()->view('errors.back_404', [], 404);
                    }

                    if ($statusCode == 401) {
                        return response()->view('errors.back_401', [], 404);
                    }
                }



            }



        return parent::render($request, $exception);
    }
}

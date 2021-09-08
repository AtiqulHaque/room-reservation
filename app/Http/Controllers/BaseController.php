<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Redirect;
use Session;

class BaseController extends Controller
{
    use ApiResponse;
    public function redirectSuccess($route, $message)
    {
        Session::flash('flash-message-success', $message);
        return Redirect::route($route);
    }

    /**
     * @param $route
     * @param $message
     * @return RedirectResponse
     */
    public function redirectFailure($route, $message)
    {
        Session::flash('flash-message-error', $message);
        return Redirect::route($route);
    }

    protected function redirectToPreviousUrlForFailure($message)
    {
        Session::flash('flash-message-error', $message);
        return Redirect::back();
    }


    protected function getSeoKeyWord($index = 'default'){
        return [
            'meta_keyword'=>config('seo.'.$index.'.title'),
            'meta_description'=>config('seo.'.$index.'.description'),
        ];
    }

    public function getExcerpt($text,$words_to_return = 150)
    {
        $words_in_text = str_word_count($text,1);
        $result = array_slice($words_in_text,0,$words_to_return);
        return implode(" ",$result);
    }

}

<?php

namespace App\Http\Controllers\crud;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Helpers\LangHelper;

class LangController extends Controller
{
    /**
     * Lang switcher
     *
     * @param object $request
     * @param string $code lang code
     * @return Response
     */
    public function lang (Request $request, $code)
    {
        // Check lang code isset
        if (in_array($code, LangHelper::$languageList)) {
            $request->session()->put('lang', $code);
        }

        return redirect(route('dashboard'));
    }
}

<?php

namespace App\Web\Front\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Electrons\Activities\ActivityService as Activities;

class FrontController extends Controller
{
    /**
     * Show the landing page.
     *
     * @param  Activities  $activities
     * @return Response
     */
    public function root(Activities $activities)
    {
        $data = [
            'activities' => $activities->getMultiple([])
        ];

        return view('landing', $data);
    }
}

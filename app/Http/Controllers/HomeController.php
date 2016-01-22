<?php

namespace EmailManager\Http\Controllers;

use EmailManager\Http\Requests;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = \EmailManager\Event::latest()
            ->with('user')
            ->take('10')
            ->get();

        return view('home', compact('events'));
    }
}

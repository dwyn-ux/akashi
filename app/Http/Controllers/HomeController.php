<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Competition;
use App\Models\Faq;
use App\Models\Schedule;

class HomeController extends Controller
{
    public function index()
    {
        $competitions = Competition::whereIn('status', ['OPEN', 'CLOSED'])->latest()->get();
        $activities = Activity::latest()->limit(6)->get();
        $schedules = Schedule::orderBy('date')->limit(10)->get();
        $faqs = Faq::orderBy('order')->get();
        $finished = ! Competition::where('status', 'OPEN')->exists();

        return view('home', compact('competitions', 'activities', 'schedules', 'faqs', 'finished'));
    }
}

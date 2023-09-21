<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class DayController extends Controller
{

    public function Week()
    {
        $now = Carbon::now();
        $weekStartDate = $now->startOfWeek();
        $weekEndDate = $now->endOfWeek();

        $weekDays = [];

        while ($weekStartDate <= $weekEndDate) {
            $formattedDate = $weekStartDate->format('l d');
            $weekDays[] = $formattedDate;
            $weekStartDate = $weekStartDate->copy()->addDay();
        }

        return view('welcome', compact('weekDays'));
    }
}

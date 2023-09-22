<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class DayController extends Controller
{

    public function Week()
    {
        $now = Carbon::now('Europe/Amsterdam')->locale('nl'); 
        $day1 = $now->format('l');
        $today = $now->format('d M Y'); 
        $weekStartDate = $now->startOfWeek()->format('Y-m-d');
        $weekEndDate = $now->endOfWeek()->format('Y-m-d');
        
        $weekNumbers = [];
        $weekNumbers[] = Carbon::parse($weekStartDate)->subWeeks(2)->weekOfYear;
        $weekNumbers[] = Carbon::parse($weekStartDate)->subWeeks(1)->weekOfYear;
        $weekNumbers[] = Carbon::parse($weekStartDate)->weekOfYear;
        $weekNumbers[] = Carbon::parse($weekStartDate)->addWeeks(1)->weekOfYear;
        $weekNumbers[] = Carbon::parse($weekStartDate)->addWeeks(2)->weekOfYear;
        
        $weekDays = [];
        
        while ($weekStartDate <= $weekEndDate) {
            $weekDays[] = $weekStartDate;
            $weekStartDate = Carbon::parse($weekStartDate)->addDay()->format('Y-m-d');
        }
        
        // foreach ($weekDays as $key => $value) {
        //     $weekDays[$key] = Carbon::parse($value)->format('l d');
        //     // $weekDays[$key] = str_replace('Monday', 'Maandag', $weekDays[$key]);
        //     // $weekDays[$key] = str_replace('Tuesday', 'Dinsdag', $weekDays[$key]);
        //     // $weekDays[$key] = str_replace('Wednesday', 'Woensdag', $weekDays[$key]);
        //     // $weekDays[$key] = str_replace('Thursday', 'Donderdag', $weekDays[$key]);
        //     // $weekDays[$key] = str_replace('Friday', 'Vrijdag', $weekDays[$key]);
        //     // $weekDays[$key] = str_replace('Saturday', 'Zaterdag', $weekDays[$key]);
        //     // $weekDays[$key] = str_replace('Sunday', 'Zondag', $weekDays[$key]);
        // }
        
        $year = $now->year;
        $start = $now->startOfWeek()->isoFormat('DD MMM', 'nl');
        $end = $now->endOfWeek()->isoFormat('DD MMM', 'nl');
        
        return view('welcome', [
            'weekDays' => $weekDays,
            'year' => $year,
            'start' => $start,
            'end' => $end,
            'today' => $today,
            'day1' => $day1,
            'weekNumbers' => $weekNumbers,
        ]);        
    }

    public function pagination(Request $request)
    {
        if ($request->ajax()) {
            $action = $request->input('action');
            $DaysOfWeek = $request->input('weekDays'); //['Monday 18', 'Tuesday 19', 'Wednesday 20', 'Thursday 21', 'Friday 22', 'Saturday 23', 'Sunday 24']
        
            $firstDayOfWeek = Carbon::createFromFormat('Y-m-d', $DaysOfWeek[0]);
            
            if ($action === 'next') {
                $firstDayOfWeek->addWeek();
            } elseif ($action === 'previous') {
                $firstDayOfWeek->subWeek();
            }

            $year = Carbon::parse($firstDayOfWeek)->year;
            $start = $firstDayOfWeek->startOfWeek()->isoFormat('DD MMM', 'nl');
            $end = $firstDayOfWeek->endOfWeek()->isoFormat('DD MMM', 'nl');
        
            $weekStartDate = $firstDayOfWeek->startOfWeek()->format('Y-m-d');
            $weekEndDate = $firstDayOfWeek->endOfWeek()->format('Y-m-d');
        
            $weekDays = [];
            while ($weekStartDate <= $weekEndDate) {
                $weekDays[] = $weekStartDate;
                $weekStartDate = Carbon::parse($weekStartDate)->addDay()->format('Y-m-d');
            }       
            return response()->json([
                'weekDays' => $weekDays,
                'start' => $start,
                'end' => $end,
                'year' => $year,
            ]);
            
        }
    }
    public function paginationDay(Request $request){
        $action = $request->input('action');
        $day1 = Carbon::parse($request->input('day1'));
        $today = Carbon::parse($request->input('today'));
    
        if ($action === 'next') {
            $day1->addDay();
            $today->addDay(); 
        } elseif ($action === 'previous') {
            $day1->subDay(); 
            $today->subDay(); 
        }
    
        return response()->json([
            'day1' => $day1->format('l'), 
            'today' => $today->format('d M Y'),
        ]);
    }
    public function paginationFiveWeek(Request $request) {
        $action = $request->input('action');
        $weekNumbers = $request->input('weekNumbers');
        
        if ($action === 'next') {
            $nextWeekNumbers = [];
            foreach ($weekNumbers as $weekNumber) {
                // Ensure that the resulting week number is within the valid range (1 to 52)
                $nextWeekNumber = $weekNumber + 5;
                if ($nextWeekNumber > 52) {
                    $nextWeekNumber = $nextWeekNumber % 52;
                }
                $nextWeekNumbers[] = $nextWeekNumber;
            }
            return response()->json(['weekNumbers' => $nextWeekNumbers]);
        } elseif ($action === 'previous') {
            $previousWeekNumbers = [];
            foreach ($weekNumbers as $weekNumber) {
                // Ensure that the resulting week number is within the valid range (1 to 52)
                $previousWeekNumber = $weekNumber - 5;
                if ($previousWeekNumber < 1) {
                    $previousWeekNumber = 52 - abs($previousWeekNumber);
                }
                $previousWeekNumbers[] = $previousWeekNumber;
            }
            return response()->json(['weekNumbers' => $previousWeekNumbers]);
        }
        
        return response()->json(['weekNumbers' => $weekNumbers]);
    }
    
}

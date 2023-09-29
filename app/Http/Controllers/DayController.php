<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Event;
use Illuminate\Support\Facades\DB;

class DayController extends Controller
{

    public function Week()
    {
        $now = Carbon::now('Europe/Amsterdam')->locale('nl'); 
        $vandag = $now->format('Y-m-d');
        $day1 = $now->format('l');
        $today = $now->format('d M Y'); 
        $currentDayEvents = Event::where(function ($query) use ($vandag) {
            $query->whereDate('start', '<=', $vandag)
                ->whereDate('end', '>=', $vandag);
        })->orderBy('name', 'asc')->get();
        $weekStartDate = $now->startOfWeek()->format('Y-m-d');
        $weekEndDate = $now->endOfWeek()->format('Y-m-d');
        $events = Event::whereBetween('start', [$weekStartDate, $weekEndDate])
            ->orWhereBetween('end', [$weekStartDate, $weekEndDate])
            ->orderBy('name', 'asc')
            ->get();
        $weekNumbers = [
            Carbon::parse($weekStartDate)->subWeeks(2)->weekOfYear,
            Carbon::parse($weekStartDate)->subWeeks(1)->weekOfYear,
            Carbon::parse($weekStartDate)->weekOfYear,
            Carbon::parse($weekStartDate)->addWeeks(1)->weekOfYear,
            Carbon::parse($weekStartDate)->addWeeks(2)->weekOfYear
        ];
        
        $weekEvents = Event::where(function ($query) use ($weekNumbers) {
            $query->whereIn(DB::raw('WEEK(start)'), $weekNumbers)
                ->orWhereIn(DB::raw('WEEK(end)'), $weekNumbers);
        })->orderBy('name', 'asc')->get();

        
        $weekDays = [];
        
        while ($weekStartDate <= $weekEndDate) {
            $weekDays[] = $weekStartDate;
            $weekStartDate = Carbon::parse($weekStartDate)->addDay()->format('Y-m-d');
        }
        

        $year = $now->year;
        $start = $now->startOfWeek()->isoFormat('DD MMM', 'nl');
        $end = $now->endOfWeek()->isoFormat('DD MMM', 'nl');
        
        return view('dashboard', [
            'weekDays' => $weekDays,
            'year' => $year,
            'start' => $start,
            'end' => $end,
            'today' => $today,
            'day1' => $day1,
            'weekNumbers' => $weekNumbers,
            'events' => $events,
            'currentDayEvents' => $currentDayEvents,
            'weekEvents' => $weekEvents,
        ]);      
    }

    public function pagination(Request $request)
    {
        if ($request->ajax()) {
            $action = $request->input('action');
            $DaysOfWeek = $request->input('weekDays');
        
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
            $task = Event::whereBetween('start', [$weekStartDate, $weekEndDate])
            ->orWhereBetween('end', [$weekStartDate, $weekEndDate])
            ->orderBy('name', 'asc')
            ->get();
        
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
                'task' => $task,
            ]);
            
        }
    }
    public function paginationDay(Request $request)
    {
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

        // Query events that either start or end on the specified day
        $task = Event::where(function ($query) use ($today) {
            $query->whereDate('start', '<=', $today)
                ->whereDate('end', '>=', $today);
        })->orderBy('name', 'asc')->get();

        return response()->json([
            'day1' => $day1->format('l'),
            'today' => $today->format('d M Y'),
            'task' => $task,
        ]);
    }
    public function paginationFiveWeek(Request $request) {
        $action = $request->input('action');
        $weekNumbers = $request->input('weekNumbers');

        $nextWeekNumbers = [];
        $previousWeekNumbers = [];
    
        foreach ($weekNumbers as $weekNumber) {
            $nextWeekNumber = $weekNumber + 5;
            if ($nextWeekNumber > 52) {
                $nextWeekNumber = $nextWeekNumber % 52;
            }
            $nextWeekNumbers[] = $nextWeekNumber;
            $previousWeekNumber = $weekNumber - 5;
            if ($previousWeekNumber < 1) {
                $previousWeekNumber = 52 - abs($previousWeekNumber);
            }
            $previousWeekNumbers[] = $previousWeekNumber;
        }
        
        if ($action === 'next') {
            $targetWeekNumbers = $nextWeekNumbers;
        } elseif ($action === 'previous') {
            $targetWeekNumbers = $previousWeekNumbers;
        } else {
            $targetWeekNumbers = $weekNumbers;
        }
    
        $weekEvents = Event::whereIn('weeknumber', $targetWeekNumbers)->orderBy('name', 'asc')->get();
        
        return response()->json(['weekNumbers' => $targetWeekNumbers, 'weekEvents' => $weekEvents]);
    }
    
}

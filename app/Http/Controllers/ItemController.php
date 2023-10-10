<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Event;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function index()
    {
        $now = Carbon::now('Europe/Amsterdam')->locale('nl');
        $vandag = $now->format('Y-m-d');
        $day1 = $now->format('l');
        $today = $now->format('d M Y');
        $orders = Order::all();

        $currentDayEvents = Event::join('order_event', 'events.id', '=', 'order_event.event_id')
                                    ->select('events.*', 'order_event.order_id')
                                    ->where(function ($query) use ($vandag) {
                                        $query->whereDate('events.start', '<=', $vandag)
                                            ->whereDate('events.end', '>=', $vandag);
                                    })
                                    ->orderBy('order_event.order_id')
                                    ->orderBy('events.name', 'asc')
                                    ->get();

        $weekStartDate = $now->startOfWeek()->format('Y-m-d');
        $weekEndDate = $now->endOfWeek()->format('Y-m-d');

        $weekEvents = Event::join('order_event', 'events.id', '=', 'order_event.event_id')
                            ->select('events.*', 'order_event.order_id')
                            ->where(function ($query) use ($weekStartDate, $weekEndDate) {
                                $query->whereBetween('events.start', [$weekStartDate, $weekEndDate])
                                    ->orWhereBetween('events.end', [$weekStartDate, $weekEndDate]);
                            })
                            ->orderBy('order_event.order_id')
                            ->orderBy('events.name', 'asc')
                            ->get();
                            // dd($weekEvents);


        $weekNumbers = [
            Carbon::parse($weekStartDate)->subWeeks(2)->weekOfYear,
            Carbon::parse($weekStartDate)->subWeeks(1)->weekOfYear,
            Carbon::parse($weekStartDate)->weekOfYear,
            Carbon::parse($weekStartDate)->addWeeks(1)->weekOfYear,
            Carbon::parse($weekStartDate)->addWeeks(2)->weekOfYear
        ];

        $events = Event::join('order_event', 'events.id', '=', 'order_event.event_id')
                        ->select('events.*', 'order_event.id as order_event_id', 'order_event.order_id') 
                        ->where(function ($query) use ($weekNumbers) {
                            $query->where(function ($q) use ($weekNumbers) {
                                $q->where('start', '<=', Carbon::now()->endOfWeek());
                                $q->orWhere('end', '>=', Carbon::now()->startOfWeek());
                            });
                            $query->orWhere(function ($q) use ($weekNumbers) {
                                $q->whereRaw('WEEK(start) <= ? AND WEEK(end) >= ?', [$weekNumbers[0], $weekNumbers[0]]);
                            });
                        })
                        ->orderBy('order_event.order_id')
                        ->orderBy('events.name', 'asc')
                        ->get();
                        // dd($events);

        $weekDays = [];

        while ($weekStartDate <= $weekEndDate) {
            $weekDays[] = $weekStartDate;
            $weekStartDate = Carbon::parse($weekStartDate)->addDay()->format('Y-m-d');
        }

        $year = $now->year;
        $start = $now->startOfWeek()->isoFormat('DD MMM', 'nl');
        $end = $now->endOfWeek()->isoFormat('DD MMM', 'nl');

        return view('item', [
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
            'orders' => $orders,
        ]);
    }
    public function paginationItemFiveWeek(Request $request) {
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
    
        $weekEvents =  Event::join('order_event', 'events.id', '=', 'order_event.event_id')
        ->select('events.*', 'order_event.id as order_event_id', 'order_event.order_id') 
        ->where(function ($query) use ($targetWeekNumbers) {
            $query->where(function ($q) use ($targetWeekNumbers) {
                $q->where('start', '<=', Carbon::now()->endOfWeek());
                $q->orWhere('end', '>=', Carbon::now()->startOfWeek());
            });
            $query->orWhere(function ($q) use ($targetWeekNumbers) {
                $q->whereRaw('WEEK(start) <= ? AND WEEK(end) >= ?', [$targetWeekNumbers[0], $targetWeekNumbers[0]]);
            });
        })
        ->orderBy('order_event.order_id')
        ->orderBy('events.name', 'asc')
        ->get();
    
        return response()->json(['weekNumbers' => $targetWeekNumbers, 'weekEvents' => $weekEvents]);
    }

}

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
                            $query->whereIn(DB::raw('WEEK(events.start)'), $weekNumbers)
                                ->orWhereIn(DB::raw('WEEK(events.end)'), $weekNumbers);
                        })
                        ->orderBy('order_event.order_id')
                        ->orderBy('events.name', 'asc')
                        ->get();

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

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Event;
use Carbon\Carbon;
use DateTime;

class EventController extends Controller
{
    public function create(request $request){
        $input = [
            'name' => 'required|string|max:255',
            'start' => 'required|date_format:Y-m-d\TH:i:s',
            'end' => 'required|date_format:Y-m-d\TH:i:s',
            'description' => 'required|string',
            'order' => 'required|string'
        ];
        $start = Carbon::parse($request->input('start'));
        $weekNumber = $start->weekOfYear;
        $event = Event::create([
            'name' => $request->input('name'),
            'start' => $request->input('start'),
            'end' => $request->input('end'),
            'weeknumber' => $weekNumber, 
            'description' => $request->input('description'), 
        ]);
        $order = $request->input('order');
        $event->orders()->attach($order);

        return redirect()->route('dashboard')->with('success', 'Event created successfully');
    }

    public function edit(Request $request)
    {
        $event = Event::find($request->id);
        $start = date('Y-m-d H:i:s', strtotime($request->start));
        $end = date('Y-m-d H:i:s', strtotime($request->end));

        $event->name = $request->name;
        $event->start = $start;
        $event->end = $end;
        $event->description = $request->description;
        $event->status = $request->status;

        $event->save();

        return back()->with('success', 'Event updated successfully');
    }

    public function editItem(Request $request)
    {
        $event = Event::find($request->id);
        $start = date('Y-m-d H:i:s', strtotime($request->start));
        $end = date('Y-m-d H:i:s', strtotime($request->end));

        $event->name = $request->name;
        $event->start = $start;
        $event->end = $end;
        $event->description = $request->description;
        $event->status = $request->status;

        $event->save();

        return back()->with('success', 'Event updated successfully');
    }

    public function update(Request $request){
        $event = Event::find($request->eventId);
    
        if (!$event) {
            return redirect()->route('dashboard')->with('error', 'Event not found');
        }
    
        $startString = preg_replace('/\([^)]+\)/', '', $request->start);
        $cellDateString = preg_replace('/\([^)]+\)/', '', $request->cellDate);
    
        $start = new DateTime($startString);
        $cellDate = new DateTime($cellDateString);
    
        // Convert $event->start and $event->end to DateTime objects if they are not already
        if (!$event->start instanceof DateTime) {
            $event->start = new DateTime($event->start);
        }
    
        if (!$event->end instanceof DateTime) {
            $event->end = new DateTime($event->end);
        }
    
        $dateDuration = $event->start->diff($event->end)->days;
    
        $formattedNewEnd = clone $cellDate; 
        $formattedNewEnd->modify('+' . $dateDuration . ' days');
    
        $event->update([
            'name' => $request->eventName,
            'start' => $cellDate->format('Y-m-d H:i:s'),
            'end' => $formattedNewEnd->format('Y-m-d H:i:s'),
        ]);
    
        return redirect()->route('dashboard')->with('success', 'Event updated successfully');
    }
    
    public function updateWeek(Request $request){
        $event = Event::find($request->eventId);
        $cellWeek = $request->cellWeek;
        $draggedWeekNumber = $request->draggedWeekNumber;
        $weekDifference = $cellWeek - $draggedWeekNumber;
        $newStartDate = date('Y-m-d H:i:s', strtotime($event->start) + ($weekDifference * 7 * 24 * 3600));
        $newEndDate = date('Y-m-d H:i:s', strtotime($event->end) + ($weekDifference * 7 * 24 * 3600));
    
        $event->start = $newStartDate;
        $event->end = $newEndDate;
        $event->save();
    
        return redirect()->route('dashboard')->with('success', 'Event updated successfully');
    }

    public function updateItemWeek(Request $request){
        $event = Event::find($request->eventId);
        $cellWeek = $request->cellWeek;
        $draggedWeekNumber = $request->draggedWeekNumber;
        $weekDifference = $cellWeek - $draggedWeekNumber;
        $newStartDate = date('Y-m-d H:i:s', strtotime($event->start) + ($weekDifference * 7 * 24 * 3600));
        $newEndDate = date('Y-m-d H:i:s', strtotime($event->end) + ($weekDifference * 7 * 24 * 3600));
    
        $event->start = $newStartDate;
        $event->end = $newEndDate;
        $event->save();
    
        return redirect()->route('dashboard')->with('success', 'Event updated successfully');
    }

    public function updateItem(Request $request){
        $event = Event::find($request->eventId);
    
        if (!$event) {
            return redirect()->route('dashboard')->with('error', 'Event not found');
        }
    
        $startString = preg_replace('/\([^)]+\)/', '', $request->start);
        $cellDateString = preg_replace('/\([^)]+\)/', '', $request->cellDate);
    
        $start = new DateTime($startString);
        $cellDate = new DateTime($cellDateString);
    
        if (!$event->start instanceof DateTime) {
            $event->start = new DateTime($event->start);
        }
    
        if (!$event->end instanceof DateTime) {
            $event->end = new DateTime($event->end);
        }
    
        $dateDuration = $event->start->diff($event->end)->days;
    
        $formattedNewEnd = clone $cellDate; 
        $formattedNewEnd->modify('+' . $dateDuration . ' days');
    
        $event->update([
            'name' => $request->eventName,
            'start' => $cellDate->format('Y-m-d H:i:s'),
            'end' => $formattedNewEnd->format('Y-m-d H:i:s'),
        ]);
    
        return redirect()->route('dashboard')->with('success', 'Event updated successfully');
    }

    public function delete(Request $request)
    {
        $eventId = $request->input('id');
        $event = Event::find($eventId);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        try {
            $event->orders()->detach();

            $event->delete();

            return response()->json(['message' => 'Event deleted successfully'], 204);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting event'], 500);
        }
    }

}

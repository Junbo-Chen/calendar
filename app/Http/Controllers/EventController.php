<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Event;
use Carbon\Carbon;

class EventController extends Controller
{
    public function create(request $request){
        $input = [
            'name' => 'required|string|max:255',
            'start' => 'required|date_format:Y-m-d\TH:i:s',
            'end' => 'required|date_format:Y-m-d\TH:i:s',
            'description' => 'required|string',
        ];
        $start = Carbon::parse($request->input('start'));
        $weekNumber = $start->weekOfYear;
        Event::create([
            'name' => $request->input('name'),
            'start' => $request->input('start'),
            'end' => $request->input('end'),
            'weeknumber' => $weekNumber, 
            'description' => $request->input('description'), 
        ]);

        return redirect()->route('dashboard')->with('success', 'Event created successfully');
    }

    public function edit(Request $request) {
        $event = Event::find($request->id);

        $currentTime = now()->format('H:i:s');

        $event->name = $request->name;
        $event->start = $request->start . ' ' . $currentTime;
        $event->end = $request->end . ' ' . $currentTime;
        $event->description = $request->description;
        $event->status = $request->status;
    
        $event->save();
    
        return redirect()->route('dashboard')->with('success', 'Event updated successfully');
    }

    public function update(Request $request){
        $event = Event::find($request->eventId);
        $start = date('Y-m-d H:i:s', strtotime($request->start));
        $end = date('Y-m-d H:i:s', strtotime($request->end));
    
        if ($event) {
            $event->update([
                'name' => $request->eventName,
                'start' => $request->start,
                'end' => $request->end,
            ]);
    
            return redirect()->route('dashboard')->with('success', 'Event updated successfully');
        } else {
            return redirect()->route('dashboard')->with('error', 'Event not found');
        }
    }

    public function delete(Request $request){
        $eventId = $request->input('id');
        $event = Event::find($eventId);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }
        try {
            $event->delete();
            return response()->json(['message' => 'Event deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting event'], 500);
        }
    }

}

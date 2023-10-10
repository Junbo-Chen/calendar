<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Item') }}
        </h2>
    </x-slot>
        <script
          src="https://code.jquery.com/jquery-3.7.1.min.js"
          integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
          crossorigin="anonymous"></script>
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
        <style>
    .event.event-1 {
        background-color: #FF5733;
    }

    .event.event-2 {
        background-color: #33FF57;
    }
    .event.event-3 {
        background-color: brown;
    }
    .event1.event-1 {
        background-color: #FF5733;
    }

    .event1.event-2 {
        background-color: #33FF57;
    }
    .event1.event-3 {
        background-color: brown;
    }
</style>
<div class="calendar" style="margin-top:20px">
  
  <header>
    <div class="group" style="display:flex;width:100%">
        <div class="flex-end" style="width:33%;padding-top:20px">
            <button class="secondary" id="weeklyViewBtn">Weekly</button>
            <button class="secondary" id="dailyViewBtn">Daily</button>
            <button class="secondary" id="fourWeekViewBtn">5 Week</button>
        </div>
          <div class="calendar__title" style="display: flex; justify-content: center; align-items: center;width:33%">
            <div class="icon secondary chevron_left" id="previousButtonWeek">‹</div>
            <div class="icon secondary chevron_left" id="previousButtonDay"style="display:none">‹</div>
            <div class="icon secondary chevron_left" id="previousButtonFiveWeek" style="display:none">‹</div>
            <h1 class="week" style="padding-top:10px;flex: 1;"><span></span><strong>{{$start}} - {{$end}}</strong> {{$year}}</h1>
            <h1 class="day" style="padding-top:10px;flex: 1;display:none"><span></span><strong>{{$today}}</strong> </h1>
            <h1 class="fourWeek" style="padding-top:10px;flex: 1;display:none"><span></span><strong> week {{$weekNumbers[0]}} - week {{$weekNumbers[4]}}</strong> </h1>
            <div class="icon secondary chevron_right" id="nextButtonWeek">›</div>
            <div class="icon secondary chevron_right" id="nextButtonDay" style="display:none">›</div>
            <div class="icon secondary chevron_right" id="nextButtonFiveWeek" style="display:none">›</div>
          </div> 
          <!-- <div class="end" style="width:33%;">
            <button type="button" class="btn btn-success mt-3 mb-4" data-bs-toggle="modal" data-bs-target="#createEventModal">Create</button>
              <div class="modal fade" id="createEventModal" tabindex="-1" aria-labelledby="createEventModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="createEventModalLabel">Create a new event</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form action="{{ route('createEvent') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                          <label for="EventName" class="form-label">Name</label>
                          <input type="text" class="form-control" id="EventName" name="name" required>
                        </div>
                        <div class="display">
                          <div class="mb-3" style="width:45%;">
                            <label for="EventStart" class="form-label">Start</label>
                            <input type="datetime-local" class="form-control" id="EventStart" name="start" required>
                          </div>
                          <div class="mb-3" style="width:45%;">
                            <label for="EventEnd" class="form-label">End</label>
                            <input type="datetime-local" class="form-control" id="EventEnd" name="end" required>
                          </div>
                        </div>
                        <div class="mb-3">
                          <label for="Eventdescription" class="form-label">Description</label>
                          <textarea name="description" id="" cols="30" rows="10" required></textarea>
                        </div>
                        <div class="d-flex justify-content-end buttons" style="margin-bottom:-30px">
                          <button type="button" class="btn btn-danger mt-3 mb-4" data-bs-dismiss="modal" style="margin-right:10px">Close</button>
                          <button type="submit" class="btn btn-success mt-3 mb-4">Create</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
          </div> -->
          <div style="align-self: flex-start; flex: 0 0 1"></div>
    </div>
  </header>

  <div class="week" id="thisWeek" style="max-width: 1280px; height: 500px; max-height: 500px; overflow: hidden;">
    <div style="overflow-y: scroll; max-height: 100%; height: 500px;">
        <table class="combinedTable" style="width: 100%; table-layout: fixed;">
            <thead>
                <tr>
                    @foreach ($weekDays as $day)
                        <th>{{ $day }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
            @foreach ($events as $event)
              @php
                $now = \Carbon\Carbon::now('Europe/Amsterdam')->locale('nl'); 
                $weekStartDate = $now->startOfWeek()->format('Y-m-d');
                $weekStart = \Carbon\Carbon::parse($weekStartDate);
                $eventStart = \Carbon\Carbon::parse($event->start);
                $eventEnd = \Carbon\Carbon::parse($event->end);
                if ($eventStart < $weekStart) {
                  $eventStart = $weekStart;
                }
                $eventDuration = $eventEnd->diffInDays($eventStart);
              @endphp
              <tr>
                  @php $colspanSet = false; @endphp
                  @foreach ($weekDays as $day)
                      <td
                          @if ($eventStart->format('Y-m-d') <= $day && $eventEnd->format('Y-m-d') >= $day)
                              @if ($eventStart->format('Y-m-d') == $day && !$colspanSet)
                                  @php
                                      $colspan = min($eventDuration, 6 - \Carbon\Carbon::parse($day)->dayOfWeek + 1);
                                      $colspanSet = true;
                                  @endphp
                                  colspan="{{ $colspan + 1 }}"
                              @else
                                  style="display: none;"
                              @endif
                          @else
                              colspan="1"
                          @endif>
                          @if ($eventStart->format('Y-m-d') <= $day && $eventEnd->format('Y-m-d') >= $day)
                          <div class="event event-{{ $event->order_id }}"  
                                data-eventid="{{ $event->id }}" 
                                data-eventname="{{ $event->name }}" 
                                data-start="{{ $eventStart->format('Y-m-d') }}" 
                                data-end="{{ $eventEnd->format('Y-m-d') }}" 
                                data-description="{{ $event->description }}" 
                                data-status="{{ $event->status }}">
                                {{ $event->name }}
                            </div>
                          @endif
                      </td>
                  @endforeach
              </tr>
            @endforeach
            </tbody>
        </table>
    </div>
  </div>

  <div id="editEventModal" class="modal" style="display:none">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="createEventModalLabel">Edit event</h5>
                  <button type="button" class="btn btn-danger" id="deleteEventButton"><i class="material-icons">delete</i></button>
              </div>
              <div class="modal-body">
                  <form action="{{ route('editItem') }}" method="POST">
                      @csrf
                      <input type="hidden" id="editEventId" name="id" value="">
                      <div class="display">
                          <div class="mb-3" style="width:45%">
                              <label for="editName" class="form-label">Name</label>
                              <input type="text" class="form-control" id="editName" name="name" required>
                          </div>
                          <div class="mb-3" style="width:45%;display:grid;">
                              <label for="editStatus" class="form-label">Status</label>
                              <select class="form-select" id="editStatus" name="status" required style="border: 1px solid #ced4da;border-radius: 0.25rem;height: 38px;">
                                  <option value="todo">To Do</option>
                                  <option value="in progress">In Progress</option>
                                  <option value="done">Done</option>
                              </select>
                          </div>
                        </div>
                      <div class="display">
                          <div class="mb-3" style="width:45%;">
                              <label for="EventStart" class="form-label">Start</label>
                              <input type="date" class="form-control" id="editStart" name="start" required>
                          </div>
                          <div class="mb-3" style="width:45%;">
                              <label for="EventEnd" class="form-label">End</label>
                              <input type="date" class="form-control" id="editEnd" name="end" required>
                          </div>
                      </div>
                      <div class="mb-3">
                          <label for="Eventdescription" class="form-label">Description</label>
                          <textarea name="description" id="editDescription" cols="30" rows="10" required></textarea>
                      </div>
                      <div class="d-flex justify-content-end buttons" style="margin-bottom:-30px">
                          <button type="button" class="btn btn-danger mt-3 mb-4" data-bs-dismiss="modal" style="margin-right:10px">Close</button>
                          <button type="submit" class="btn btn-success mt-3 mb-4">Edit</button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>

  <div class="day" id="day" style="display:none">
    <div style="overflow-y: scroll; max-height: 100%; height: 500px">
        <table class="vandaag">
            <thead>
                <tr>
                    <th>{{$day1}}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                  <td>
                    @foreach ($currentDayEvents as $event)
                    <div class="event event-{{ $event->order_id }}" 
                                data-eventid="{{ $event->id }}" 
                                data-eventname="{{ $event->name }}" 
                                data-start="{{ $eventStart->format('Y-m-d') }}" 
                                data-end="{{ $eventEnd->format('Y-m-d') }}" 
                                data-description="{{ $event->description }}" 
                                data-status="{{ $event->status }}">
                                {{ $event->name }}
                            </div>
                    @endforeach
                  </td>
                </tr>
            </tbody>
        </table>
    </div>
  </div>

  <div class="fiveWeek" id="fiveWeek" style="display:none">
    <div style="overflow-y: scroll; max-height: 100%;height:500px">
        <table class="week">
            <thead>
                <tr>
                    @foreach ($weekNumbers as $number)
                        <th>Week {{ $number }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($events as $event)
                    @php
                        $eventStart = \Carbon\Carbon::parse($event->start);
                        $eventEnd = \Carbon\Carbon::parse($event->end);
                    @endphp
                    <tr>
                        @foreach ($weekNumbers as $weekNumber)
                            <td>
                                @if ($eventStart->weekOfYear <= $weekNumber && $eventEnd->weekOfYear >= $weekNumber)
                                  <div class="event1 event-{{ $event->order_id }}" 
                                        data-eventid="{{ $event->id }}" 
                                        data-eventname="{{ $event->name }}" 
                                        data-start="{{ $eventStart->format('Y-m-d') }}" 
                                        data-end="{{ $eventEnd->format('Y-m-d') }}" 
                                        data-description="{{ $event->description }}" 
                                        data-status="{{ $event->status }}">
                                        {{ $event->name }}
                                    </div>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
  </div>
</div>

</x-app-layout>
<script>
  var weekDays = @json($weekDays);
  var start = @json($start);
  var end = @json($end);
  var year = @json($year);
  var day1 = @json($day1);
  var today = @json($today);
  var weekNumbers = @json($weekNumbers);
  var task = @json($events);
  var weekEvents = @json($weekEvents); 

  $(document).ready(function() {
    initializeDragAndDrop2();
    $('#nextButtonWeek').on('click', function() {
      sendPostRequest('next');
    });

    $('#previousButtonWeek').on('click', function() {
      sendPostRequest('previous');
    });
    $('#previousButtonDay').on('click',function(){
      sendPostDayRequest('previous');
    });
    $('#nextButtonDay').on('click',function(){
      sendPostDayRequest('next');
    });
    function sendPostDayRequest(action) {
      $.ajax({
        url: "{{ route('calendar.paginationDay') }}",
        type: 'POST',
        data: {
          _token: '{{ csrf_token() }}',
          action: action,
          day1: day1,
          today: today,
          task: task,
        },
        success: function(response) {
          day1 = response.day1;
          today = response.today;
          task = response.task;
          updateTableDay(response.today,day1,task);
          console.log('POST request successful:', response);
        },
        error: function(error) {
          console.error('POST request error:', error);
        }
      });
    }
    function sendPostRequest(action) {
      $.ajax({
        url: "{{ route('calendar.pagination') }}",
        type: 'POST',
        data: {
          _token: '{{ csrf_token() }}',
          action: action,
          weekDays: weekDays,
          day1: day1,
          task: task,
        },
        success: function(response) {
          console.log('POST request successful:', response);
          weekDays = response.weekDays;
          start = response.start;
          end = response.end;
          year = response.year;
          updateTable(response.weekDays,start,end,year,response.task);
          initializeDragAndDrop2();
        },
        error: function(error) {
          console.error('POST request error:', error);
        }
      });
    }
  });
  function formatDate(date) {
        var timezoneOffset = date.getTimezoneOffset();
        date.setMinutes(date.getMinutes() - timezoneOffset);
        return date.toISOString().split('T')[0];
    }
  function updateTable(weekDays, start, end, year, task) {
    var table = $('table.combinedTable');
    var tableBody = table.find('tbody');
    tableBody.empty();

    $.each(task, function(index, task) {
        var taskRow = '<tr>';
        var eventStart = new Date(task.start);
        var eventEnd = new Date(task.end);

        var formattedStart = formatDate(eventStart);
        var formattedEnd = formatDate(eventEnd);

        var isSameDay = eventStart.toDateString() === new Date(weekDays[0]).toDateString();
        var isSameDay2 = eventStart.toDateString() === new Date(weekDays[1]).toDateString();
        var isSameDay3 = eventStart.toDateString() === new Date(weekDays[2]).toDateString();
        var isSameDay4 = eventStart.toDateString() === new Date(weekDays[3]).toDateString();
        var isSameDay5 = eventStart.toDateString() === new Date(weekDays[4]).toDateString();
        var isSameDay6 = eventStart.toDateString() === new Date(weekDays[5]).toDateString();
        var isSameDay7 = eventStart.toDateString() === new Date(weekDays[6]).toDateString();

        var taskCell = '';
        var eventDuration = Math.ceil((eventEnd - eventStart) / (1000 * 60 * 60 * 24) + 1);

        if (eventStart < new Date(weekDays[0])) {
            eventDuration -= Math.ceil((new Date(weekDays[0]) - eventStart) / (1000 * 60 * 60 * 24));
            eventStart = new Date(weekDays[0]);
        }

        if (eventDuration >= 1) {
            taskCell = '<td colspan="' + eventDuration + '">';
            taskCell += '<div class="event event-' + task.order_id +'" data-eventid="' + task.id + '" ' +
                        'data-eventname="' + task.name + '" ' +
                        'data-start="' + formattedStart + '" ' +
                        'data-end="' + formattedEnd + '" ' +
                        'data-description="' + task.description + '" ' +
                        'data-status="' + task.status + '" ' +
                        'draggable="true"->' + task.name + '</div>';
            taskCell += '</td>';
        } else {
            taskCell = '<td>';
            taskCell += '<div class="event event-' + task.order_id +'" data-eventid="' + task.id + '" ' +
                        'data-eventname="' + task.name + '" ' +
                        'data-start="' + formattedStart + '" ' +
                        'data-end="' + formattedEnd + '" ' +
                        'data-description="' + task.description + '" ' +
                        'data-status="' + task.status + '" ' +
                        'draggable="true">' + task.name + '</div>';
            taskCell += '</td>';
        }

        var cellAdded = false;

        $.each(weekDays, function(dayIndex, day) {
            var currentDay = new Date(day);
            if (!cellAdded && ((isSameDay7 && currentDay.toDateString() === eventStart.toDateString()) || (isSameDay6 && currentDay.toDateString() === eventStart.toDateString()) || (isSameDay5 && currentDay.toDateString() === eventStart.toDateString()) || (isSameDay4 && currentDay.toDateString() === eventStart.toDateString()) || (isSameDay4 && currentDay.toDateString() === eventStart.toDateString()) || (isSameDay3 && currentDay.toDateString() === eventStart.toDateString()) || (isSameDay2 && currentDay.toDateString() === eventStart.toDateString()) || (isSameDay && currentDay.toDateString() === eventStart.toDateString()) || (currentDay >= eventStart && currentDay <= eventEnd))) {
                taskRow += taskCell;
                cellAdded = true;
            } else {
                taskRow += '<td></td>';
            }
        });

        taskRow += '</tr>';
        tableBody.append(taskRow);
    });

    var tableHead = table.find('thead');
    tableHead.empty();

    $.each(weekDays, function(index, day) {
        var newHeader = '<th>' + day + '</th>';
        tableHead.append(newHeader);
    });
    var h1Element = $('h1.week');
    h1Element.html('<span></span><strong>' + start + ' - ' + end + '</strong> ' + year);
  }

  function updateTableDay(day1, today, task) {

    var table = $('table.vandaag');
    var tableHead = table.find('thead');
    var tableBody = table.find('tbody');

    tableHead.find('th').text(today);

    tableBody.empty();

    var eventRow = '<tr><td>';

    $.each(task, function(index, task) {
      var eventStart = new Date(task.start);
      var eventEnd = new Date(task.end);

      var formattedStart = eventStart.toISOString().split('T')[0];

      var formattedEnd = eventEnd.toISOString().split('T')[0];
      var backgroundColor = '';
        switch (task.status) {
            case 'todo':
                backgroundColor = '#ced4da'; 
                break;
            case 'in progress':
                backgroundColor = '#00B4FC'; 
                break;
            case 'done':
                backgroundColor = '#32de84'; 
                break;
            default:
                backgroundColor = 'white'; 
        }
      var cellContent = '<div class="event event-' + task.order_id +'" data-eventid="' + task.id + '" ' +
                        'data-eventname="' + task.name + '" ' +
                        'data-start="' + formattedStart + '" ' +
                        'data-end="' + formattedEnd + '" ' +
                        'data-description="' + task.description + '" ' +
                        'data-status="' + task.status + '" ' +
                        'draggable="true" style="background-color: ' + backgroundColor + ';">' + task.name + '</div>';
      eventRow += cellContent;
    });

    eventRow += '</td></tr>';
    tableBody.append(eventRow);

    $('h1.day').html('<span></span><strong>' + day1 + '</strong> ');
  }
  function updateTableFiveWeek(weekNumbers, weekEvents) {
    var table = $('table.week');
    var tableBody = table.find('tbody');
    tableBody.empty();

    $.each(weekEvents, function (eventIndex, event) {
        var eventStartDate = new Date(event.start);
        var eventEndDate = new Date(event.end);
        var eventWeekStart = getWeekOfYear(eventStartDate);
        var eventWeekEnd = getWeekOfYear(eventEndDate);
        var formattedStart = eventStartDate.toISOString().split('T')[0];
        var formattedEnd = eventEndDate.toISOString().split('T')[0];

        var row = $('<tr>');

        $.each(weekNumbers, function (index, weekNumber) {
            if (weekNumber >= eventWeekStart && weekNumber <= eventWeekEnd) {
                var cellContent = '<div class="event1 event-' + event.order_id +'"  data-eventid="' + event.id + '" ' +
                    'data-eventname="' + event.name + '" ' +
                    'data-start="' + formattedStart + '" ' +
                    'data-end="' + formattedEnd + '" ' +
                    'data-description="' + event.description + '" ' +
                    'data-status="' + event.status + '" ' +
                    'draggable="true">' + event.name + '</div>';
                row.append('<td>' + cellContent + '</td>');
            } else {
                row.append('<td></td>');
            }
        });

        tableBody.append(row);
    });

    var tableHead = table.find('thead');
    tableHead.empty();
    $.each(weekNumbers, function (index, weekNumber) {
        var newHeader = '<th>Week ' + weekNumber + '</th>';
        tableHead.append(newHeader);
    });

    var h1Element = $('h1.fourWeek');
    h1Element.find('strong').text('Week ' + weekNumbers[0] + ' - Week ' + weekNumbers[weekNumbers.length - 1]);
  }
  function initializeDragAndDrop() {
    var draggedWeekNumber;

    $('.event1').on('dragstart', function (event) {
        event.originalEvent.dataTransfer.setData('text/plain', event.target.dataset.eventid);
        var index = $(this).closest('td').index() + 1;
        draggedWeekNumber = weekNumbers[index - 1];
    });

    $('.week td').on('dragover', function (event) {
        event.preventDefault();
    });

    $('.week td').on('drop', function (event) {
        event.preventDefault();
        var eventId = event.originalEvent.dataTransfer.getData('text/plain');
        var targetTd = $(this);
        var targetWeek = targetTd.closest('tr').find('td').index(targetTd) + 1;
        var cellWeek = weekNumbers[targetWeek - 1];

        $.ajax({
            url: '/updateItemWeek',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                eventId: eventId,
                cellWeek: cellWeek,
                draggedWeekNumber: draggedWeekNumber,
            },
            success: function (response) {
                console.log('Event updated successfully.');
                location.reload();
            },
            error: function (error) {
                console.error('Error updating event:', error);
            }
        });
    });
  }

  $(document).ready(function () {
    initializeDragAndDrop();
    
    $('#nextButtonFiveWeek').on('click', function () {
        sendPostFiveWeekRequest('next');
    });

    $('#previousButtonFiveWeek').on('click', function () {
        sendPostFiveWeekRequest('previous');
    });
  });
  function sendPostFiveWeekRequest(action) {
      $.ajax({
        url: "{{ route('calendar.paginationItemFiveWeek') }}",
        type: 'POST',
        data: {
          _token: '{{ csrf_token() }}',
          action: action,
          weekNumbers: weekNumbers,
          weekEvents: weekEvents,
        },
        success: function(response) {
          weekNumbers = response.weekNumbers;
          updateTableFiveWeek(response.weekNumbers,response.weekEvents,response.nextWeekNumber);
          console.log('POST request successful:', response);
          initializeDragAndDrop();
        },
        error: function(error) {
          console.error('POST request error:', error);
        }
      });
  }

  function getWeekOfYear(date) {
      var startOfYear = new Date(date.getFullYear(), 0, 1);
      var diff = date - startOfYear;
      var oneWeek = 7 * 24 * 60 * 60 * 1000;
      return Math.ceil((diff + 1) / oneWeek);
  }

  document.getElementById("dailyViewBtn").addEventListener("click", function(){
    document.getElementsByClassName("week")[0].style.display = "none";
    document.getElementsByClassName("day")[0].style.display = "block";
    document.getElementsByClassName("fourWeek")[0].style.display = "none";
    document.getElementById("day").style.display = "block";
    document.getElementById("thisWeek").style.display = "none";
    document.getElementById("fiveWeek").style.display = "none";
    document.getElementById('previousButtonDay').style.display = "block";
    document.getElementById('previousButtonWeek').style.display = "none";
    document.getElementById('previousButtonFiveWeek').style.display = "none";
    document.getElementById('nextButtonWeek').style.display = "none";
    document.getElementById('nextButtonDay').style.display = "block";
    document.getElementById('nextButtonFiveWeek').style.display = "none";
  });
  document.getElementById("weeklyViewBtn").addEventListener("click", function(){
    document.getElementsByClassName("week")[0].style.display = "block";
    document.getElementsByClassName("day")[0].style.display = "none";
    document.getElementsByClassName("fourWeek")[0].style.display = "none";
    document.getElementById("day").style.display = "none";
    document.getElementById("thisWeek").style.display = "block";
    document.getElementById("fiveWeek").style.display = "none";
    document.getElementById('previousButtonDay').style.display = "none";
    document.getElementById('previousButtonWeek').style.display = "block";
    document.getElementById('previousButtonFiveWeek').style.display = "none";
    document.getElementById('nextButtonWeek').style.display = "block";
    document.getElementById('nextButtonDay').style.display = "none";
    document.getElementById('nextButtonFiveWeek').style.display = "none";
  });
  document.getElementById("fourWeekViewBtn").addEventListener("click", function(){
    document.getElementsByClassName("week")[0].style.display = "none";
    document.getElementsByClassName("day")[0].style.display = "none";
    document.getElementsByClassName("fourWeek")[0].style.display = "block";
    document.getElementById("day").style.display = "none";
    document.getElementById("thisWeek").style.display = "none";
    document.getElementById("fiveWeek").style.display = "block";
    document.getElementById('previousButtonDay').style.display = "none";
    document.getElementById('previousButtonWeek').style.display = "none";
    document.getElementById('previousButtonFiveWeek').style.display = "block";
    document.getElementById('nextButtonWeek').style.display = "none";
    document.getElementById('nextButtonDay').style.display = "none";
    document.getElementById('nextButtonFiveWeek').style.display = "block";
  });

  function initializeDragAndDrop2() {
    const events = document.querySelectorAll('.event');
    let draggedEvent = null;

    events.forEach(event => {
        event.addEventListener('dragstart', dragStart);
        event.addEventListener('dragend', dragEnd);
    });

    function dragStart() {
        draggedEvent = this;
        this.classList.add('dragging');
    }

    function dragEnd() {
        this.classList.remove('dragging');
        draggedEvent = null;
    }

    const cells = document.querySelectorAll('td');

    cells.forEach(cell => {
        cell.addEventListener('dragover', dragOver);
        cell.addEventListener('dragenter', dragEnter);
        cell.addEventListener('dragleave', dragLeave);
        cell.addEventListener('drop', dragDrop);
    });

    function dragOver(e) {
        e.preventDefault();
    }

    function dragEnter(e) {
        e.preventDefault();
    }

    function dragLeave() {}

    function dragDrop() {
        if (draggedEvent) {
            const eventId = draggedEvent.getAttribute('data-eventid');
            const eventName = draggedEvent.getAttribute('data-eventname');
            let start = new Date(draggedEvent.getAttribute('data-start'));
            let end = new Date(draggedEvent.getAttribute('data-end'));
            let status = draggedEvent.getAttribute('data-status');
            const columnIndex = Array.from(this.parentElement.children).indexOf(this);
            const cellDate = new Date(weekDays[columnIndex]);
            $.ajax({
                url: "/updateItem",
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    eventId: eventId,
                    eventName: eventName,
                    start: start,
                    cellDate: cellDate,
                },
                success: function (response) {
                    console.log('Event moved successfully.');
                    location.reload();
                },
                error: function (error) {
                    console.error('Error moving event:', error);
                },
            });
        }
    }
  }
  $(document).ready(function() {
    $(".event").on("dblclick", function(e) {
      const eventId = $(this).data("eventid");
      const eventname = $(this).data("eventname");
      const start = $(this).data("start");
      const end = $(this).data("end");
      const description = $(this).data("description");

      $("#editName").val(eventname);
      $("#editEventId").val(eventId);
      $("#editStart").val(start);
      $("#editEnd").val(end);
      $("#editDescription").val(description);

      $("#editEventModal").modal("show");
    });
  });
  $(document).ready(function() {
    $("#deleteEventButton").on("click", function() {
        const id = $("#editEventId").val();
        $.ajax({
            url: "/deleteEvent",
            method: 'delete',
            data: {
              _token: '{{ csrf_token() }}',
              id: id,
            },
            success: function(response) {
                console.log('Event deleted successfully.');
                $("#editEventModal").modal("hide");
                location. reload();
            },
            error: function(error) {
                console.error('Error deleting event:', error);
            },
        });
    });
  });
  $(document).ready(function() {
    $("table.vandaag").on("click", ".event", function(e) {
      const eventId = $(this).data("eventid");
      const eventname = $(this).data("eventname");
      const start = $(this).data("start");
      const end = $(this).data("end");
      const description = $(this).data("description");
      const status = $(this).data("status");

      $("#editStatus").val(status);
      $("#editName").val(eventname);
      $("#editEventId").val(eventId);
      $("#editStart").val(start);
      $("#editEnd").val(end);
      $("#editDescription").val(description);

      $("#editEventModal").modal("show");
    });
  });
  $(document).ready(function() {
    $("table.combinedTable").on("dblclick", ".event", function(e) {
      const eventId = $(this).data("eventid");
      const eventname = $(this).data("eventname");
      const start = $(this).data("start");
      const end = $(this).data("end");
      const description = $(this).data("description");
      const status = $(this).data("status");

      $("#editStatus").val(status);

      $("#editName").val(eventname);
      $("#editEventId").val(eventId);
      $("#editStart").val(start);
      $("#editEnd").val(end);
      $("#editDescription").val(description);

      $("#editEventModal").modal("show");
    });
  });
  $(document).ready(function() {
    $("table.week").on("dblclick", ".event1", function(e) {
      const eventId = $(this).data("eventid");
      const eventname = $(this).data("eventname");
      const start = $(this).data("start");
      const end = $(this).data("end");
      const description = $(this).data("description");
      const status = $(this).data("status");

      $("#editStatus").val(status);
      $("#editName").val(eventname);
      $("#editEventId").val(eventId);
      $("#editStart").val(start);
      $("#editEnd").val(end);
      $("#editDescription").val(description);
      $("#editEventModal").modal("show");
    });
  });
</script>
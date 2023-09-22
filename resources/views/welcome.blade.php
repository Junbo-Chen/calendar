<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <script
          src="https://code.jquery.com/jquery-3.7.1.min.js"
          integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
          crossorigin="anonymous"></script>

        <!-- Styles -->
        <style>
            * {
              margin: 0;
              border: 0;
            }

            body {
              flex-direction: column;
              display: flex;
              align-items: center;
              align-content: center;
              justify-content: center;
              font-family: "DINPro", "Helvetica Neue", sans-serif;
              padding: 3rem;
              margin: 0;
              background: #fafafa;
              box-sizing: border-box;
              height: 100vh;

            }

            .offset {

            }

            .outer {
              position:relative;
            }

            .calendar {
                margin: 0 auto;
              max-width: 1280px;
              min-width: 500px;

              box-shadow: 0px 30px 50px rgba(0, 0, 0, 0.2) ,0px 3px 7px rgba(0, 0, 0, 0.1);
              border-radius: 8px;
            }
            .wrap {

              overflow-x: hidden;
              overflow-y: scroll;
                max-width: 1280px;
              height: 500px;
              border-radius: 8px;
            }

            thead {
                box-shadow: 0px 2px 3px rgba(0, 0, 0, 0.2);
            }

            thead th {

              text-align: center;
              width: 100%;

            }

            header {
              background: #fff;
              padding: 1rem;
              color: rgba(0, 0, 0, 0.7);
              border-bottom: 1px solid rgba(0, 0, 0, 0.1);
              position: relative;
              display: flex;
              flex-direction: row;
              justify-content: space-between;
              align-items: center;
              border-radius: 8px 8px 0px 0px;
            }

            header h1 {
            font-size: 1.25rem;
            text-align: center;
            font-weight: normal;

            }
            tbody {
                position: relative;
              /* top: 100px; */
            }
            table {
              background: #fff;
              width: 100%;
              height: 100%;
              border-collapse: collapse;
              table-layout: fixed;

            }



            .headcol {
              width: 60px;
              font-size: 0.875rem;
              font-weight: 500;
              color: rgba(0, 0, 0, 0.5);
              padding: 0.25rem 0;
              text-align: center;
              border: 0;
              position: relative;
              top: -12px;
              border-bottom: 1px solid transparent;
            }

            thead th {
              font-size: 1rem;
              font-weight: bold;
              color: rgba(0, 0, 0, 0.9);
              padding: 1rem;
            }

            thead {
                z-index: 2;
                background: white;
                border-bottom: 2px solid #ddd;

            }

            tr, tr td {
              height: 20px;
            }
            td {
              text-align: center;
            }
            tr:nth-child(odd) td:not(.headcol) {
              border-bottom: 1px solid #e8e8e8;
            }

            tr:nth-child(even) td:not(.headcol) {
              border-bottom: 1px solid #eee;
            }

            tr td {
              border-right: 1px solid #eee;
              padding: 0;
              white-space: none;
              word-wrap: nowrap;
            }

            tbody tr td {
              position: relative;
              vertical-align: top;
              height: 40px;
              padding: 0.25rem 0.25rem 0 0.25rem;
              width: auto;

            }

            .secondary {
              color: rgba(0, 0, 0, 0.4);
            }


            .checkbox {
              display: none;
            }

            .checkbox + label {
                border: 0;
                outline: 0;
                width: 100px;
                heigth: 100px;
                background: white;
                color: transparent;
                display:block;
              display: none;
            }

            .checkbox:checked + label {
                border: 0;
                outline: 0;
                width: 100%;
                heigth: 100%;
                background: red;
                color: transparent;
                display: inline-block;
            }

            .event {
              background: #00B4FC;
              color: white;
              border-radius: 2px;
              text-align: left;
              font-size: 0.875rem;
              z-index: 2;
              padding: 0.5rem;
              overflow-x: hidden;
              transition: all 0.2s;
              cursor: pointer;
            }

            .event:hover {
              box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
              background: #00B4FC;
            }

            .event.double {
              height: 200%;
            }

            /**
            thead {
                tr {
                  display: block;
                  position: relative;
                }
              }
            tbody {
                display: block;
                overflow: auto;
                width: 800px;
                height: 100%;
              }
            */



            td:hover:after {
              content: "+";
              vertical-align: middle;
              font-size: 1.875rem;
              font-weight: 100;
              color: rgba(0, 0, 0, 0.5);
              position: absolute;
            }

            button.secondary {
              border: 1px solid rgba(0, 0, 0, 0.1);
              background: white;
              padding: 0.5rem 0.75rem;
              font-size: 14px;
              border-radius: 2px;
              color: rgba(0, 0, 0, 0.5);
              box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.1);
              cursor: pointer;
              font-weight: 500;
            }

            button.secondary:hover {
              background: #fafafa;
            }
            button.secondary:active {
              box-shadow: none;
            }
            button.secondary:focus {
              outline: 0;
            }

            /* tr td:nth-child(2), tr td:nth-child(3), .past {
              background: #fafafa;
            } */

            .today {
              color: red;
            }

            .now {
              box-shadow: 0px -1px 0px 0px red;
            }

            .icon {
              font-size: 1.5rem;
              margin: 0 1rem;
              text-align: center;
              cursor: pointer;
              vertical-align: middle;
              position: relative;
              top: -2px;
            }

            .icon:hover {
              color: red;
            }
        </style>
        
    </head>
    <body class="antialiased">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth
                        <a href="{{ url('/home') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="calendar">
  
  <header>
    <div class="group" style="display:flex;width:100%">
        <div class="flex-end" style="width:42%;">
            <button class="secondary" id="weeklyViewBtn">Weekly</button>
            <button class="secondary" id="dailyViewBtn">Daily</button>
            <button class="secondary" id="fourWeekViewBtn">4 Week</button>
        </div>
          <div class="calendar__title" style="display: flex; justify-content: center; align-items: center">
            <div class="icon secondary chevron_left" id="previousButtonWeek">‹</div>
            <div class="icon secondary chevron_left" id="previousButtonDay"style="display:none">‹</div>
            <div class="icon secondary chevron_left" id="previousButtonFiveWeek" style="display:none">‹</div>
            <h1 class="week" style="flex: 1;"><span></span><strong>{{$start}} - {{$end}}</strong> {{$year}}</h1>
            <h1 class="day" style="flex: 1;display:none"><span></span><strong>{{$today}}</strong> </h1>
            <h1 class="fourWeek" style="flex: 1;display:none"><span></span><strong> week {{$weekNumbers[0]}} - week {{$weekNumbers[4]}}</strong> </h1>
            <div class="icon secondary chevron_right" id="nextButtonWeek">›</div>
            <div class="icon secondary chevron_right" id="nextButtonDay" style="display:none">›</div>
            <div class="icon secondary chevron_right" id="nextButtonFiveWeek" style="display:none">›</div>
          </div> 
          <div style="align-self: flex-start; flex: 0 0 1"></div>
    </div>
  </header>
  
  <div class="week" id="thisWeek"style="display:block">

    
    <table class="dayOfWeek">
      <thead>
          <tr>
              <th class="headcol"></th>
              @foreach ($weekDays as $day)
                  <th>{{ $day }}</th>
              @endforeach
          </tr>
      </thead>
    </table>

    <div class="wrap" id="week"> 
      <table class="offset">

        <tbody>
          <tr>
            <td class="headcol"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="headcol">6:00</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="headcol"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="headcol">7:00</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="headcol"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="headcol">8:00</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="headcol"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="headcol">9:00</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="headcol"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="headcol">10:00</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="headcol"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="headcol">11:00</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="headcol"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="headcol">12:00</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="headcol"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="headcol">13:00</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="headcol"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="headcol">14:00</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="headcol"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="headcol">15:00</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="headcol"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="headcol">16:00</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="headcol"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="headcol">17:00</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="headcol"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="headcol">18:00</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="headcol"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div class="day" id="day" style="display:none">
      <table class="vandaag">
        <thead>
            <tr>
                <th>{{$day1}}</th>
            </tr>
        </thead>
      </table>
    
    <div class="wrap"> 
        <table class="offset">
    
          <tbody>
            <tr>
              <td class="headcol"></td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol">6:00</td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol"></td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol">7:00</td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol"></td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol">8:00</td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol"></td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol">9:00</td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol"></td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol">10:00</td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol"></td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol">11:00</td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol"></td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol">12:00</td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol"></td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol">13:00</td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol"></td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol">14:00</td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol"></td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol">15:00</td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol"></td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol">16:00</td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol"></td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol">17:00</td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol"></td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol">18:00</td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol"></td>
              <td></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  <div class="fourWeek" id="fourWeek" style="display:none">
      <table class="fiveWeek">
        <thead>
            <tr>
              <th class="headcol"></th>
              @foreach ($weekNumbers as $number)
                  <th>week {{ $number }}</th>
              @endforeach
            </tr>
        </thead>
      </table>
    
    <div class="wrap"> 
        <table class="offset">
    
          <tbody>
          <tr>
              <td class="headcol"></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol">Monday </td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol"></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol">Tuesday</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol"></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol">Wednesday</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol"></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol">Thursday</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol"></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol">Friday</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol"></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol">Saturday</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol"></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol">Sunday</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="headcol"></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

</div>
    </body>
</html>
<script>
  var weekDays = @json($weekDays);
  var start = @json($start);
  var end = @json($end);
  var year = @json($year);
  var day1 = @json($day1);
  var today = @json($today);
  var weekNumbers = @json($weekNumbers);

  $(document).ready(function() {
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
    $('#nextButtonFiveWeek').on('click', function() {
      sendPostFiveWeekRequest('next');
    });

    $('#previousButtonFiveWeek').on('click', function() {
      sendPostFiveWeekRequest('previous');
    });
    function sendPostDayRequest(action) {
      $.ajax({
        url: "{{ route('calendar.paginationDay') }}",
        type: 'POST',
        data: {
          _token: '{{ csrf_token() }}',
          action: action,
          day1: day1,
          today: today
        },
        success: function(response) {
          // console.log('POST request successful:', response);
          day1 = response.day1;
          today = response.today;
          updateTableDay(response.today,day1);
        },
        error: function(error) {
          console.error('POST request error:', error);
        }
      });
    }
    function sendPostFiveWeekRequest(action) {
      $.ajax({
        url: "{{ route('calendar.paginationFiveWeek') }}",
        type: 'POST',
        data: {
          _token: '{{ csrf_token() }}',
          action: action,
          weekNumbers: weekNumbers,
        },
        success: function(response) {
          // console.log('POST request successful:', response);
          weekNumbers = response.weekNumbers;
          updateTableFiveWeek(response.weekNumbers);
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
        },
        success: function(response) {
          // console.log('POST request successful:', response);
          weekDays = response.weekDays;
          start = response.start;
          end = response.end;
          year = response.year;
          updateTable(response.weekDays,start,end,year);
        },
        error: function(error) {
          console.error('POST request error:', error);
        }
      });
    }
  });

  function updateTable(weekDays, start, end, year) {
      var table = $('table.dayOfWeek');
      var tableHead = table.find('thead');
      tableHead.empty();
      var newHeader2 = '<th class="headcol"></th>';
      tableHead.append(newHeader2);
      $.each(weekDays, function(index, day) {
          var newHeader = '<th>' + day + '</th>';
          tableHead.append(newHeader);
      });

      var h1Element = $('h1.week');
      h1Element.html('<span></span><strong>' + start + ' - ' + end + '</strong> ' + year);
  }
  function updateTableDay(day1, today){
    $('h1.day').html('<span></span><strong>' + day1 + '</strong> ');

    $('table.vandaag th').text(day1);
  }
  function updateTableFiveWeek(weekNumbers) {
    // Update the table headers
    var table = $('table.fiveWeek');
    var tableHead = table.find('thead');
    tableHead.empty();

    var newHeader = '<th class="headcol"></th>';
    tableHead.append(newHeader);

    $.each(weekNumbers, function(index, weekNumber) {
      var newWeekHeader = '<th>week ' + weekNumber + '</th>';
      tableHead.append(newWeekHeader);
    });

    // Update the <h1> element
    var h1Element = $('h1.fourWeek');
    h1Element.find('strong').text(' week ' + weekNumbers[0] + ' - week ' + weekNumbers[4]);
  }

  document.getElementById("dailyViewBtn").addEventListener("click", function(){
    document.getElementsByClassName("week")[0].style.display = "none";
    document.getElementsByClassName("day")[0].style.display = "block";
    document.getElementsByClassName("fourWeek")[0].style.display = "none";
    document.getElementById("day").style.display = "block";
    document.getElementById("week").style.display = "none";
    document.getElementById("thisWeek").style.display = "none";
    document.getElementById("fourWeek").style.display = "none";
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
    document.getElementById("week").style.display = "block";
    document.getElementById("day").style.display = "none";
    document.getElementById("thisWeek").style.display = "block";
    document.getElementById("fourWeek").style.display = "none";
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
    document.getElementById("week").style.display = "block";
    document.getElementById("day").style.display = "none";
    document.getElementById("thisWeek").style.display = "none";
    document.getElementById("fourWeek").style.display = "block";
    document.getElementById('previousButtonDay').style.display = "none";
    document.getElementById('previousButtonWeek').style.display = "none";
    document.getElementById('previousButtonFiveWeek').style.display = "block";
    document.getElementById('nextButtonWeek').style.display = "none";
    document.getElementById('nextButtonDay').style.display = "none";
    document.getElementById('nextButtonFiveWeek').style.display = "block";
  });

</script>

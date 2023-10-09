<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script
          src="https://code.jquery.com/jquery-3.7.1.min.js"
          integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
          crossorigin="anonymous"></script>
        <style>
            * {
              margin: 0;
              border: 0;
            }
            .modal {
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .end{
              display: flex;
              justify-content: end;
              width: 35%;
            }
            textarea{
              height: 99px;
              width: 100%;
              border: 1px solid #ced4da;
            }
            .display{
              display:flex;
              justify-content:space-between;
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

            tr td{
              height:50px;
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
              height: 10px;
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

            /* .event:hover {
              box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
              background: #00B4FC;
            } */

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

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    </head>
    <body class="antialiased">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </body>
</html>
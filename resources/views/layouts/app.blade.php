<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            * {
              margin: 0;
              border: 0;
            }
            tr, tr td {
                height: 43px;
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

            /* tr, tr td {
              height: 20px;
            } */
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

            .event1 {
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
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>

<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Vue.js Project</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Icons -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" integrity="sha384-3AB7yXWz4OeoZcPbieVW64vVXEwADiYyAEhwilzWsLw+9FgqpyjjStpPnpBO8o8S" crossorigin="anonymous">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
        <!-- Axios & jQuery -->
        <script src="https://unpkg.com/axios@0.18.0/dist/axios.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    <body>
        <div id="app">
            <nav class="navbar navbar-default navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="{{ url('/home') }}">Home</a>
                    </div>
                    <div class="flex-center position-ref full-height">
                        <div class="top-right links"> 
                            <div class="collapse navbar-collapse" id="app-navbar-collapse">                    
                                <ul class="nav navbar-nav">
                                    &nbsp;
                                </ul>
                                <ul class="nav navbar-nav navbar-right"> 
                                    <li>
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('task-list') }}">My Tasklist</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('archived-tasks') }}">Task History</a>
                                    </li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                    </form>
                                </ul>
                            </div>                            
                        </div>
                    </div>
                </div>
            </nav>
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="content">
                            <div class="row">
                                <h1> Timelog for task: {{ $task->task }}</h1>
                                <table class='col-md-12'>
                                    <thead>
                                        <tr>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @foreach($task->timelogs as $timelog)
                                            <tr>
                                                <td>{{ $timelog->formattedStartDate() }}</td>
                                                @if($timelog->active)
                                                <td>Timer Still Active</td>
                                                @else
                                                <td>{{ $timelog->formattedEndDate() }}</td>
                                                @endif
                                                <td>{{ $timelog->total_time }}</td>
                                            </tr>
                                            @endforeach
                                    </tbody>
                                    <thead>
                                        <th></th>
                                        <th></th>
                                        <th>Total Time for Task</th>
                                    </thead>
                                    <tbody>
                                        <td></td>
                                        <td></td>
                                        <td>{{ $task->secondsToHrsMinSecString() }}</td>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Scripts -->
        <script src="/js/vue.js"></script>
    </body>
</html>

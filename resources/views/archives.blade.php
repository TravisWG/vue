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
                                <div class="col-md-12">
                                    <div class="title m-b-md">
                                        <h2>Task History</h2>
                                    </div>                                   
                                    <div class="archive-list">
                                        @foreach($tasks as $task)                             
                                        <div class="list-item">
                                            <div class="col-md-6 list-text">
                                               {{ $task->task }}<br>
                                            </div>                                        
                                            <div class="col-md-6 list-subtext">
                                                    Created: {{ $task->formatDate($task->created_at) }}<br>
                                                    Completed:
                                                    @if ($task->completed)
                                                        {{ $task->formatDate($task->completed_at) }}
                                                    @else
                                                        Not Completed
                                                    @endif 
                                            </div> 
                                        </div>
                                        @endforeach
                                    </div>
                                </div>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Scripts -->
        <!-- <script src="{{ asset('js/app.js') }}"></script> -->
        <script src="/js/vue.js"></script>
        <script src="/js/tasklist.js"></script>
    </body>
</html>

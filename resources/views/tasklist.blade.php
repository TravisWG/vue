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
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
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
                                <div id="tasklist"> 
                                    <div class="col-md-6">
                                        <div class="title m-b-md">
                                            <h2>Task List</h2>
                                        </div>                                   
                                        <div class="tasks">
                                            <ul>
                                                <li v-for="(task, key) in tasks">
                                                    @{{ task.task }}
                                                    <i v-on:click="moveToCompletedTasks(key)" class="fas fa-check" style="margin-left:2px; padding:1px;border-radius:5px; border: solid 1px black; color:green;background: black"></i>  
                                                    <i v-on:click="removeTask(key)" class="fas fa-times" style="margin-left:2px; padding:1px;border-radius:5px; border: solid 1px black; color:red;background: black"></i> 
                                                </li>
                                            </ul>
                                            <br>
                                            <input id="addTask" type="text">
                                            <button v-on:click="addTask">Add Task</button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="completedTasks">
                                            <h2>Completed Tasks</h2>
                                            <ul>
                                                <li v-for="(task, key) in completedTasks">
                                                    @{{ task.task }}
                                                    <i v-on:click="unmarkCompletedTasks(key)" class="fas fa-undo" style="margin-left:2px; padding:1px;border-radius:5px; border: solid 1px black; color:yellow;background: black"></i>    
                                                    <i v-on:click="removeCompletedTask(key)" class="fas fa-times" style="margin-left:2px; padding:1px;border-radius:5px; border: solid 1px black; color:red;background: black"></i> 
                                                </li>
                                            </ul>
                                        </div>
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

<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Vue.js Project</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Icons -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" integrity="sha384-3AB7yXWz4OeoZcPbieVW64vVXEwADiYyAEhwilzWsLw+9FgqpyjjStpPnpBO8o8S" crossorigin="anonymous">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Task List
                </div>
                <div id="tasklist">
                    <ul>
                        <li v-for="(item, key) in items">
                            @{{ item.message }}  <i v-on:click="removeTask(key)" class="fas fa-times" style="margin-left:2px; padding:1px;border-radius:5px; border: solid 1px black; color:red;background: black"></i> 
                        </li>
                    </ul>
                    <input id="addItem" type="text">
                    <button v-on:click="addTask">Add Task</button>
                </div>
            </div>
        </div>

        <script src="/js/vue.js"></script>
        <script src="/js/tasklist.js"></script>
    </body>
</html>

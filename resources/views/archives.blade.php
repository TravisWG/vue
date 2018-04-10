@extends('partials.template')


@section('content')
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
    </body>
</html>
@endsection
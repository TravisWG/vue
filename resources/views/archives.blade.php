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
                                                    <b>Created:</b> {{ $task->formatDate($task->created_at) }}<br>
                                                    <b>Completed:</b>
                                                    @if ($task->completed)
                                                        {{ $task->formatDate($task->completed_at) }}<br>
                                                    @else
                                                        Not Completed<br>
                                                    @endif 
                                                    @if($task->deleted_at)
                                                        <b>Archived:</b> {{ $task->formatDate($task->deleted_at)  }}<br>
                                                    @endif                                                    
                                                    <b>Total Time:</b>  {{ $task->secondsToHrsMinSecString($task->totalTimeInSeconds()) }}
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
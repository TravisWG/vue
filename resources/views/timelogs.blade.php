@extends('partials.template')


@section('content')
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
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
@endsection
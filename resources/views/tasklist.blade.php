@extends('partials.template')


@section('content')
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
                            <div class="task-list">                                            
                                <div class="list-item" v-for="task in tasks" v-show="!task.completed && task.deleted_at == null">                                                
                                    <div class="col-md-6 list-text" v-show="!task.edit" v-on:click="toggleEditTask(task)">
                                        @{{ task.task }}
                                    </div>
                                    <input type="text" v-show="task.edit" v-model="task.task" v-on:keydown.enter="saveEditTask(task)">
                                    <div class="col-md-6">
                                        <div class="list-buttons">
                                            <button v-on:click="toggleStatus(task)">
                                                <i class="fas fa-check"></i> 
                                                Mark Complete
                                            </button>
                                            <button v-on:click="removeTask(task)">
                                                <i class="fas fa-times"></i> Remove
                                            </button>
                                            <button v-on:click="startTimer(task)" v-show="!task.timer_active && !task.deleted_at" class="start-timer">
                                                <i class="fas fa-stopwatch"></i> Start Timer
                                            </button>
                                            <button v-on:click="stopTimer(task)" v-show="task.timer_active" class="stop-timer">
                                                <i class="fas fa-stopwatch"></i> Stop Timer
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-12 small">
                                                <a v-on:click="viewTimelogs(task)">View Timelogs</a>
                                    </div> 
                                </div>
                            </div>
                            <br>
                            <input id="addTask" type="text">
                            <button v-on:click="addTask">Add Task</button>
                        </div>
                        <div class="col-md-6">
                            <div class="completedTasks">
                                <h2>Completed Tasks</h2>
                                <div class="task-list">
                                    <div class="list-item" v-for="task in tasks" v-show="task.completed && task.deleted_at == null">
                                        <div class="col-md-6 list-text">
                                            @{{ task.task }}
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-12 list-buttons">
                                                <button v-on:click="toggleStatus(task)">
                                                    <i class="fas fa-undo"></i> Mark Active
                                                </button>
                                                <button v-on:click="removeTask(task)">
                                                    <i class="fas fa-times"></i> Remove
                                                </button> 
                                            </div>                                                
                                        </div>
                                        <div class="col-md-10 col-md-offset-2">
                                            <div class="small completion-time">
                                                <div v-show="task.work_completed_at != 0">
                                                        Date completed: @{{ task.completed_at }}
                                                </div>
                                                <div v-show="task.work_duration != 0">
                                                    Time working: @{{ secondsToTimeStringConversion(task) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
        <!-- <script src="{{ asset('js/app.js') }}"></script> -->
        <script src="/js/vue.js"></script>        
        <script src="/js/tasklist.js"></script>
@endsection

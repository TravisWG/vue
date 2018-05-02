<div class="row">
    <div class="col-md-12">
        <div class="sharedTasks">
            <h2>Shared Tasks</h2>                                
            <div v-cloak class="task-list">
                <div class="list-item" v-for="sharedTask in sharedTasks" v-show="sharedTask.deleted_at == null">
                    <div class="col-md-6 list-text">
                        @{{ sharedTask.parent_task.task }}
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-12 list-buttons">
                            <button v-on:click="removeSharedTask(sharedTask)">
                                <i class="fas fa-times"></i> Remove
                            </button> 
                        </div>                                                
                    </div>
                    <div class="col-md-6">
                        <b>Task Owner:</b> @{{ sharedTask.parent_task.tasklist.user.name }} || <em>@{{ sharedTask.parent_task.tasklist.user.email }}</em>
                    </div>
                </div>
            </div>                                
        </div>
    </div>
</div>
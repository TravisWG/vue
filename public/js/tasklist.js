var tasklist = new Vue({
    el: "#tasklist",
    data: {
        tasks: [],
        sharedTasks: [],
        colleagues: [],
        showModal: false,
        modalTaskId: null,
        checkedIds: [],

    },
    mounted: function() {
        this.fetchData();
    },
    methods: {
        fetchData: function() {
            var self = this;
            axios.get('/tasklist/fetch')
                .then(response => {
                    self.tasks = response.data;
                });
            axios.get('/tasklist/shared/fetch')
                .then(response => {
                    self.sharedTasks = response.data;
                });
        },

        addTask: function() {
            var self = this;
            axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            axios.post('/tasklist/addTask', {
                    task: document.getElementById("addTask").value,
                })
                .then(function(response) {
                    if(response.data.status != "error"){
                        self.tasks.push(response.data);
                        document.getElementById('addTask').value = '';
                    };
                })
                .catch(function(error) {
                    console.log("There was an error adding the new task")
                });
        },

        viewTimelogs: function(task) {
            window.location.href = '/task/' + task.id + '/timelogs';
        },

        toggleEditTask: function(task){
            task.edit = task.edit ? false : true;
        },

        saveEditTask: function(task) {
            var self = this;
            self.toggleEditTask(task);
            axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            axios.post('/tasklist/editTask', {
                    task: task
                })
                .then(function(response) {
                    task.task = response.data.task.task;      
                })
                .catch(function(error) {
                    console.log("There was an error adding the new task")
                });
        },

        startTimer: function(task) {
            var self = this;
            axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            axios.post('/tasklist/startTimer', {
                    task: task
                })
                .then(function(response) {
                    task.timer_active = response.data.task.timer_active;        
                })
                .catch(function(error) {
                    console.log("Error starting timer")
                });
        },

        stopTimer: function(task) {
            var self = this;
            axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            axios.post('/tasklist/stopTimer', {
                    task: task
                })
                .then(function(response) {
                    task.timer_active = response.data.task.timer_active; 
                    task.work_duration = response.data.task.work_duration;      
                })
                .catch(function(error) {
                    console.log("Error stopping timer")
                });
        },

        removeTask: function(task) {
            var self = this;
            axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            axios.post('/tasklist/removeTask', {
                    task: task
                })
                .then(function(response) {
                    task.deleted_at = response.data.task.deleted_at;
                })
                .catch(function(error) {
                    console.log("Error removing task")
                });
        },

        removeSharedTask: function(task) {
            var self = this;
            axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            axios.post('/tasklist/removeSharedTask', {
                    task: task
                })
                .then(function(response) {
                    console.log(resonse.date);
                    task.deleted_at = response.data.task.deleted_at;
                })
                .catch(function(error) {
                    console.log("Error removing task")
                });
        },

        toggleStatus: function(task) {
            var self = this;
            if(task.edit) {
                self.saveEditTask(task);
            }
            if(task.timer_active){
                self.stopTimer(task);
            }
            axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            axios.post('/tasklist/toggleStatus', {
                    task: task
                })
                .then(function(response) {
                    task.completed = response.data.task.completed;
                    task.completed_at = response.data.task.completed_at;
                })
                .catch(function(error) {
                    console.log("Unable to toggle status");
                });
        },

        formatTimeString: function() {
            var date = new Date();
            var hour = date.getHours();
            var minute = date.getMinutes();
            var ampm = hour >= 12 ? 'PM' : 'AM';
            
            hour = hour ? hour : 12; //midnight(00) should be 12.
            hour = hour > 12 ? hour - 12 : hour;
            hour = hour.toString().length < 2 ? "0" + hour : hour;
            minute = minute.toString().length < 2 ? "0" + minute : minute;
            var dateString = ("0" + (date.getMonth() + 1)).slice(-2) + '/' + ("0" + date.getDate()).slice(-2) + '/' + date.getFullYear() +
                ' ' + hour + ':' + date.getMinutes() + ':' + date.getSeconds() + ' ' + ampm;

            return dateString;
        },

        secondsToTimeStringConversion: function(task) {
            var task = task
            if(typeof task.work_duration == 'string'){
                task.work_duration = parseInt(task.work_duration);
            }
            var totalSeconds = task.work_duration;
            
            hours = Math.floor(totalSeconds / 3600);
            totalSeconds %= 3600;
            minutes = Math.floor(totalSeconds / 60);
            seconds = totalSeconds % 60;

            var timeString = hours + ' hours, ' + minutes + ' minutes, ' + seconds + ' seconds';
            return timeString;
        },

        shareModal: function(task) {
            var self = this;            
            axios.get('/colleagues/getColleagues')
                .then(response => {
                    self.colleagues = response.data;
                    self.modalTaskId = task.id;
                    self.showModal = true;
                });
        },

        sendShare: function(){
            var self = this;
            axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            axios.post('/tasklist/shareTask', {
                    taskId: self.modalTaskId,
                    userIds: self.checkedIds,
                })
                .then(function(response) {
                    self.closeModal();
                })
                .catch(function(error) {
                    console.log("Error sharing tasks.");
                });

        },

        closeModal: function() {
            this.colleagues = [];
            this.showModal = false;
            this.modalTaskId = null;
            this.checkedIds = [];
        }
    }
})
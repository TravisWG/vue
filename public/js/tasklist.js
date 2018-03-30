var tasklist = new Vue({
    el: "#tasklist",
    data: {
        tasks: [],
        completedTasks: []
    },
    mounted: function() {
        this.fetchData();
    },
    methods: {
        fetchData: function() {
            var self = this;
            axios.get('/tasklist/fetch/incomplete')
                .then(response => {
                    self.tasks = response.data;
                });
            axios.get('/tasklist/fetch/completed')
                .then(response => {
                    self.completedTasks = response.data;
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

        removeTask: function(key) {
            var self = this;
            axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            axios.post('/tasklist/removeTask', {
                    task: self.tasks[key]
                })
                .then(function(response) {
                    self.tasks.splice(key, 1);
                })
                .catch(function(error) {
                    console.log("Error removing task")
                });
        },

        removeCompletedTask: function(key) {
            var self = this;
            axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            axios.post('/tasklist/removeTask', {
                    task: self.completedTasks[key]
                })
                .then(function(response) {
                    self.completedTasks.splice(key, 1);
                })
                .catch(function(error) {
                    console.log("Error removing task");
                });
        },

        toggleStatus: function(task, status) {
            var self = this;
            axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            axios.post('/tasklist/toggleStatus', {
                    task: task
                })
                .then(function(response) {
                    if (status == "completed") {
                        self.completedTasks.push(task);
                        self.tasks.splice(task.key, 1);
                    }
                    if (status == "incomplete") {
                        self.tasks.push(task);
                        self.completedTasks.splice(task.key, 1);
                    }
                })
                .catch(function(error) {
                    console.log("Unable to toggle status");
                });
        },

        moveToCompletedTasks: function(key) {
            var task = this.tasks[key];
            task.key = key;
            task.completed_at = this.formatTimeString();

            var status = "completed";
            var toggle = this.toggleStatus(task, status);
        },

        unmarkCompletedTasks: function(key) {
            var task = this.completedTasks[key];
            task.key = key;
            var status = "incomplete";
            var toggle = this.toggleStatus(task, status);
        },

        formatTimeString: function() {
            var time = new Date();
            var hour = time.getHours();
            var minute = time.getMinutes();
            var ampm = hour >= 12 ? 'PM' : 'AM';
            
            hour = hour ? hour : 12; //midnight(00) should be 12.
            hour = hour > 12 ? hour - 12 : hour;
            hour = hour.toString().length < 2 ? "0" + hour : hour;
            minute = minute.toString().length < 2 ? "0" + minute : minute;

            var timeString = ("0" + time.getMonth()).slice(-2) + '/' + ("0" + time.getDate()).slice(-2) + '/' + time.getFullYear() +
                ' ' + hour + ':' + time.getMinutes() + ':' + time.getSeconds() + ' ' + ampm;

            return timeString;
        }
    }
})
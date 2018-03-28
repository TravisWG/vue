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
  			.then(function (response) {
    			self.tasks.push(response.data);
  			})
  			.catch(function (error) {
    			console.log("There was an error adding the new task")
  			});
		},

		removeTask: function(key) {
			var self = this;
			axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
			axios.post('/tasklist/removeTask', {    			
    			task: self.tasks[key]
  			})
  			.then(function (response) {
				self.tasks.splice(key, 1);
			})
			.catch(function (error) {
				console.log("Error removing task")
			});
		},

		removeCompletedTask: function(key) {
			var self = this;
			axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
			axios.post('/tasklist/removeTask', {    			
    			task: self.completedTasks[key]
  			})
  			.then(function (response) {
				self.completedTasks.splice(key, 1);
			})
			.catch(function (error) {
				console.log("Error removing task");
			});
		},

		toggleStatus: function(task, status){
			var self = this;		
			axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
			axios.post('/tasklist/toggleStatus', {    			
    			task: task
  			})
  			.then(function (response) {
  				if(status == "completed"){
  					self.completedTasks.push(task);
					self.tasks.splice(task.key, 1);
  				}
  				if(status == "incomplete"){
					self.tasks.push(task);
					self.completedTasks.splice(task.key, 1);
  				}
			})
			.catch(function (error) {
				console.log("Unable to toggle status");
			});
		},

		moveToCompletedTasks: function(key){
			var task = this.tasks[key];
				task.key = key;
				task.completed_at = this.formatTimeString();
				
			var status = "completed";
			var toggle = this.toggleStatus(task, status);
		},

		unmarkCompletedTasks: function(key){
			var task = this.completedTasks[key];
				task.key = key;
			var status = "incomplete";			
			var toggle = this.toggleStatus(task, status);
		},

		formatTimeString: function(){
			var time = new Date();
			var dayOrNight = 'AM'
			var hour = time.getHours()
			if (hour > 12){
				hour = hour - 12;
				if (hour.toString().length < 2){
					hour = "0" + hour;
				}
				dayOrNight = 'PM';
			}
			var timeString = ("0" + time.getMonth()).slice(-2) + '/' + ("0" + time.getDate()).slice(-2) + '/' + time.getFullYear() +
							 ' ' + hour + ':' + time.getMinutes() + ':' + time.getSeconds() + ' ' + dayOrNight;

			return timeString;
		}
	}
})
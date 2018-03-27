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
			this.tasks.push({task: document.getElementById("addTask").value}); 
		},
		removeTask: function(key) {
			this.tasks.splice(key, 1);
		},
		moveToCompletedTasks: function(key){
			this.completedTasks.push(this.tasks[key]);
			this.removeTask(key);
		},
		removeCompletedTask: function(key) {
			this.completedTasks.splice(key, 1);
		},
		unmarkCompletedTasks: function(key){
			this.tasks.push(this.completedTasks[key]);
			this.removeCompletedTask(key);
		}
	}
})
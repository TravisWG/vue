var tasklist = new Vue({
	el: "#tasklist",
	data: {
		tasks: [
			{message:"Laundry"},
		 	{message: "Make Food"},
		 	{message:"Vacuum floor"}
		 ],
		 completedTasks: []

	},
	methods: {
		addTask: function() { 
			this.tasks.push({message: document.getElementById("addTask").value}); 
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
var tasklist = new Vue({
	el: "#tasklist",
	data: {
		items: [
			{message:"Laundry"},
		 	{message: "Make Food"},
		 	{message:"Vacuum floor"}
		 ]
	},
	methods: {
		addTask: function() { 
			console.log(document.getElementById("addItem").value);
			this.items.push({message: document.getElementById("addItem").value}); 
		},
		removeTask: function(key) {
			console.log(key);
			this.items.splice(key, 1);
		}
	}
})
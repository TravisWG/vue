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
			tasklist.items.push({message: document.getElementById("addItem").value}); 
		}
	}
})
var colleague = new Vue({
    el: "#colleague-search",
    data: {
        colleagues: null,
        inputError: false,
        errorMessage: false,

    },
    methods: {
        search: function() {
            this.inputError = false;
            this.emptySearch = false;
            this.colleagues = null;

            var self = this;
                nameValue = document.getElementById("search-name").value.trim();
                emailValue = document.getElementById("search-email").value.trim();

            if(nameValue || emailValue){
                axios.post('/colleagues/search', {
                        name: nameValue,
                        email: emailValue,
                    })
                    .then(function(response) {
                        
                        if(response.data.users){
                            console.log(response.data);
                            self.colleagues = response.data.users;
                        } else{
                            self.errorMessage = response.data.message;
                        }

                    })
                    .catch(function(error) {
                        console.log("Error retrieving search results");
                    });
            }
            else{
                self.inputError = true;
            }
        }
    }
})
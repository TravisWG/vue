var colleague = new Vue({
    el: "#colleagues",
    data: {
        colleagues: null,
    },
    mounted: function() {
        this.fetchData();
    },
    methods: {
        fetchData: function() {
            var self = this;
            axios.get('/colleagues/getColleagues')
                .then(response => {
                    self.colleagues = response.data;
                });
        }, 
    }
})

var colleagueSearch = new Vue({
    el: "#colleague-search",
    data: {
        colleagues: null,
        inputError: false,
        errorMessage: false,

    },
    methods: {
        search: function() {
            this.inputError = false;
            this.colleagues = null;
            this.errorMessage = false

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
                            self.colleagues = response.data.users;
                        } else{
                            self.errorMessage = response.data.message;
                        }

                    })
                    .catch(function(error) {
                        self.errorMessage = "Error retrieving search results";
                    });
            }
            else{
                self.inputError = true;
            }
        },

        addColleague: function(colleague) {
            var self = this;
            axios.post('/colleagues/requestAdd', {
                        id: colleague.id,
                    })
                    .then(function(response) {
                        colleague.requestMessage = "Request sent!";
                    })
                    .catch(function(error) {

                    });
        },

        cancelRequest: function(colleague) {
            var self = this;
            axios.post('/colleagues/cancelRequest', {
                        id: colleague.id,
                    })
                    .then(function(response) {
                        colleague.requestMessage = "Request canceled!";
                    })
                    .catch(function(error) {

                    });
        },
        
        requestReply: function(colleague, reply){
            axios.post('/colleagues/requestResponse', {
                        userId: colleague.id,
                        reply: reply,
                        colleague: true,
                    })
                    .then(function(response) {
                        if (response.data.status = 'success'){
                            if (reply == 'accept'){
                                colleague.requestMessage = 'Colleague request accepted.';
                            } else if (reply == 'deny'){
                                colleague.requestMessage = 'Colleague request denied.';
                            } else if (reply == 'block'){
                                colleague.requestMessage = 'Colleague blocked.';
                            }
                        }
                    })
                    .catch(function(error) {
                    });

        },

        unblockColleague: function(colleague){
            axios.post('/colleagues/unblockColleague', {
                        colleagueId: colleague.id,
                    })
                    .then(function(response) {
                        if (response.data.status = 'success'){
                            colleague.requestStatus = "notColleague"
                        }
                    })
                    .catch(function(error) {
                    });

        },

        removeColleague: function(colleague){
            axios.post('/colleagues/removeColleague', {
                        colleagueId: colleague.id,
                    })
                    .then(function(response) {
                        if (response.data.status = 'success'){
                            colleague.requestMessage = "Colleague removed."
                        }
                    })
                    .catch(function(error) {
                    });

        }
    }
})
var colleagueNotifications = new Vue({
    el: "#colleague-notifications",
    data: {
        colleagueRequests: []
    },
    mounted: function() {
        this.fetchData();
    },
    methods: {
        fetchData: function() {
            var self = this;
            axios.get('/colleagues/getColleagueRequests')
                .then(response => {
                    self.colleagueRequests = response.data;
                });
        },

        requestReply: function(colleagueRequest, response){
            axios.post('/colleagues/requestResponse', {
                        id: colleagueRequest.id,
                        response: response,
                    })
                    .then(function(response) {
                    })
                    .catch(function(error) {
                    });

        }
    }
})
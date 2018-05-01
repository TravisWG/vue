var colleagueNotifications = new Vue({
    el: "#colleague-notifications",
    data: {
        colleagueRequests: null,
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

        requestReply: function(colleagueRequest, reply){
            axios.post('/colleagues/requestResponse', {
                        id: colleagueRequest.id,
                        reply: reply,
                    })
                    .then(function(response) {
                        if (response.data.status = 'success'){
                            colleagueRequest.deleted_at = true;
                            if (reply == 'accept'){
                                colleagueRequest.accepted = true;
                            } else if (reply == 'deny'){
                                colleagueRequest.rejected = true;
                            } else if (reply == 'block'){
                                colleagueRequest.blocked = true;
                            }
                        }
                    })
                    .catch(function(error) {
                    });

        }
    }
})
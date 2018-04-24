@extends('partials.template')


@section('content')
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="content">
                            <div id="colleague-notifications">
                                <div class="row">
                                    <h1> Notifications</h1>
                                    <div class="col-md-6" v-for="colleagueRequest in colleagueRequests">                              
                                        <div class="list-item">
                                            <div class="col-md-6">
                                                You have received a colleague request!<br><br>
                                                <strong>@{{ colleagueRequest.sending_user.name }}</strong>
                                                <div class="small"> 
                                                    @{{ colleagueRequest.sending_user.email }}
                                                </div>
                                            </div>
                                            <div class="col-md-6" v-show="colleagueRequest.deleted_at == null">
                                                <div class="list-buttons">
                                                    <button v-on:click="requestReply(colleagueRequest, 'accept')">
                                                        <i class="fas fa-check"></i> 
                                                        Accept Request
                                                    </button>
                                                    <button v-on:click="requestReply(colleagueRequest, 'deny')">
                                                        <i class="fas fa-times"></i> 
                                                        Deny Request
                                                    </button>
                                                    <button v-on:click="requestReply(colleagueRequest, 'block')" class="stop-timer">
                                                        <i class="fas fa-ban"></i> 
                                                        Block User
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-6" v-show="colleagueRequest.accepted">
                                                Colleague request accepted.
                                            </div>
                                            <div class="col-md-6" v-show="colleagueRequest.rejected">
                                                Colleague request denied.
                                            </div>
                                            <div class="col-md-6" v-show="colleagueRequest.blocked">
                                                Colleague blocked.
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection

@section('scripts')
    <script src="/js/vue.js"></script>        
    <script src="/js/Notifications.js"></script>
@endsection
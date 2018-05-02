@extends('partials.template')


@section('content')
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="content">
                            <div id="colleagues">
                                <div class="row">
                                    <h1>Your Colleagues</h1>
                                    <div v-cloak v-show="colleagues" class="row">
                                        <div class="col-md-6" v-for="colleague in colleagues">
                                            <div class="list-item">
                                                <div class="col-md-7 list-text">
                                                    @{{ colleague.colleague_user.name }}<br>
                                                    <div class="small">
                                                        @{{ colleague.colleague_user.email  }}
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="list-buttons">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>               
                                    </div>
                                </div>
                            </div>
                            <div id="colleague-search">
                                <div class="row">
                                    <h1> Search for Colleagues</h1>
                                    <div class="col-md-6">
                                        Find colleagues by name or email address:
                                    </div>
                                    <div class="col-md-6">
                                        <div v-cloak>
                                            <div v-show="inputError" class="errors">
                                                You must enter search parameters.
                                            </div>
                                            <label>Name</label>
                                            <input type="text" id="search-name" name="search"><br>
                                            <label>Email</label>
                                            <input type="text" id="search-email" name="search"><br>
                                            <button v-on:click="search()" type="submit">Search</button>
                                        </div>
                                    </div>
                                </div>
                                <div v-show="colleagues || errorMessage" class="row">
                                    <div class="col-md-6" v-cloak v-for="colleague in colleagues">
                                        <div class="list-item">
                                            <div class="col-md-7 list-text">
                                                @{{ colleague.name }}<br>
                                                <div class="small">
                                                    @{{ colleague.email }}
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div v-show="colleague.requestMessage == null">
                                                    <div class="list-buttons" v-show="colleague.requestStatus == 'notColleague'">
                                                        <button  v-on:click="addColleague(colleague)">Add Colleague</button>
                                                    </div>

                                                    <div class="list-buttons" v-show="colleague.requestStatus == 'requestPending'">                                                    
                                                        Request Pending.
                                                        <button  v-on:click="cancelRequest(colleague)">Cancel Request</button>
                                                    </div>

                                                    <div class="list-buttons" v-show="colleague.requestStatus == 'requested'">                                                    
                                                        Colleague has requested to add you.
                                                        <button v-on:click="requestReply(colleague, 'accept')">
                                                            <i class="fas fa-check"></i> 
                                                            Accept Request
                                                        </button>
                                                        <button v-on:click="requestReply(colleague, 'deny')">
                                                            <i class="fas fa-times"></i> 
                                                            Deny Request
                                                        </button>
                                                        <button v-on:click="requestReply(colleague, 'block')">
                                                            <i class="fas fa-ban"></i> 
                                                            Block User
                                                        </button>
                                                    </div>

                                                    <div class="list-buttons" v-show="colleague.requestStatus == 'blocked'">                                                    
                                                        You have blocked the user.
                                                        <button  v-on:click="unblockColleague(colleague)">Unblock</button>
                                                    </div>

                                                    <div class="list-buttons" v-show="colleague.requestStatus == 'currentColleague'">                                                    
                                                        Already your colleague.
                                                        <button  v-on:click="removeColleague(colleague)">Remove Colleague</button>
                                                    </div>
                                                </div>
                                                <div class="list-message" v-show="colleague.requestMessage != null">                                                     
                                                    @{{ colleague.requestMessage }} 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-cloak v-show="errorMessage">
                                        <h3>@{{errorMessage}}</h3>
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
    <script src="/js/colleague.js"></script>
@endsection
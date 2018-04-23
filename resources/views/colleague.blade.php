@extends('partials.template')


@section('content')
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="content">
                            <div id="colleagues">
                                <div class="row">
                                    <h1>Your Colleagues</h1>
                                    <div v-show="colleagues" class="row">
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
                                        <div class="">
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
                                    <div class="col-md-6" v-for="colleague in colleagues">
                                        <div class="list-item">
                                            <div class="col-md-7 list-text">
                                                @{{ colleague.name }}<br>
                                                <div class="small">
                                                    @{{ colleague.email }}
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="list-buttons" v-show="colleague.requestMessage == null">
                                                    <button  v-on:click="addColleague(colleague)">Add Colleague</button>
                                                </div>
                                                <div class="list-message" v-show="colleague.requestMessage != null">                                                    
                                                    @{{ colleague.requestMessage }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-show="errorMessage">
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
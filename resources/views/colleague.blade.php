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
                    @include('partials.colleague-search')                            
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/vue.js"></script>        
    <script src="/js/colleague.js"></script>
@endsection
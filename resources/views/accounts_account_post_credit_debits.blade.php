@extends('layouts.mofad')

@section('head')
    @parent()
@endsection()

@section('side_nav')
@parent()
@endsection

@section('top_nav')
    @parent()
@endsection

@section('content')
<div class="col s12 m12 l12">
      @include('includes.post_status')
        <div class="card">
            <div class="card-content">
                <p class="caption mb-0">{{$account->account_name}} : Post To account
                    <a href="{{url()->previous()}}" class=" pull-right  btn  waves-effect waves-light cyan darken-1 right" >Back
                    </a>
                </p>
            </div>
        </div>
        <div id="form-with-validation" class="card card card-default scrollspy col m6">
            <div class="card-content">
                <h4 class="card-title"> CREDIT:  {{$account->account_name}}</h4>
                <form action="{{url()->current()}}" method="POST" >
                  {{csrf_field()}}
                
                    <div class="row">
                        <div class="input-field ">
                            
                            <label class="bmd-label-floating">Credit Amount</label>
                            <input type="number" min="0" step="0.01" value="{{old('credit_amount')}}"  name="credit_amount" class="form-control">
                            <input type="hidden" name="transaction_type" value="CREDIT"/>
                        </div>
                    </div>
                    <div class="row">

                        <div class="input-field  ">
                            
                            
                            <textarea id="icon_prefix2" class="materialize-textarea" name="bank_reference" ></textarea>
                            <label for="icon_prefix2">comment/Description</label>
                            
                        </div>

                    </div>
                    <div class="row">              
                        <div class="input-field col s8">
                            <button class="btn cyan waves-effect waves-light green darken-1 right" type="submit" name="action">Credit Account
                                <i class="material-icons right">send</i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
          </div>


          <div id="form-with-validation" class="card card card-default scrollspy col m6">
          <div class="card-content">
                <h4 class="card-title"> DEBIT:  {{$account->account_name}}</h4>
                <form action="{{url()->current()}}" method="POST" >
                  {{csrf_field()}}
                
                    <div class="row">
                        <div class="input-field ">
                            
                            <label class="bmd-label-floating">Credit Amount</label>
                            <input type="number" min="0"  step="0.01" value="{{old('debit_amount')}}"  name="debit_amount" class="form-control">
                            <input type="hidden" name="transaction_type" value="DEBIT"/>
                        </div>
                    </div>
                    <div class="row">

                        <div class="input-field  ">
                            
                            
                            <textarea id="icon_prefix2" class="materialize-textarea" name="description" ></textarea>
                            <label for="icon_prefix2">comment/Description</label>
                            
                        </div>

                    </div>
                    <div class="row">              
                        <div class="input-field col s8">
                            <button class="btn  waves-effect waves-light red darken-1 right" type="submit" name="action">DEBIT Account
                                <i class="material-icons right">send</i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
          </div>
    </div>  
@endsection

@section('footer')
@parent()
@endsection

@section('footer_scripts')
@parent()
@endsection
    
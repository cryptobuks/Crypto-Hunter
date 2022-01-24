<?php
  if (Auth::user()->dashboard_style == "light") {
    $bg="light";
    $text = "dark";
  } else {
    $bg="dark";
    $text = "light";
  }
?>
@extends('layouts.app')
    @section('content')
        @include('user.topmenu')
        @include('user.sidebar')
        <div class="main-panel bg-{{$bg}}">
      <div class="content bg-{{$bg}}">
        <div class="page-inner">
          <div class="mt-2 mb-4">
            <h1 class="title1 text-{{$text}}">Make Payment</h1>
          </div>
          @if(Session::has('message'))
            <div class="row">
              <div class="col-lg-12">
                <div class="alert alert-info alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <i class="fa fa-info-circle"></i> {{ Session::get('message') }}
                </div>
              </div>
            </div>
          @endif
          @if(count($errors) > 0)
            <div class="row">
              <div class="col-lg-12">
                <div class="alert alert-danger alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  @foreach ($errors->all() as $error)
                  <i class="fa fa-warning"></i> {{ $error }}
                  @endforeach
                </div>
              </div>
            </div>
                  @endif
          <div class="row">
            <div class="col card bg-{{$bg}} shadow-lg p-4">
              @if($title=="Complete Payment")
                <div class="alert-success text-center p-5">
                  <h4 class="text-{{$text}}">You are to send <strong>{{$amount}} {{$coin}}</strong> to the address below or scan the QR code to complete payment.</h4>
                  <h4 class="text-{{$text}}"><strong>{{$p_address}}</strong></h4><br>
                  <img width="220" height="220" alt="Payment QR code" src="{{$p_qrcode}}">
                </div>
              @elseif($title == "Pay with card")
                <form action="charge" method="post">
                  <input type="hidden" name="_token" value="{{csrf_token()}}">
                  <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="{{$settings->s_p_k}}"
                    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                    data-name="{{$settings->site_name}}"
                    data-description="Account fund"
                    data-amount="{{$t_p}}"
                    data-locale="auto">
                  </script>
                </form>
              @else
              <div class="mb-3 text-{{$text}}">
                <h4>You are to make payment of <strong>{{$settings->currency}}{{$amount}}</strong> using your preferred mode of payment below.</h4>
                <?php 
                  $pmodes = str_split($settings->payment_mode);
                ?>
              </div>
              <div class="row">
                @foreach($pmodes as $pmode)
                  @if($pmode==1)
                  <div class="col-lg-4">
                    <div class="card bg-{{$bg}} shadow text-{{$text}}">
                      <div class="card-body">
                        <h4>
                          <a style="text-decoration:none;" class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#bank">
                          <strong>Bank deposit/transfer </strong>
                          <img src="{{ asset('home/images/bank-transfer.png')}}" width="70px;" height="40px;"> 
                          </a>
                        </h4>
                        <div id="bank" class="panel-collapse collapse">
                          <div class="">
                            <h4 class="text-{{$text}}"><strong>Bank name:</strong> {{$settings->bank_name}}.</h4>
                            <h4 class="text-{{$text}}"><strong>Account name:</strong> {{$settings->account_name}}.</h4>
                            <h4 class="text-{{$text}}"><strong>Account number:</strong> {{$settings->account_number}}.</h4>
                          </div>
                        </div>  
                      </div>
                    </div>
                  </div>
                  @endif
                  @if($pmode==2)
                  <div class="col-lg-4">
                    <div class="card bg-{{$bg}} shadow text-{{$text}}">
                      <div class="card-body">
                        <h4>
                          <a style="text-decoration:none;" class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#btc">
                          <strong>Bitcoin</strong>
                          <img src="{{ asset('home/images/btc.png')}}" width="40px;" height="40px;">
                          </a>
                        </h4>
                        <div id="btc" class="panel-collapse collapse">
                          <div class="">
                            <h4 class="text-{{$text}}">
                            <strong>BTC Address:</strong> {{$settings->btc_address}}
                            
                            <br/><br/>
                            @if($settings->withdrawal_option != "manual")
                            <a href="{{ url('dashboard/cpay') }}/{{$amount}}/BTC/{{ Auth::user()->id }}/new" class="btn btn-{{$text}}">Automatic payment method</a>
                            @endif
                            </h4>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endif
                  @if($pmode==2)
                  <div class="col-lg-4">
                    <div class="card bg-{{$bg}} shadow text-{{$text}}">
                      <div class="card-body">
                        <h4>
                          <a style="text-decoration:none;" class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#usdt">
                          <strong>USDT</strong>
                          <img src="{{ asset('home/images/usdt.png')}}" width="40px;" height="40px;">
                          </a>
                        </h4>
                        <div id="usdt" class="panel-collapse collapse">
                          <div class="">
                            <h4 class="text-{{$text}}">
                            <strong>USDT Address:</strong> {{$settings->usdt_address}}
                            
                            <br/><br/>
                            @if($settings->withdrawal_option != "manual")
                            <a href="{{ url('dashboard/cpay') }}/{{$amount}}/USDT.TRC20/{{ Auth::user()->id }}/new" class="btn btn-{{$text}}">Automatic payment method</a>
                            @endif
                            </h4>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endif
                  @if($pmode==3)
                  <div class="col-lg-4">
                    <div class="card bg-{{$bg}} shadow text-{{$text}}">
                      <div class="card-body">
                        <h4>
                          <a style="text-decoration:none;" class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#eth">
                          <strong>Ethereum</strong>
                          <img src="{{ asset('home/images/eth.png')}}" width="40px;" height="40px;">
                          </a>
                        </h4>
                        <div id="eth" class="panel-collapse collapse">
                          <div class="">
                            <h4 class="text-{{$text}}">
                            <strong>ETH Address:</strong> {{$settings->eth_address}}
                            
                            <br/><br/>
                            @if($settings->withdrawal_option != "manual")
                            <a href="{{ url('dashboard/cpay') }}/{{$amount}}/ETH/{{ Auth::user()->id }}/new" class="btn btn-{{$text}}">Automatic payment method</a>
                            @endif
                            </h4>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endif
                  @if($pmode==4)
                  <div class="col-lg-4">
                    <div class="card bg-{{$bg}} shadow text-{{$text}}">
                      <div class="card-body">
                        <h4>
                          <a style="text-decoration:none;" class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#ltc">
                          <strong>Litecoin</strong>
                          <img src="{{ asset('home/images/ltc.png')}}" width="40px;" height="40px;">
                          </a>
                        </h4>
                        <div id="ltc" class="panel-collapse collapse">
                          <div class="">
                            <h4 class="text-{{$text}}">
                            <strong>LTC Address:</strong> {{$settings->ltc_address}}
                            <br/><br/>
                            @if($settings->withdrawal_option != "manual")
                            <a href="{{ url('dashboard/cpay') }}/{{$amount}}/LTC/{{ Auth::user()->id }}/new" class="btn btn-{{$text}}">Automatic payment method</a>
                            @endif
                            </h4>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endif
                  @if($pmode==5)
                  <div class="col-lg-4">
                    <div class="card bg-{{$bg}} shadow text-{{$text}}">
                      <div class="card-body">
                        <h4 class="text-{{$text}}">
                          <a style="text-decoration:none;"  class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#stripe">
                          <strong>Credit card 
                          <img src="{{ asset('home/images/c3.jpg')}}" width="70px;" height="40px;"> 
                          <img src="{{ asset('home/images/c2.jpg')}}" width="70px;" height="40px;">
                          </strong>
                          </a>
                        </h4>
                        <div id="stripe" class="panel-collapse collapse">
                          <div class="">
                            <h4 class="text-{{$text}}"> <br>
                            <a href="{{ url('dashboard/paywithcard') }}/{{$amount}}" class="btn btn-{{$text}}">Pay with card</a>
                            
                            </h4>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endif
                  @if($pmode==6)
                  <div class="col-lg-4">
                    <div class="card bg-{{$bg}} shadow text-{{$text}}">
                      <div class="card-body">
                        <h4 class="text-{{$text}}">
                          <a style="text-decoration:none;" class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#paypal">
                          <strong>PayPal</strong> <img src="{{ asset('home/images/pp.png')}}" width="40px;" height="40px;">
                          </a>
                        </h4>
                        <div id="paypal" class="panel-collapse collapse">
                          <h4 class="text-{{$text}}">
                            @include('includes.paypal')
                          </h4>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endif
                @endforeach
              </div> <br> <br>
              {{-- <div class=" shadow bg-{{$bg}} p-3">
                <h4>Contact management at <strong>{{$settings->contact_email}}</strong> for other payment methods.</h4>
              </div>   --}}
              <div>
                <form method="post" action="{{action('SomeController@savedeposit')}}" enctype="multipart/form-data">
                    <h5 class="text-{{$text}}">Upload Payment proof after payment. (Ignore if paid with card).</h5>
                    <input type="file" name="proof" class="form-control col-lg-4 bg-{{$bg}} text-{{$text}}" required>
                  <br>
                  
                  <h5 class="text-{{$text}}">Payment Mode Used:</h5>
                  <select name="payment_mode" class="form-control col-lg-4 bg-{{$bg}} text-{{$text}}" required>
                    <!--<option>Bank transfer</option>-->
                    <!--<option>Ethereum</option>-->
                    <option>USDT.TRC20</option>
                    <option>Bitcoin</option>
                    <!--<option>Credit card</option>-->
                  </select>
                  <br> <br>
                  <div >
                    <input type="submit" class="btn btn-{{$text}}" value="Submit payment">
                  </div> 
                  <input type="hidden" name="amount" value="{{$amount}}">
                  <input type="hidden" name="pay_type" value="{{$pay_type}}">
                  <input type="hidden" name="plan_id" value="{{$plan_id}}">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
              </div>
              @endif
            </div>
          </div>







        </div>
      </div>
    @endsection

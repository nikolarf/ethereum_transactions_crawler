@extends('layouts.app')

@section('content')
<div class="container">
    
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card flex">
              <div class="row">
                <div class="col-md-4" style="margin:auto;">
                  <ul class="list-group text-center">
                    <li class="list-group-item"> <img src="{{ asset('/img/bitcoin.png') }}" width="20%">1 ETH = {{ $arr['btc'] }} BTC</li>
                    <li class="list-group-item"> <img src="{{ asset('/img/euro.png') }}" width="20%">  1 ETH = {{ $arr['eur'] }} EUR</li>
                  </ul>
                </div>
                <div class="col-md-4 d-flex justify-content-center py-3 img-fluid" width="30%" height="30%" alt="">
                  <img src="{{ asset('/img/ethereum.jpg') }}" class="img-fluid" >
                </div>
                <div class="col-md-4" style="margin:auto;">
                  <ul class="list-group text-center">
                    <li class="list-group-item"> <img src="{{ asset('/img/us.png') }}" width="20%">  1 ETH = {{ $arr['usd'] }} USD</li>
                    <li class="list-group-item"> <img src="{{ asset('/img/canada.png') }}" width="20%">  1 ETH = {{ $arr['cad'] }} CAD</li>
                  </ul>
                </div>
              </div>
                <div class="d-flex justify-content-center py-3">
                    
                </div>
                
                <h2 class="text-center pt-4">Ethereum Transactions</h2>
                <div class="card-body">
                    <form class="row g-3 needs-validation" action="{{ route('getNormalTransactions') }}">
                        <div class="col-md-6">
                          <label for="validationCustom01" class="form-label">Wallet</label>
                          <input type="text" class="form-control" id="validationCustom01" value="{{old('address')}}" required placeholder="Input Address" name="address">
                        </div>
                        <div class="col-md-2">
                          <label for="validationCustom02" class="form-label">First Block *</label>
                          <input type="text" class="form-control" id="validationCustom02" value="{{old('first')}}" placeholder="Optional" name="first">
                        </div>
                        <div class="col-md-2">
                            <label for="validationCustom02" class="form-label">End Block *</label>
                            <input type="text" class="form-control" id="validationCustom02" value="{{old('end')}}" placeholder="Optional" name="end">
                        </div>
                        <div class="col-md-2">
                            <label for="button1" class="form-label">Search</label>
                            <button id="button1" class="btn btn-primary form-control" type="submit">Normal</button>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                  <form class="row g-3 needs-validation" action="{{ route('getInternalTransactions') }}">
                      <div class="col-md-6">
                        <label for="validationCustom01" class="form-label">Wallet</label>
                        <input type="text" class="form-control" id="validationCustom01" value="{{old('address')}}" required placeholder="Input Address" name="address">
                      </div>
                      <div class="col-md-2">
                        <label for="validationCustom02" class="form-label">First Block *</label>
                        <input type="text" class="form-control" id="validationCustom02" value="{{old('first')}}" placeholder="Optional" name="first">
                      </div>
                      <div class="col-md-2">
                          <label for="validationCustom02" class="form-label">End Block *</label>
                          <input type="text" class="form-control" id="validationCustom02" value="{{old('end')}}" placeholder="Optional" name="end">
                      </div>
                      <div class="col-md-2">
                          <label for="button1" class="form-label">Search</label>
                          <button id="button1" class="btn btn-primary form-control" type="submit">Internal</button>
                      </div>
                  </form>
              </div>
                <div class="card-body">
                  <form class="row g-3 needs-validation" action="{{ route('getTimeTransactions') }}">
                      <div class="col-md-6">
                        <label for="Custom01" class="form-label">Wallet</label>
                        <input type="text" class="form-control" id="Custom01" value="{{old('address')}}" required placeholder="Input Address" name="address">
                      </div>
                      <div class="col-md-2">
                        <label for="Custom02" class="form-label">Date Picker</label>
                        <div class="input-group date" id="datepicker">
                            <input type="text" class="form-control" name="time">
                              <span class="input-group-append">
                              <span class="input-group-text bg-white d-block">
                                <i class="fa fa-calendar"></i>
                              </span>
                            </span>
                        </div>
                      </div>
                      <div class="col-md-2">
                      </div>
                      <div class="col-md-2">
                          <label for="button1" class="form-label">Search</label>
                          <button id="button1" class="btn btn-primary form-control" type="submit">Date</button>
                      </div>
                  </form>
              </div>
            </div>
        </div>
        @if(isset($dataUrlNormal))
          <h2 class="text-center pt-4">Normal Transaction</h2>
          <br>
          <table class="table table-hover table-bordered border-primary">
            @if(count($dataUrlNormal)>0)
              <thead>
                <tr>
                  <th scope="col">Hash</th>
                  <th scope="col">Block</th>
                  <th scope="col">Time</th>
                  <th scope="col">From</th>
                  <th scope="col">To</th>
                </tr>
              </thead>

              @foreach ($dataUrlNormal as $data)

                  <tbody>
                    <tr>
                      <th scope="row">{{ $data->hash }}</th>
                      <td>{{ $data->blockNumber }}</td>
                      <td>{{ date('m/d/Y H:i:s', $data->timeStamp) }}</td>
                      <td>{{ $data->from }}</td>
                      <td>{{ $data->to }}</td>
                    </tr>
                  </tbody>
              
              @endforeach
            @else
              <h2 style="color:red;" class="text-center">No data</h2>
            @endif      
          </table>
          <div class="d-flex justify-content-center">
            {{ ($dataUrlNormal->links()) }}
          </div>
        @endif
        @if(isset($dataUrlInternal))
        <h2 class="text-center pt-4">Internal Transaction</h2>
        <br>
        <table class="table table-hover table-bordered border-primary">
          @if(count($dataUrlInternal)>0)
            <thead>
              <tr>
                <th scope="col">Hash</th>
                <th scope="col">Block</th>
                <th scope="col">Time</th>
                <th scope="col">From</th>
                <th scope="col">To</th>
              </tr>
            </thead>
            
            @foreach ($dataUrlInternal as $data)

                <tbody>
                  <tr>
                    <th scope="row">{{ $data->hash }}</th>
                    <td>{{ $data->blockNumber }}</td>
                    <td>{{ date('m/d/Y H:i:s', $data->timeStamp) }}</td>
                    <td>{{ $data->from }}</td>
                    <td>{{ $data->to }}</td>
                  </tr>
                </tbody>
            
            @endforeach
          @else
          <h2 style="color:red;" class="text-center">No data</h2>
          @endif
         
        </table>
        <div class="d-flex justify-content-center">
          {{ ($dataUrlInternal->links()) }}
        </div>
        @endif
        @if(isset($dataUrlTime))
        <table class="table table-hover table-bordered border-primary">
          <h3 class="text-center pt-4">Exact value of ETH that was available on the given address at YYYY-MM-DD 00:00 UTC time</h3>
          <br>
          @if(count($dataUrlTime)>0)
            <thead>
              <tr>
                <th scope="col">Hash</th>
                <th scope="col">Block</th>
                <th scope="col">Time</th>
                <th scope="col">From</th>
                <th scope="col">To</th>
              </tr>
            </thead>
            
            @foreach ($arr_time as $data)

                <tbody>
                  <tr>
                    <th scope="row">{{ $data->hash }}</th>
                    <td>{{ $data->blockNumber }}</td>
                    <td>{{ date('m/d/Y H:i:s', $data->timeStamp) }}</td>
                    <td>{{ $data->from }}</td>
                    <td>{{ $data->to }}</td>
                  </tr>
                </tbody>
            
            @endforeach
          @else
          <h2 style="color:red;" class="text-center">No data</h2>
          @endif
         
        </table>
        <br>
        <h2>Exact value of ETH at given time: {{ $arr_time[0]->value -  $arr_time[0]->gasPrice/1000000000000000000 * $arr_time[0]->gasUsed }}</h2>
        @php
          echo "<pre>";
          print_r($arr_time);
          echo "</pre>";
        @endphp
        @endif
    </div>
</div>

@endsection

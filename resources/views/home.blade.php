@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Amount</th>
                            <th>Transaction ID</th>
                            <th>Time</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($transactions))
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{$transaction->client_name}}</td>
                                    <td>{{$transaction->phone}}</td>
                                    <td>{{$transaction->amount}}</td>
                                    <td>{{$transaction->transaction_id}}</td>
                                    <td>{{$transaction->transaction_time}}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', '我的推广')

@section('content')

    @card
    @slot('header', '我的推广')

    <div class="card">
        <div class="card-body">
            {{--                        <h4 class="card-title">{{ $order->time }}</h4>--}}
            <p class="card-text">总佣金收益：{{ $sum }}元</p>
            <p class="card-text">待收收益：{{ $incomeAmount }}元</p>
            <p class="card-text">今日收益{{ $todayAmount}}元</p>
            <a href="{{ route('root')}}" class="btn btn-primary">回首页</a>
        </div>
    </div>
    <br>
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link active">待收益</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('orders.history')}}">历史收益</a></li>

        @if ($inviteCode)
            <li class="nav-item"><a class="nav-link" href="{{ route('orders.invite')}}">邀请收益</a></li>@endif
    </ul>
    <ul class="list-group">

        @foreach ($incomeOrders as $order)
            <div class="card">
                <img class="card-img-top" src="{{ $order->imageUrl }}">
                <div class="card-body">
                    {{--                        <h4 class="card-title">{{ $order->time }}</h4>--}}
                    <p class="card-text">{{ $order->name }}</p>
                    <p class="card-text">{{ $order->time }} {{ $order->statusDesc}}</p>
                    <p class="card-text"> @if ($order->fail_reason) {{ $order->fail_reason}} @else 待收益:
                        :{{$order->promotion}}元@endif</p>

                    {{--<a href="#" class="btn btn-primary">See Profile</a>--}}
                </div>
            </div>
        @endforeach
        @if (!count($incomeOrders))
                <div class="card">
                    <div class="card-body">暂无信息</div>
                </div>
            @endif
    </ul>
    <div class="my-3">{{ $incomeOrders->links() }}</div>




    @endcard

@endsection

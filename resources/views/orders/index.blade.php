@extends('layouts.app')

@section('title', '我的推广')

@section('content')

    @card
    @slot('header', '我的推广')

    <ul class="list-group">
        <li class="list-group-item">
            {{--<span>待收收益收益{{ $incomeAmount}}元</span>--}}
            <span> 总佣金收益：{{ $sum }}元 </span>
            <span> 待收收益：{{ $incomeAmount }}元 </span>
            <span> 今日收益{{ $todayAmount}}元 </span>
            <span style="float: right"><a href="{{ route('root')}}">回首页</a></span>

        </li>
    </ul>
    <br>
    <ul class="nav">
        <li class="list-group-item active">待收益推广</li>
        <li class="list-group-item"><a href="{{ route('orders.history')}}" >已完成推广</a></li>
        @if ($inviteCode)  <li class="list-group-item"><a href="{{ route('orders.invite')}}" >邀请收益</a></li>@endif
    </ul>
    <ul class="list-group">
            <table class="table mb-0">
                {{--<thead>--}}
                {{--<tr class="text-center">--}}
                    {{--<th>商品</th>--}}
                    {{--<th class="text-left">时间</th>--}}
                    {{--<th>商品名称</th>--}}
                    {{--<th>实际支付金额</th>--}}
                    {{--<th>状态</th>--}}
                    {{--<th>抽佣</th>--}}
                {{--</tr>--}}
                {{--</thead>--}}
                <tbody>
                @foreach ($incomeOrders as $order)
                    <tr>
                        <td class="product-info">
                            <div class="preview">
                                <img src="{{ $order->imageUrl }}" height="100px">
                                </a>
                            </div>

                        </td>
                        <td class="product-info">{{ $order->time }}</td>
                        <td class="product-info">{{ $order->name }}</td>

                        <td class="sku-amount text-center">{{ $order->amount }}元</td>
                        <td class="sku-amount text-center">{{ $order->statusDesc}}</td>
                        <td class="sku-amount text-center">待收益:{{$order->promotion}}元</td>
                    </tr>
                @endforeach
                @if (!count($incomeOrders))
                    <tr>
                        <td>暂无信息</td>

                    </tr>
                @endif
                </tbody>
            </table>
    </ul>
            <div class="my-3">{{ $incomeOrders->links() }}</div>




    @endcard

@endsection

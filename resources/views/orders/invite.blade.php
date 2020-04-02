@extends('layouts.app')

@section('title', '我的邀请')

@section('content')

    @card
    @slot('header', '我的邀请')

    <ul class="list-group">
        <li class="list-group-item">
            <span>总佣金收益:{{ $sum }}元</span>
            <span>待收收益:{{ $incomeAmount }}元</span>
            <span>今日收益{{ $todayAmount}}元</span>
            <span style="float: right"><a href="{{ route('root')}}">回首页</a></span>

        </li>
    </ul>
    <br>
    <ul class="nav">
        <li class="list-group-item"><a href="{{ route('orders.income')}}">待收益推广</a></li>
        <li class="list-group-item"><a href="{{ route('orders.history')}}">已完成推广</a></li>
        <li class="list-group-item active">邀请收益</li>
    </ul>

    <ul class="list-group">
        <li class="list-group-item">我的邀请链接: <input id="foo" value="{{$inviteLink}}">
            <button class="btn" data-clipboard-target="#foo">点击复制</button>
        </li>
        <li class="list-group-item">
            <table class="table mb-0">
                {{--<thead>--}}
                {{--<tr class="text-center">--}}
                {{--<th>商品</th>--}}
                {{--<th class="text-left">时间</th>--}}
                {{--<th>商品名称</th>--}}
                {{--<th>实际支付金额</th>--}}
                {{--<th>状态</th>--}}
                {{--<th>抽佣</th>--}}
                {{--<th>失败原因</th>--}}
                {{--</tr>--}}
                {{--</thead>--}}
                <tbody>
                @foreach ($invites as $order)
                    <tr>
                        <td class="product-info">邀请用户:{{ $order->name }}</td>
                        <td class="product-info">奖励:{{ intval($order->benefit/100) }}元</td>
                    </tr>
                @endforeach
                @if (!count($invites))
                    <tr>
                        <td>暂无信息</td>

                    </tr>
                @endif
                </tbody>
            </table>
            <div class="my-3">{{ $invites->links() }}</div>
        </li>
        <li class="list-group-item">邀请用户赚取的佣金超过{{$effectiveInvite}}元,就可以获得{{$inviteReward}}元奖励哦,马上去邀请新人吧!</li>
    </ul>
    @endcard

@endsection
@push('script')
    <script>
        $(function() {
            new ClipboardJS('.btn');
        })
    </script>
@endpush


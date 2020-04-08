@extends('layouts.app')

@section('title', '我的邀请')

@section('content')

    @card
    @slot('header', '我的邀请')

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
        <li class="nav-item"><a class="nav-link" href="{{ route('orders.income')}}">待收益</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('orders.history')}}">历史收益</a></li>
        <li class="nav-item"><a class="nav-link active">邀请收益</a></li>
    </ul>

    <ul class="list-group">
        <li class="list-group-item">我的邀请链接: <input id="foo" value="{{$inviteLink}}">
            <button class="copy btn btn-light" data-clipboard-target="#foo">点击复制</button>
        </li>
        <li class="list-group-item">
            <table class="table mb-0">
                <tbody>
                @foreach ($invites as $order)
                    <tr>
                        <td class="product-info">邀请用户:{{ $order->name }}</td>
                        @if ($order->benefit)
                            <td class="product-info"> @if ($order->status==1)已到账@else 即将到账@endif:{{ intval($order->benefit/100) }}元
                            </td>
                        @else
                            <td class="product-info">邀请用户还没有成交订单</td>
                        @endif
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
        <li class="list-group-item">邀请用户成交一单,就可以获得{{$inviteReward}}元奖励哦,马上去邀请新人吧!</li>
    </ul>
    @endcard

@endsection
@push('script')
    <script>
        $(function () {
            clipboard = new ClipboardJS('.copy');

            clipboard.on('success', function (e) {
                console.info('s.Action:', e.action);
                console.info('s.Text:', e.text);
                $('.copy').html('复制成功')
                // console.info('s.Trigger:', e.trigger);

                e.clearSelection();
            });
        })
    </script>
@endpush


@extends('layouts.app')

@section('title', '我的账户')

@section('content')

    @card
    @slot('header', '我的账户')

    <ul class="list-group">
        <li class="list-group-item">
            <span> 我的账户:{{ $name }} </span>
            <span> 我的余额:{{ $sum }}元 </span>
            <span style="float: right"><a href="{{ route('root')}}">回首页</a></span>

        </li>
        <li class="list-group-item">请输入提现金额: <input id="amount" value="{{$sum}}">
            <button class="btn" onclick="withdraw()">点击提现</button>
        </li>
        <li class="list-group-item">
            <table class="table mb-0">
                <thead><tr>提现记录:</tr></thead>
                <tbody>
                @foreach ($withdraws as $item)
                    <tr>
                        <td class="product-info">{{ $item->created_at }}</td>
                        <td class="product-info">-{{ round($item->amount/100,2) }}元</td>
                        <td class="product-info">{{ $item->status =='0'?'处理中':'已完成' }}</td>
                        {{--<td class="product-info">{{ intval($item->withdraw_account) }}</td>--}}
                    </tr>
                @endforeach
                @if (!count($withdraws))
                    <tr>
                        <td>暂无提现记录</td>

                    </tr>
                @endif
                </tbody>
            </table>
            <div class="my-3">{{ $withdraws->links() }}</div>
        </li>
        <li class="list-group-item">提现金额必须在1-100元之间,提现审核通过后,金额将存入您的微信中,如有问题,请咨询客服</li>
    </ul>
    @endcard

@endsection


@push('script')
    <script>
        function withdraw() {
            data = {'amount': $("#amount").val()};

            axios.post('{{ route('users.withdrawSubmit')}}', data).then(function (result) {

                alert(result.data.msg?result.data.msg:'提现申请成功');
               if (!result.data.msg) {
                   window.location.reload();
               }
            }).catch(function (error) {
                console.log(error);
                // if (error.response.msg) {
                //     swal(error.response.msg, '', 'error')
                // } else {
                //     swal('系统错误', '', 'error')
                // }
            })
        }
    </script>
@endpush


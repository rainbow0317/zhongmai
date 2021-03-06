@extends('layouts.app')

@section('title', '热销商品')

@section('content')

    @card
    @slot('header', '热销商品')

    {{-- 搜尋 篩選 --}}
    <div class="row">
        <div class="col">
            <search-bar :filters='{!! json_encode($filters) !!}' inline-template>
                <form action="{{ route('products.index') }}" class="form-inline serach-form" ref="serachForm">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" name="search" placeholder="搜索" requied v-model="search">
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary">搜索</button>
                        </div>
                    </div>

                    {{--<select class="form-control form-control-sm" name="orderby" v-model="orderby"--}}
                            {{--@change="submitSearchForm">--}}
                        {{--<option value="0">综合排序</option>--}}
                        {{--<option value="6">按销量排序</option>--}}
                        {{--<option value="2">按佣金占比排序</option>--}}
                        {{--<option value="1">按佣金比率升序</option>--}}
                        {{--<option value="3">按价格升序</option>--}}
                        {{--<option value="4">按价格降序</option>--}}
                        {{--<option value="5">按销量升序</option>--}}
                        {{----}}
                        {{--<option value="7">优惠券金额排序升序</option>--}}
                        {{--<option value="8">优惠券金额排序降序</option>--}}
                        {{--<option value="13">按佣金金额升序排序</option>--}}
                        {{--<option value="14">按佣金金额降序排序</option>--}}
                        {{--<option value="9">券后价升序排序</option>--}}
                        {{--<option value="10">券后价降序排序</option>--}}
                        {{--<option value="11">按照加入多多进宝时间升序</option>--}}
                        {{--<option value="12">按照加入多多进宝时间降序</option>--}}
                        {{--<option value="15">店铺描述评分升序</option>--}}
                        {{--<option value="16">店铺描述评分降序</option>--}}
                        {{--<option value="17">店铺物流评分升序</option>--}}
                        {{--<option value="18">店铺物流评分降序</option>--}}
                        {{--<option value="19">店铺服务评分升序</option>--}}
                        {{--<option value="20">店铺服务评分降序</option>--}}
                        {{--<option value="27">描述评分击败同类店铺百分比升序</option>--}}
                        {{--<option value="28">描述评分击败同类店铺百分比降序</option>--}}
                        {{--<option value="29">物流评分击败同类店铺百分比升序</option>--}}
                        {{--<option value="30">物流评分击败同类店铺百分比降序</option>--}}
                        {{--<option value="31">服务评分击败同类店铺百分比升序</option>--}}
                        {{--<option value="32">服务评分击败同类店铺百分比降序</option>--}}

                    {{--</select>--}}
                </form>
            </search-bar>
        </div>
    </div>

    {{-- 商品列表 --}}
    <div class="row products-list">
        @foreach($products as $product)
            <div class="col-sm-3 product-item">
                <div class="product-content">
                    <div class="top">
                        <div class="img">
                            <a target="_blank" href="http://{{ $pddLink.$product['goods_id'] }}">
                                <img src="{{ $product['goods_image_url'] }}" alt="">
                            </a>
                        </div>
                        <div class="price">
                            <b>券后价:</b>{{ $product['min_price']}}元&nbsp;&nbsp;
                            <b>佣金:</b>{{ $product['promotion']  }}
                            元
                            <div class="title">
                                <a target="_blank"
                                   href="http://{{$pddLink.$product['goods_id'] }}">{{ $product['goods_name'] }}</a>
                            </div>
                            <div class="bottom">
                                @if($product['has_coupon'])<b>{{ $product['coupon_discount'] }}元</b>
                                优惠券
                                <b>{{ $product['coupon_remain_quantity'] }}</b>张
                                @else
                                    <span>暂无优惠券</span>
                                @endif
                            </div>
                        </div>
                        <div class=" bottom">
                            <div class="sold_count">销量 <span>{{ $product['sales_tip'] }}</span></div>
                            <div class="review_count">
                                <div class="buttons">
                                    <button  data-param="test" class="btn btn-success btn-faver" onclick="promotion({{json_encode($product)}})">
                                        <div id="copyTarget" style="opacity: 0;"></div>
                                        立即推广
                                    </button>
                                </div>
                                {{--<button  onclick="promotion({{json_encode($product)}})">  立即推广</button>--}}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
        {{--<div style="">--}}
            <div id="foo" style="opacity:0"></div>
    {{--</div>--}}


    </div>

    @if (!count($products))
        <div class="text-center text-muted">
            目前无商品
        </div>
    @endif

    <div class="my-3" >{!! $products->appends(request()->input())->links() !!}</div>
    @endcard

@endsection
@push('script')
    <script>
        clipboard = new ClipboardJS(".copy", {
            text: function (trigger) {
                trigger.getAttribute('aria-label');
            }
        });

        clipboard.on('success', function(e) {
            console.info('s.Action:', e.action);
            console.info('s.Text:', e.text);
            $('.copy').html('复制成功')
            // console.info('s.Trigger:', e.trigger);

            e.clearSelection();
        });

        clipboard.on('error', function(e) {
            console.error('Action:', e.action);
            console.error('Trigger:', e.trigger);
        });

        function promotion(product) {
            let data = {
                'product': product.goods_id,
                'search_id': product.search_id
            };

            axios.post('{{ route('products.share')}}', data).then(function (result) {

                if (product.text){
                    infos = product.text
                        + '<br> 抢购链接:<a href="'+ result.data.short_url+'">' + result.data.short_url+'</a>';
                } else{
                    infos =  product.goods_name +'<br>原价:' + product.min_group_price + ' 元<br/>券后价:' + product.min_price + ' 元<br/ >'
                        + '抢购链接:<a href="'+ result.data.short_url+'">' + result.data.short_url+'</a>';
                }

                $("#foo").html(infos);

               infos = infos +'<br><button class="copy btn btn-light" data-clipboard-target="#foo">点击复制文案</button> '

                swal({
                    html: infos,
                    imageUrl: product.goods_image_url,
                    animation: true, //控制是否有动画
                    confirmButtonText: '确定',
                });


            }).catch(function (error) {
                if (error.response.status === 401) {
                    swal('請先登入', '', 'error').then(function () {
                        location.href = '{{ route('login') }}'
                    })
                } else if (error.response.msg) {
                    swal(error.response.msg, '', 'error')
                } else {
                    swal('系统错误', '', 'error')
                }
            })
        }


    </script>
@endpush

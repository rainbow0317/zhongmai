<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="{{ route('root') }}" style="text-decoration:underline">{{ config('app.name') }}</a>
        {{--<div class="collapse navbar-collapse" id="navbarSupportedContent">--}}
        <ul class="navbar-nav align-items-lg-center ml-auto">
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">登录</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">注册</a>
                </li>
            @else

                <li class="nav-item">
                    <a class="navbar-brand" href="{{ route('orders.income') }}" style="text-decoration:underline">我的推广</a>
                </li>

                <li class="nav-item">
                    <a class="navbar-brand"
                       href="{{route('users.withdraw')}}" style="text-decoration:underline">我的账户:{{ Auth::user()->balance ?round(Auth::user()->balance/100,2): 0 }}
                        元 </a>
                </li>
                <li>
                    <a class="nav-link" href="{{ route('logout') }}" style="text-decoration:underline"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        退出登录
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>


                {{--<li class="nav-item dropdown">--}}
                {{--<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"--}}
                {{--data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                {{--{{ Auth::user()->name ?? 'TEST' }}--}}
                {{--</a>--}}
                {{--<div class="dropdown-menu" aria-labelledby="navbarDropdown">--}}
                {{--<a href="{{ route('user_addresses.index') }}" class="dropdown-item">待入账收益</a>--}}
                {{--<a href="{{ route('orders.income') }}" class="dropdown-item">待入账收益</a>--}}
                {{--<a href="{{ route('orders.index') }}" class="dropdown-item">今日新增订单</a>--}}
                {{--<a href="{{ route('orders.fail') }}" class="dropdown-item">审核失败订单</a>--}}
                {{--<a href="{{ route('products.favorites') }}" class="dropdown-item">历史收益</a>--}}
                {{--<a href="{{ route('orders.history') }}" class="dropdown-item">历史收益</a>--}}
                {{--<div class="dropdown-divider"></div>--}}
                {{----}}
                {{--</div>--}}
                {{--</li>--}}
            @endguest
        </ul>
        {{--</div>--}}
    </div>
</nav>

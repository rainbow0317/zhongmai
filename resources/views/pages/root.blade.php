@extends('layouts.app')

@section('title', '首頁')

@section('content')
  <h1>首页</h1>

  @auth
    @empty(request()->user()->hasVerifiedEmail())
      <a href="{{ route('verification.notice') }}">验证E-mail</a>
    @endempty
  @endauth
@endsection

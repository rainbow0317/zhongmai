@extends('layouts.app')

@section('title', '错误')

@section('content')
  
  @card
    @slot('header', '错误')
    <div class="text-center py-5">
      <h1 class="mb-4">{{ $msg }}</h1>
      <a class="btn btn-primary" href="{{ route('root') }}">返回首页</a>
    </div>
  @endcard

@endsection

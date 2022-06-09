@extends('layouts.app')

@section('content')
    @if (Auth::guard('customer')->check())
        @include('front.cta')
    @endif
    @include('front.featured')
    @include('front.menu')
    @if (!Auth::guard('customer')->check())
        @include('front.contact')
        @include('front.profile')
    @endif
@endsection

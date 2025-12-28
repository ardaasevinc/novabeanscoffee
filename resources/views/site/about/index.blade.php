@extends('layouts.site')

@section('content')
@include('site.components.about')

    @include('site.components.why-choose')
    @include('site.components.intro-video')
    @include('site.components.our-faqs')

@endsection
@extends('layouts.main')

@section('title', 'CeedWork - Solution')

@section('herosection')
    @include('components._herosection')
@endsection

@section('content')
    @include('components._marcas')

    @if($posts->isNotEmpty())
        @include('components._destaques')
    @endif

    @include('components._servicos')
    @include('components._parceiros')
@endsection
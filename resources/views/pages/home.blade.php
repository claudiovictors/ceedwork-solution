@extends('layouts.main')

@section('title', 'CeedWork - Solution')

@section('herosection')
    @include('components._herosection')
@endsection

@section('content')
    @include('components._marcas')
    @include('components._destaques')
    @include('components._servicos')
    @include('components._parceiros')
@endsection
@extends('template.base')
@section('title','Dashboard')
@section('description','Dashboard')
@section('content')
{{$session['ss_relation']}}
@endsection

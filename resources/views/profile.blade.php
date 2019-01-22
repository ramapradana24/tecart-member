@extends('layouts.app')

@section('page-title')
Profile
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/select2/css/select2.min.css') }}">
@endsection

@section('content')
<div id="app">
  <Profile></Profile>
</div>
@endsection

@section('js')
<script src="{{ asset('assets/lib/select2/js/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/moment.js/min/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/profile.js') }}"></script>
@endsection
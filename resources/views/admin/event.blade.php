@extends('layouts.app')

@section('page-title')
Event
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/select2/css/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/jquery.gritter/css/jquery.gritter.css') }}"/>
@endsection

@section('content')
<div class="main-content container-fluid" id="app">
    <Event></Event>
</div>
@endsection

@section('js')
<script src="{{ asset('assets/lib/select2/js/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/moment.js/min/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/jquery.gritter/js/jquery.gritter.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/event.js') }}"></script>
<script>
    $(document).ready(function(){
        $.extend($.gritter.options, { position: 'bottom-left' });

        $(".datetimepicker").datetimepicker({
    	autoclose: true,
    	componentIcon: '.mdi.mdi-calendar',
    	navIcons:{
    		rightIcon: 'mdi mdi-chevron-right',
    		leftIcon: 'mdi mdi-chevron-left'
        },
        pickerPosition:'top-left'
    });
    })
</script>
@endsection
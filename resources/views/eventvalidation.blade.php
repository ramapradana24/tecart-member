@extends('layouts.app')

@section('page-title')
Event Validation
@endsection

@section('css')
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }}"/> --}}
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/select2/css/select2.min.css') }}"> --}}
<link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/jquery.gritter/css/jquery.gritter.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/datatables/css/dataTables.bootstrap.min.css') }}"/>
@endsection

@section('content')
<div class="main-content container-fluid" id="app">
    <router-view></router-view>
</div>
@endsection

@section('js')
{{-- <script src="{{ asset('assets/lib/select2/js/select2.min.js') }}" type="text/javascript"></script> --}}
<script src="{{ asset('assets/lib/moment.js/min/moment.min.js') }}" type="text/javascript"></script>
{{-- <script src="{{ asset('assets/lib/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script> --}}
<script src="{{ asset('assets/lib/jquery.gritter/js/jquery.gritter.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/datatables/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/datatables/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/datatables/plugins/buttons/js/dataTables.buttons.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/datatables/plugins/buttons/js/buttons.html5.j') }}s" type="text/javascript"></script>
<script src="{{ asset('assets/lib/datatables/plugins/buttons/js/buttons.flash.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/datatables/plugins/buttons/js/buttons.print.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/datatables/plugins/buttons/js/buttons.colVis.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/datatables/plugins/buttons/js/buttons.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/evvalidation.js') }}"></script>
<script>
    $(document).ready(function(){
        $.extend($.gritter.options, { position: 'bottom-left' });
    })
</script>
@endsection
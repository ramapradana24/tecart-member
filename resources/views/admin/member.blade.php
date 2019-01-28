@extends('layouts.app')

@section('page-title')
Members
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/datatables/css/dataTables.bootstrap.min.css') }}"/>
@endsection

@section('content')
<div class="main-content container-fluid" id="app">
    <Member></Member>
</div>
@endsection

@section('js')
<script src="{{ asset('assets/lib/datatables/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/datatables/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/datatables/plugins/buttons/js/dataTables.buttons.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/datatables/plugins/buttons/js/buttons.html5.j') }}s" type="text/javascript"></script>
<script src="{{ asset('assets/lib/datatables/plugins/buttons/js/buttons.flash.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/datatables/plugins/buttons/js/buttons.print.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/datatables/plugins/buttons/js/buttons.colVis.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/datatables/plugins/buttons/js/buttons.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/member.js') }}"></script>
<script>
    $(document).ready(function(){
        
    })
</script>
@endsection
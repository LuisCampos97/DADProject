@extends('master') 
@section('content')

<div class="content-header">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="text-dark">@{{ title }}</h1>
        </div>
    </div>
</div>
<item-list></item-list>
@endsection
 
@section('pagescript')
<script src="js/item.js"></script>

@stop
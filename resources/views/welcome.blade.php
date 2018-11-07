@extends('master') 
@section('title', 'Vue.js App') 
@section('content')

<div class="jumbotron">
    <h1>@{{ title }}</h1>
</div>
<item-list :items="items"></item-list>
@endsection
 
@section('pagescript')
<script src="js/item.js"></script>


@stop
@extends('layouts.sidenav-layout')


@section('content')

@include('components.category.category-list')
@include('components.category.category-create')
@include('components.category.category-update')
@include('components.category.category-delete')

@endsection

{{-- Category Listing --}}
{{-- Category Create --}}
{{-- Category Update --}}
{{-- Category Edit --}}
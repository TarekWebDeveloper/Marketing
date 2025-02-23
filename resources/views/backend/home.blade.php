@extends('layouts.admin')
@section('content')

 <!-- Page Heading -->
 <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">  </h1>
    </div>

    <!-- Content Row -->
    <livewire:backend.statistics />

   

    <!-- Content Row -->
    <livewire:backend.last-post-comments />


@endsection
@section('script')
    <!-- Page level plugins -->
    <script src="{{ asset('backend/vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('backend/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('backend/js/demo/chart-pie-demo.js') }}"></script>
@endsection

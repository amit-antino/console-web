@extends('layout.console.master')
@push('plugin-styles')
<link href="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/graph-in')}}">Data Processing</a></li>
        <li class="breadcrumb-item active" aria-current="page">View Tolerance Graph</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <div class="card-header">
                <h4 class="mb-3 mb-md-0">Tolerance - {{$value}}
                </h4>
            </div>
            <div class="card-body">
                <div class="row">
                    @if(!empty($graph_data))
                    @foreach($graph_data as $svg)
                    <div class="col text-center">
                        {!!$svg!!}
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
@endpush

@push('custom-scripts')
<script>

</script>
@endpush
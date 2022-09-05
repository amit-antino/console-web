@extends('layout.admin.master')

@push('plugin-styles')
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/admin/tenant') }}">Tenants</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{get_tenant_name(($tenant_id))}} Manage </li>
    </ol>
</nav>

<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="card-columns">
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                Reaction Type - {{$reaction_count}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map-marked fa-lg text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a type="button" href="{{ url('/admin/tenant/'.$tenant_id.'/reaction/reaction_type') }}" data-toggle="tooltip" data-placement="bottom" title="Manage Unit Image" class="btn btn-icon"><i class="fas fa-list-ul text-secondary"></i></a>
                </div>
            </div>
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                Phase - {{$reaction_phase_count}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map-marked fa-lg text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a type="button" href="{{ url('/admin/tenant/'.$tenant_id.'/reaction/phase') }}" data-toggle="tooltip" data-placement="bottom" title="Manage Condition Master" class="btn btn-icon"><i class="fas fa-list-ul text-secondary"></i></a>
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

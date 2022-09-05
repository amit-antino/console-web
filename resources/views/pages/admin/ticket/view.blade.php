@extends('layout.admin.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/admin/ticket')}}">Issue List</a></li>
        <li class="breadcrumb-item active" aria-current="page">Issue</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <div class="card-header">
                <h4 class="mb-3 mb-md-0">Ticket No- {{$data['id']}}</h4>
            </div>

            <div class="card-body">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="first_name">Title
                        </label>
                        <input type="text" disabled value="{{$data['title']}}" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="last_name">Issue Type

                        </label>
                        @php
                        if($data['type']==0)
                        $type="Feedback";
                        elseif($data['type']==1)
                        $type="Bug ";
                        elseif($data['type']==3)
                        $type="Questions ";
                        else
                        $type="Feature Request";
                        @endphp
                        <input type="text" disabled class="form-control" value="{{$type}}">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="last_name">Description

                        </label>
                        <textarea class="form-control" rows="7" disabled>{{$data['description']}}</textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="last_name">Created By

                        </label>
                        @php
                        $uname=getUser($data['created_by'])
                        @endphp
                        <input type="text" disabled class="form-control" value="{{$uname['username']}}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="last_name">Ticket Status
                        </label>
                        @php
                        if($data['status']=='active')
                        $status="Closed";
                        elseif($data['status']=='pending')
                        $status="Open ";
                        else
                        $status="In Review";
                        @endphp
                        <input type="text" disabled class="form-control" value="{{$status}}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="last_name">Priority
                        </label>
                        @php
                        if($data['priority']=='0')
                        $priority="Immediate";
                        elseif($data['priority']=='1')
                        $priority="High ";
                        elseif($data['priority']=='2')
                        $priority="Low";
                        else
                        $status="-";
                        @endphp
                        <input type="text" disabled class="form-control" value="{{$priority}}">
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src=" {{ asset('/assets/plugins/select2/select2.min.js') }}"></script>
@endpush

@push('custom-scripts')

@endpush
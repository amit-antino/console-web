@extends('layout.console.master')

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Notification</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Notification</h6>
                <ul id="content" class="timeline">
                    @if(!empty($notification))
                    @foreach($notification as $activity)

                    <li class="event" data-date="{{___ago($activity->updated_at)}}">
                        <h5>{{ucfirst($activity->data['data']['msg'])}}</h5>


                    </li>
                    @endforeach
                    @else
                    2
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
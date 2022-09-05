<div class="form-group col-md-6">
    <label for="condition">Selected Conditions
        <span class="text-danger">*</span>
        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Selected Conditions"></i></span>
    </label>
    <label>
        @if(!empty($conditions))
        @foreach($conditions as $condition)
        @if (in_array($condition->id, !empty($condition_exp_unit)?$condition_exp_unit:[]))
        <span class="badge badge-info">{{$condition->name}}</span>
        @endif
        @endforeach
        @endif
    </label>
</div>
<div class="form-group col-md-6">
    <label for="outcome">Selected Outcomes
        <span class="text-danger">*</span>
        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Selected Outcomes"></i></span>
    </label>
    <label>
        @if(!empty($outcomes))
        @foreach($outcomes as $outcome)
        @if (in_array($outcome->id, !empty($outcome_exp_unit)?$outcome_exp_unit:[]))
        <span class="badge badge-info">{{$outcome->name}}</span>
        @endif
        @endforeach
        @endif
    </label>
</div>
<div class="form-group col-md-6">
    <label for="stream_name">Input Stream Name Flow Type
        <span class="text-danger">*</span>
        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Input Stream Name Flow Type"></i></span>
    </label>
    <label>
        @if(!empty($stream_flow))
        @foreach($stream_flow as $stream)
        @if($stream['flow_type']=='input')
        <span class="badge badge-info">{{$stream['stream_name']}}</span>
        @endif
        @endforeach
        @endif
    </label>
</div>
<div class="form-group col-md-6">
    <label for="stream_name">Output Stream Name Flow Type
        <span class="text-danger">*</span>
        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Output Stream Name Flow Type"></i></span>
    </label>
    <label>
        @if(!empty($stream_flow))
        @foreach($stream_flow as $stream)
        @if($stream['flow_type']=='output')
        <span class="badge badge-info">{{$stream['stream_name']}}</span>
        @endif
        @endforeach
        @endif
    </label>
</div>
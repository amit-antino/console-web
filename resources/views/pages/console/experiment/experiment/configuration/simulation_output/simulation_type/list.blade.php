@if(!empty($simulation_type))
@php $sim_type=$simulation_type; @endphp
<div class="form-row" id="simulation_type_output_list">
    @if($sim_type['simulation_type_value']=='Dynamic' )
    <div class="form-group col-md-6  hide_show_div ">
        <label class="control-label">Total Run Time
            <span class="text-danger">*</span>
            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Value"></i></span>
        </label>
        <input type="number" data-request="numeric" value="{{!empty($sim_type['time_value'])?$sim_type['time_value']:0}}" id="time_value" class="form-control" name="time_value" placeholder="Enter Value" />
        @if(!empty($sim_type['time_unit_type']))
        <select title="Select Unit Type" name="time_unit_type" id="time_unit_type">
            <option value="">Select Time Unit</option>
            @if(!empty($time_unit))
            @foreach($time_unit->unit_constant as $unit_constant)
            <option @if($sim_type['time_unit_type']==$unit_constant['unit_name'] ) selected="" @endif value="{{$unit_constant['unit_name']}}">{{$unit_constant['unit_name']}}</option>
            @endforeach
            @endif
        </select>
        @else
        <select title="Select Unit Type" name="time_unit_type" id="time_unit_type">
            <option value="">Select Time Unit</option>
            @if(!empty($time_unit))
            @foreach($time_unit->unit_constant as $unit_constant)
            <option value="{{$unit_constant['unit_name']}}">{{$unit_constant['unit_name']}}</option>
            @endforeach
            @endif
        </select>
        @endif
    </div>
    <div class="form-group col-md-6  hide_show_div">
        <label class="control-label">Time Interval
            <span class="text-danger">*</span>
            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Interval Value"></i></span>
        </label>
        <input type="number" data-request="numeric" value="{{!empty($sim_type['time_interval_value'])?$sim_type['time_interval_value']:0}}" id="time_interval_value" class="form-control" name="time_interval_value" placeholder="Enter Interval Value" />
        @if(!empty($sim_type['time_unit_type']))
        <input type="text" class="form-control" value="{{$sim_type['time_interval_unit_type']}}" name="time_interval_unit_type" id="time_interval_unit_type" readonly>
        @else
        <input type="text" class="form-control" value="Day" name="time_interval_unit_type" id="time_interval_unit_type" readonly>

        @endif
    </div>
    @else
    <div class="form-row" id="simulation_type_output_list">
        <div class="form-group col-md-6  hide_show_div ">
            <label class="control-label">Total Run Time
                <span class="text-danger">*</span>
                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Value"></i></span>
            </label><br>
            <input type="number" data-request="numeric" id="time_value" class="form-control" name="time_value" placeholder="Enter Value" />
            <select title="Select Unit Type" name="time_unit_type" id="time_unit_type">
                <option value="">Select Time Unit</option>
                @if(!empty($time_unit))
                @foreach($time_unit->unit_constant as $unit_constant)
                <option @if('4'==$unit_constant['id']) selected @endif value="{{$unit_constant['unit_name']}}">{{$unit_constant['unit_name']}}</option>
                @endforeach
                @endif
            </select>
        </div>
        <div class="form-group col-md-6  hide_show_div ">
            <label class="control-label">Time Interval
                <span class="text-danger">*</span>
                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Interval Value"></i></span>
            </label><br>
            <input type="number" data-request="numeric" id="time_interval_value" class="form-control" name="time_interval_value" placeholder="Enter Interval Value" />
            <input type="text" value="Day" class="form-control" name="time_interval_unit_type" id="time_interval_unit_type" readonly>
        </div>
    </div>
    @endif
</div>
@endif
<option selected disabled value="">Select Unit Type</option>
@if(!empty($unit_constant))
@foreach($unit_constant as $unit_type)
<option value="{{___encrypt($unit_type['id'])}}">{{$unit_type['unit_name']}}</option>
@endforeach
@endif
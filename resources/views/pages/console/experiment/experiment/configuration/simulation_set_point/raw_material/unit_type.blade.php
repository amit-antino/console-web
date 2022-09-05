<select name="unit_constant_id" id="" class="form-control">
    <option value="">Select Unit Constant</option>
    @if(!empty($data['master_unit']))
    @foreach($data['master_unit'] as $unit_type)
    <option value="{{___encrypt($unit_type['id'])}}">{{$unit_type['unit_name']}}</option>
    @endforeach
    @endif
</select>
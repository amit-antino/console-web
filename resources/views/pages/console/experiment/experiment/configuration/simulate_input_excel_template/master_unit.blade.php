<select name="unit_constant_id" readonly id="" class="form-control">
    @if(!empty($data['master_unit']))
    @foreach($data['master_unit'] as $unit_type)
    @if($data['default_unit']==$unit_type['id'])
    <option selected value="{{___encrypt($unit_type['id'])}}">{{$unit_type['unit_name']}}</option>
    @else
    <option value="{{___encrypt($unit_type['id'])}}">{{$unit_type['unit_name']}}</option>
    @endif
    @endforeach
    @endif
</select>
  
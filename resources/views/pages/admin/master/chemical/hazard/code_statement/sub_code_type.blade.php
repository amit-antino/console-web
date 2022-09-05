<select class="form-control" name="sub_code_type">
    <option value="">Select Sub Code Type</option>
    @if(!empty($code_sub_types))
    @foreach($code_sub_types as $code_type)
    <option value="{{___encrypt($code_type->id)}}">{{$code_type->name}}</option>
    @endforeach
    @endif
</select>
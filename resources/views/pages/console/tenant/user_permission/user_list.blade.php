@if(!empty($user_arr))
<optgroup label="Group User">
    @foreach($user_arr as $key => $value)
    <option value="{{___encrypt($value['id'])}}">{{$value['name']}} </option>
    @endforeach
</optgroup>
@endif
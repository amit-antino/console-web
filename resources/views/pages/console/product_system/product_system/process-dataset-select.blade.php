<select id="dataset" name="dataset" class="js-example-basic-single" required>
    <option value="">Select Process Dataset</option>
    @if(!is_null($process_dataset))
    @foreach($process_dataset as $data)
        @if(Redis::get('ProcessProfile_id'.$data['id']))
            @php
            Redis::del(Redis::keys('ProcessProfile_id'.$data['id']));
            @endphp
        @endif
        @php
        Redis::set('ProcessProfile_id'.$data['id'], json_encode($data));
        @endphp
    <option value="{{___encrypt($data['id'])}}">{{$data['dataset_name']}}</option>
    @endforeach
    @endif
   
</select>
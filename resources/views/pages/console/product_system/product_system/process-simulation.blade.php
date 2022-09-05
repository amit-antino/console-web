<select id="process_simulation" name="process_simulation[0][process_sim]" class="js-example-basic-single" required>
    <option value="">Select Process Simulation</option>
    @if(!empty($data))
    @foreach($data as $process_simulation)
    <option value="{{___encrypt($process_simulation['id'])}}">{{$process_simulation['process_name']}}</option>
    @endforeach
    @endif
</select>
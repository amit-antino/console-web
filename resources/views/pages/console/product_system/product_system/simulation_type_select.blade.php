<select id="simulation_type" name="simulation_type" data-url="{{url('/product_system/process_simulation_datasetList')}}" data-request="ajax-append-fields" data-count="0" data-target="#dataset" class="js-example-basic-single" required>
    <option value="">Select Simulation Type</option>
    @if(!is_null($process_dataset))
    @foreach($process_dataset as $data)
    <option value="{{___encrypt($data['simulation_type'])}}">{{$data['SimulationType']['simulation_name']}}</option>
    @endforeach
    @endif
</select>
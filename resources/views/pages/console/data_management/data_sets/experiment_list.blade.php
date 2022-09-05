<select data-width="100%" class="js-example-basic-single" id="experiment" name="experiment">
    <option value="">Select Experiment</option>
    @if(!empty($experiments))
    @foreach($experiments as $experimet)
    <option value="{{$experimet['experiment']}}">{{$experimet['experiment']}}</option>
    @endforeach
    @endif
</select>
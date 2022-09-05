<div class="form-group col-md-6">
    <label class="control-label"> Select Country
        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Country"></i></span>
    </label>
    <input type="text" class="form-control" value="{{$location['country_id']}}" name="state" placeholder="Enter country Name" readonly="">

    {{-- <select name="country" id="country" class="form-control" aria-readonly="">
        <option value="">Select Country</option>
        @if(!empty($countries))
        @foreach($countries as $country)
        <option @if($country->id==$location['country_id']) selected @endif value="{{___encrypt($country->id)}}">{{$country->name}}</option>
        @endforeach
        @endif
    </select> --}}
</div>
<div class="form-group col-md-6">
    <label class="control-label"> Enter State Name
        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter State Name"></i></span>
    </label>
    <input type="text" class="form-control" value="{{$location['state']}}" name="state" placeholder="Enter State Name" readonly="">

</div>
<div class="form-group col-md-6">
    <label class="control-label"> Enter City Name
        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title=" Enter City Name"></i></span>
    </label>
    <input type="text" class="form-control" value="{{$location['city']}}" name="city" placeholder=" Enter City Name" readonly="">
</div>
<div class="form-group col-md-6">
    <label class="control-label"> Enter Geo Coordinate
        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Geo Coordinate"></i></span>
    </label>
    <input type="text" class="form-control" value="{{$location['pincode']}}" name="geo_cordinate" placeholder="Enter Geo Coordinate" readonly="">
</div>

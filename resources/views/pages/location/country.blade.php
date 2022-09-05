<label for="country_id">Enter Country Name
    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Country Name"></i></span>
</label>
<!-- <select id="country_id" name="country_id" class="js-example-basic-single hs_country">
    <option value="">Select Country</option>
    @php
    $country = \App\Models\Country::get();
    @endphp
    @if(!empty($country))
    @foreach($country as $countries)
    <option value="{{___encrypt($countries->id)}}">{{$countries->name}}</option>
    @endforeach
    @endif
</select> -->
<input type="text" id="country_id" value="{{isset($tenant->billing_information['country_id'])?$tenant->billing_information['country_id']:''}}" name="country_id" class="form-control" placeholder="Enter Country Name">
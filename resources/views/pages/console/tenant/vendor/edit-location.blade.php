<div class="modal fade" id="editLocationModal{{___encrypt($location->id)}}" tabindex="-1" role="dialog" aria-labelledby="vendor_location_detailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="vendor_location_detailLabel">Add Location Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" role="vendor-location-edit" action="{{url('organization/vendor/location/'.___encrypt($location->id))}}" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="vendor_id" value="{{___encrypt($location->vendor_id)}}">
                <div class="modal-body">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="location_name">Location Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Location Name"></i></span>
                            </label>
                            <input type="text" value="{{$location->location_name}}" name="location_name" class="form-control" placeholder="Location Name">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="address">Address
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Location Address "></i></span>
                            </label>
                            <textarea name="address" id="address" rows="5" class="form-control">{{$location->address}}</textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="country_id">Select Country
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Country"></i></span>
                            </label>
                            <select id="country_id" name="country_id" data-url="{{url('state')}}" data-type="form" data-request="ajax-append-fields" data-target="#location_state_id" class="js-example-basic-single">
                                <option value="">Select Country</option>
                                @php
                                $country = \App\Models\Country::get();
                                @endphp
                                @if(!empty($country))
                                @foreach($country as $countries)
                                <option @if(___encrypt($countries->id)==___encrypt($location->country_id)) selected @endif value="{{___encrypt($countries->id)}}">{{$countries->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="state_id">Select State / Province
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select State / Province"></i></span>
                            </label>
                            <select id="location_state_id" name="state_id" data-url="{{url('city')}}" data-type="form" data-request="ajax-append-fields" data-target="#location_city_id" class="js-example-basic-single">
                                <option value="">Select State / Province</option>
                                @if(!empty($state))
                                @foreach($state as $states)
                                <option @if(___encrypt($states->id)==___encrypt($location->state_id)) selected @endif value="{{___encrypt($states->id)}}">{{$states->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="city_id">Select District / City
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select District / City"></i></span>
                            </label>
                            <select id="location_city_id" name="city_id" class="js-example-basic-single">
                                <option value="">Select City</option>

                                @if(!empty($city))
                                @foreach($city as $cities)
                                <option @if(___encrypt($cities->id)==___encrypt($location->city_id)) selected @endif value="{{___encrypt($cities->id)}}">{{$cities->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pincode">Pincode / ZipCode
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Pincode / ZipCode"></i></span>
                            </label>
                            <input type="text" value="{{$location->pincode}}" name="pincode" class="form-control" placeholder="Pincode / ZipCode">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        {{Config::get('constants.message.loader_button_msg')}}
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary submit" id="submit_button_id" data-request="ajax-submit" data-target='[role="vendor-location-edit"]'>Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
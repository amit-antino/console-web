<div class="modal fade" id="locationeEditModal{{___encrypt($location['id'])}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Location</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('/admin/tenant/'.$location['tenant_id'].'/locations/'.___encrypt($location['id']))}}" method="POST" role="location-edit">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="status" value="{{$location['status']}}">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="location_name">Location Name
                                <span class="text-danger">*</span>
                                <span title="Location Name"><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Location Name"></i></span>
                            </label>
                            <input type="text" name="location_name" class="form-control" placeholder="Location Name" value="{{$location['location_name']}}">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="address">Address
                                <span title="Enter Location Address "><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Location Address "></i></span>
                            </label>
                            <textarea name="address" id="address" rows="5" class="form-control">{{$location['address']}}</textarea>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-lg-4">
                            <label for="country_id">Enter Country Name
                                <span class="text-danger">*</span>
                                <span title="Enter Country Name"><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Country Name"></i></span>
                            </label>
                            <input type="text" id="country_id" name="country_id" value="{{$location['country_id']}}" class="form-control" placeholder="Enter Country Name" required>
                            <!-- <select name="country_id" id="country_id" data-url="{{url('state')}}" data-type="form" data-request="ajax-append-fields" data-target="#edit_state_id" class="js-example-basic-single">
                                <option value="">Select Country</option>
                                @if(!empty($country))
                                @foreach($country as $count)
                                <option @if(___encrypt($location['country_id'])==___encrypt($count->id)) selected @endif value="{{___encrypt($count->id)}}">{{$count->name}}</option>
                                @endforeach
                                @endif
                            </select> -->
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-lg-4">
                            <label for="state_id">Enter State Name
                                <span class="text-danger">*</span>
                                <span title="Enter State Name"><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select State Name"></i></span>
                            </label>
                            <input type="text" name="state" placeholder="Enter State Name" value="{{$location['state']}}" class="form-control">
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-lg-4">
                            <label for="city_id">Enter District / City
                                <span class="text-danger">*</span>
                                <span title="Enter District / City"><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter District / City"></i></span>
                            </label>
                            <input type="text" name="city" placeholder="Enter District / City"  value="{{$location['city']}}" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pincode">Pincode / ZipCode
                                <span class="text-danger">*</span>
                                <span title="Pincode / ZipCode"><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Pincode / ZipCode"></i></span>
                            </label>
                            <input type="text" name="pincode" value="{{$location['pincode']}}" class="form-control" placeholder="Pincode / ZipCode">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    {{Config::get('constants.message.loader_button_msg')}}
                </button>
                <button type="button" class="btn btn-sm btn-secondary submit" id="submit_button_id" data-request="ajax-submit" data-target='[role="location-edit"]'>Save</button>
            </div>
        </div>
    </div>
</div>

  <script>
    feather.replace()
  </script>
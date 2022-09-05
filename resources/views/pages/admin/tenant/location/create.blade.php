<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Location</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('/admin/tenant/'.___encrypt($data['tenant_info']['id']).'/locations')}}" method="POST" role="locations">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="location_name">Location Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Location Name"></i></span>
                            </label>
                            <input type="text" name="location_name" class="form-control" placeholder="Location Name">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="address">Address
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Location Address "></i></span>
                            </label>
                            <textarea name="address" id="address" rows="5" class="form-control"></textarea>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-lg-4">
                            <label for="country_id">Enter Country Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Country Name"></i></span>
                            </label>
                            <input type="text" id="country_id" name="country_id" class="form-control" placeholder="Enter Country Name" required>
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
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-lg-4">
                            <label for="state_id">Enter State Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter State Name"></i></span>
                            </label>
                            <input type="text" name="state" class="form-control" placeholder="Enter State Name">
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-lg-4">
                            <label for="city_id">Enter District / City
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter District / City"></i></span>
                            </label>
                            <input type="text" name="city" class="form-control" placeholder="Enter District / City">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pincode">Pincode / ZipCode
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Pincode / ZipCode"></i></span>
                            </label>
                            <input type="text" name="pincode" class="form-control" placeholder="Pincode / ZipCode">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary " id="submit_button_id" data-request="ajax-submit" data-target='[role="locations"]'>Save</button>
                <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary " type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    {{Config::get('constants.message.loader_button_msg')}}
                </button>
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
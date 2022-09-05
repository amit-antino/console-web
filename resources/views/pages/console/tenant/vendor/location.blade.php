<div class="modal fade" id="vendor_location_detail" tabindex="-1" role="dialog" aria-labelledby="vendor_location_detailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="vendor_location_detailLabel">Add Location Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" role="vendor-location" action="{{url('organization/vendor/location')}}" enctype="multipart/form-data">
                <input type="hidden" name="vendor_id" value="{{___encrypt($vendor_id)}}">
                <div class="modal-body">
                    @csrf
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
                        <div class="form-group col-md-6">
                            @include('pages.location.country')
                        </div>
                        <div class="form-group col-md-6">
                            @include('pages.location.state')
                        </div>
                        <div class="form-group col-md-6">
                            @include('pages.location.city')
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pincode">Pincode / ZipCode
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Pincode / ZipCode"></i></span>
                            </label>
                            <input type="text" name="pincode" class="form-control" placeholder="Pincode / ZipCode">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm btn-secondary submit" id="submit_button_id" data-request="ajax-submit" data-target='[role="vendor-location"]'>Save</button>
                    <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        {{Config::get('constants.message.loader_button_msg')}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="vendor_contact_detail" tabindex="-1" role="dialog" aria-labelledby="vendor_contact_detailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="post" role="vendor-contact" action="{{url('organization/vendor/contact')}}" enctype="multipart/form-data">
                <div class="modal-header">
                    <input type="hidden" name="vendor_id" value="{{___encrypt($vendor_id)}}">
                    <h5 class="modal-title" id="vendor_contact_detailLabel">Add Contact Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Name"></i></span>
                            </label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="designation">Designation
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Designation"></i></span>
                            </label>
                            <input type="text" name="designation" id="designation" class="form-control" placeholder="Designation">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="location_id">Select Location
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Location"></i></span>
                            </label>
                            <select name="location_id" id="location_id" class="form-control">
                                <option value="">Select Location</option>
                                @if(!empty($vendor_locations))
                                @foreach($vendor_locations as $location)
                                <option value="{{___encrypt($location->id)}}">{{$location->location_name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email">Email
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Email"></i></span>
                            </label>
                            <input type="email" oninput="this.value = this.value.toLowerCase()" class="form-control" id="email" name="email" placeholder="Email">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phone_no">Phone Number
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Phone Number"></i></span>
                            </label>
                            <input type="text" name="phone_no" id="phone_no" class="form-control" data-inputmask-alias="(+99) 9999-9999-99" placeholder="Enter Phone Number">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        {{Config::get('constants.message.loader_button_msg')}}
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary submit" id="submit_button_id" data-request="ajax-submit" data-target='[role="vendor-contact"]'>Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
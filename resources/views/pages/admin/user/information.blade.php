<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form action="{{url('/admin/user/profile')}}" method="POST" role="information">
                <div class="card-body">
                    @csrf
                    <input type="hidden" name="role" value="information">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="mobile_number">Mobile Number
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Mobile Number"></i></span>
                            </label>
                            <input type="number" min="0.0000000001" data-request="isnumeric" value="{{!empty(Auth::user()->mobile_number)?Auth::user()->mobile_number:''}}" name="mobile_number" class="form-control" placeholder="Mobile Number">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="city">City
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="City"></i></span>
                            </label>
                            <input type="text" name="city" class="form-control" placeholder="City">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="state">State
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="State"></i></span>
                            </label>
                            <input type="text" name="state" class="form-control" placeholder="State">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="country">Country
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Country"></i></span>
                            </label>
                            <select class="form-control" name="country">
                                <option value="">Select Country</option>
                                <option value="india">India</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="information"]' class="btn btn-sm btn-secondary submit">Submit</button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{Config::get('constants.message.loader_button_msg')}}
                        </button>
                        <a href="{{url('/admin/dashboard')}}" class="btn btn-sm btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
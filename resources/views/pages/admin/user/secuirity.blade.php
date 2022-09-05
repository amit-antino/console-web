<form action="{{url('admin/user/profile')}}" method="POST" role="secuirity">
    <div class="card-body">
        <input type="hidden" name="role" value="secuirity">
        <div class="form-row">
            <!-- <div class="form-group col-md-6">
                            <label for="email">Email Address
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Email Address"></i></span>
                            </label>
                        </div> -->
            <input type="hidden" oninput="this.value = this.value.toLowerCase()" disabled class="form-control" placeholder="Email Address" value="{{!empty(Auth::user()->email)?Auth::user()->email:''}}">

            <div class="form-group col-md-6">
                <label for="old_password">Old Password
                    <span class="text-danger">*</span>
                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Old Password"></i></span>
                </label>
                <input type="password" name="old_password" class="form-control" placeholder="Old Password">
            </div>
            <div class="form-group col-md-6">
                <label for="password">New Password
                    <span class="text-danger">*</span>
                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="New Password"></i></span>
                </label>
                <input type="password" name="password" class="form-control" placeholder="New Password">
            </div>
            <div class="form-group col-md-6">
                <label for="confirm_password">Confirm Password
                    <span class="text-danger">*</span>
                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Confirm Password"></i></span>
                </label>
                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password">
            </div>

        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="two_factor">Enable Two Factor
                    <span class="text-danger">*</span>
                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enable Two Factor"></i></span>
                </label>
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" name="is_two_factor_enable" id="customSwitch" {{two_factor_is_enable()}}>
                    <label class="custom-control-label" for="customSwitch"></label>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="secuirity"]' class="btn btn-sm btn-secondary submit">Submit</button>
            <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                {{Config::get('constants.message.loader_button_msg')}}
            </button>
            <a href="{{url('/admin/dashboard')}}" class="btn btn-sm btn-danger">Cancel</a>
        </div>
    </div>
</form>
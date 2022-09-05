<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form action="{{url('admin/user/profile')}}" method="POST" role="settings">
                <div class="card-body">
                    <input type="hidden" name="role" value="settings">
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
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="settings"]' class="btn btn-sm btn-secondary submit">Submit</button>
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
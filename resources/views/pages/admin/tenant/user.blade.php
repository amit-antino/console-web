<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form action="{{url('/admin/tenant/')}}" method="POST" role="user">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Add User</h4>
                </div>
                <input type="hidden" name="role" value="user">
                <input type="hidden" name="tenant_id" value="{{request()->query('tenant_id')}} ">
                @php
                if(!empty($tenant->tenanat_config_function->user_info)){
                $user= $tenant->tenanat_config_function->user_info;
                }else{
                $user='';
                }
                @endphp
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="first_name">First Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="First Name"></i></span>
                            </label>
                            <input type="text" name="user[first_name]" class="form-control" placeholder="First Name" value="{{!empty($user->first_name)?$user->first_name:''}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="last_name">Last Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Last Name"></i></span>
                            </label>
                            <input type="text" name="user[last_name]" class="form-control" placeholder="Last Name" value="{{!empty($user->last_name)?$user->last_name:''}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email">Email Address
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Email Address"></i></span>
                            </label>
                            <input type="email" oninput="this.value = this.value.toLowerCase()" value="{{!empty($user->email)?$user->email:''}}" name="user[email]" class="form-control" placeholder="Email Address">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="mobile_number">Mobile Number
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Mobile Number"></i></span>
                            </label>
                            <input type="number" min="0.0000000001" data-request="isnumeric" value="{{!empty($user->mobile_number)?$user->mobile_number:''}}" name="user[mobile_number]" class="form-control" placeholder="Mobile Number">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="date_of_birth">Date of Birth
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Date of Birth"></i></span>
                            </label>
                            <input type="date" value="{{!empty($user->date_of_birth)?$user->date_of_birth:''}}" name="user[date_of_birth]" id="date_of_birth" class="form-control" placeholder="Date of Birth">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="profile_image">Upload Profile Picture
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Upload Profile Picture"></i></span>
                            </label>
                            <div class="input-group input-group-sm mb-3">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="profile_image" name="user[profile_image]" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label" for="profile_image">Upload Profile Picture</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="user"]' class="btn btn-sm btn-secondary submit">Submit</button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{Config::get('constants.message.loader_button_msg')}}
                        </button>
                        <a href="/admin/tenant" class="btn btn-sm btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
    <div class="card-body">
        <input type="hidden" name="role" value="basic_info">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="first_name">First Name
                    <span class="text-danger">*</span>
                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="First Name"></i></span>
                </label>
                <input type="text" name="first_name" class="form-control" placeholder="First Name" value="{{!empty(Auth::user()->first_name)?Auth::user()->first_name:''}}">
            </div>
            <div class="form-group col-md-6">
                <label for="last_name">Last Name
                    <span class="text-danger">*</span>
                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Last Name"></i></span>
                </label>
                <input type="text" name="last_name" class="form-control" placeholder="Last Name" value="{{!empty(Auth::user()->last_name)?Auth::user()->last_name:''}}">
            </div>
            <div class="form-group col-md-6">
                <label for="email">Email Address
                    <span class="text-danger">*</span>
                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Email Address"></i></span>
                </label>
                <input type="email" oninput="this.value = this.value.toLowerCase()" disabled class="form-control" placeholder="Email Address" value="{{!empty(Auth::user()->email)?Auth::user()->email:''}}">
            </div>
            <!-- <div class="form-group col-md-6">
                            <label for="mobile_number">Mobile Number
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Mobile Number"></i></span>
                            </label>
                            <input type="number" name="mobile_number" class="form-control" placeholder="Mobile Number" value="{{!empty(Auth::user()->mobile_number)?Auth::user()->mobile_number:''}}">
                        </div> -->
            <!-- <div class="form-group col-md-6">
                            <label for="date_of_birth">Date of Birth
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Date of Birth"></i></span>
                            </label>
                            <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" placeholder="Date of Birth" value="{{!empty(Auth::user()->date_of_birth)?Auth::user()->date_of_birth:''}}">
                        </div> -->
            <!-- <div class="form-group col-md-6">
                            <label for="profile_image">Upload Profile Picture
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Upload Profile Picture"></i></span>
                            </label>
                            <div class="input-group input-group-sm mb-3">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="profile_image" name="profile_image" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label" for="profile_image">Upload Profile Picture</label>
                                </div>
                            </div>
                            <div class="card shadow">
                                @if(!empty(Auth::user()->profile_image))
                                <img src="{{url(Auth::user()->profile_image)}}" class="img-fluid card-img-top" alt="">
                                <button type="button" data-url="{{url('/admin/user/profile/'.Auth::user()->id.'?remove=logo')}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-sm btn-danger btn-icon-text mb-2 mb-md-0">
                                    <i class="btn-icon-prepend" data-feather="trash"></i>
                                    Delete Image
                                </button>
                                @else
                                <img src="https://via.placeholder.com/250x250" class="img-fluid card-img-top" alt="">
                                @endif
                               
                            </div>
                        </div> -->
        </div>
        <div class="card-footer text-right">
            <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="basic_info"]' class="btn btn-sm btn-secondary submit">Submit</button>
            <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                {{Config::get('constants.message.loader_button_msg')}}
            </button>
            <a href="{{url('/admin/dashboard')}}" class="btn btn-sm btn-danger">Cancel</a>
        </div>
    </div>
</form>
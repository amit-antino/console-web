@php
$language = !empty($user_info->settings['language'])?$user_info->settings['language']:'';
$timezone_id = !empty($user_info->settings['timezone'])?$user_info->settings['timezone']:0;
$date_format = !empty($user_info->settings['date_format'])?$user_info->settings['date_format']:'';
$currency_type = !empty($user_info->settings['currency_type'])?$user_info->settings['currency_type']:'';
@endphp
<form action="{{url('admin/user/profile')}}" method="POST" role="prefer">
    <div class="card">
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="language">Select Language
                        <span class="text-danger">*</span>
                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Language"></i></span>
                    </label>
                    <select class="form-control" name="language" id="language">
                        <option value="">Select Language</option>
                        <option @if('english'==$language) selected @endif value="english">English</option>
                        <option @if('german'==$language) selected @endif value="german">German</option>
                        <option @if('dutch'==$language) selected @endif value="dutch">Dutch</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="time_zone">Select Time Zone
                        <span class="text-danger">*</span>
                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Time Zone"></i></span>
                    </label>
                    <select class="form-control" name="time_zone" id="time_zone" placeholder="Select Time Zone">
                        <option value="">Select Time Zone</option>
                        @if(!empty($timezones))
                        @foreach($timezones as $timezone)
                        <option @if($timezone->id==$timezone_id) selected @endif value="{{___encrypt($timezone->id)}}">{{$timezone->time_zone}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="currency_type">Select Currency Type
                        <span class="text-danger">*</span>
                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Currency Type"></i></span>
                    </label>
                    <select class="form-control" name="currency_type" id="currency_type">
                        <option value="">Select Currency Type</option>
                        @if(!empty($countries))
                        @foreach($countries as $country)
                        <option @if($country->id==$currency_type) selected @endif value="{{___encrypt($country->id)}}">{{$country->currency}}</option>
                        @endforeach
                        @endif

                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="date_format">Select Date Format
                        <span class="text-danger">*</span>
                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Date Format"></i></span>
                    </label>
                    <select class="form-control" name="date_format" id="date_format">
                        <option value="">Select Date Format</option>
                        <option @if('dd-mm-yyyy'==$date_format) selected @endif value="dd-mm-yyyy">DD-MM-YYYY</option>
                        <option @if('mm-dd-yyyy'==$date_format) selected @endif value="mm-dd-yyyy">MM-DD-YYYY</option>
                        <option @if('yyyy-mm-dd'==$date_format) selected @endif value="yyyy-mm-dd">YYYY-MM-DD</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="prefer"]' class="btn btn-sm btn-secondary submit">Submit</button>
            <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                {{Config::get('constants.message.loader_button_msg')}}
            </button>
            <a href="{{url('/admin/dashboard')}}" class="btn btn-sm btn-danger">Cancel</a>
        </div>
    </div>
</form>
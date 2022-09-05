<div class="table-responsive">
    <table class="table table-bordered rate-parameter-user">
        <thead>
            <th class="th_border">Reaction</th>
            <th class="th_border">Name</th>
            <th class="th_border">Rate constant (k)</th>
            <th class="th_border">Temperature (K)</th>
            <th class="th_border">Catalyst factor or Expression</th>
        </thead>
        <tbody class="">
            @if($reaction_data->rate_parameter_user)
            @foreach($rate_user_data->reaction as $key=>$value)
            <tr class="clone_tr">
                <td>
                    <select class="form-control sel_heig td_input_width" name="reaction[]">
                        <option @if($value=='fwd' ) selected @endif value="fwd">
                            Forward
                        </option>
                        <option @if($value=='bwd' ) selected @endif value="bwd">
                            Backward
                        </option>
                    </select>
                </td>
                <td><input type="text" disabled="" name="name[]" class="form-control td_input_width" value="{{$rate_user_data->name[$key]}}"></td>
                <td><input type="text" disabled="" name="Rate_constant[]" class="form-control td_input_width" value="{{$rate_user_data->Rate_constant[$key]}}"></td>
                <td><input type="text" disabled="" name="Temperature_k[]" class="form-control td_input_width" value="{{$rate_user_data->Temperature_k[$key]}}"></td>
                <td>
                    <select class="form-control sel_cat_exp " name="cat_type[]" onchange="select_type(this)">
                        <option value="" selected disabled>
                            Select option</option>
                        <option @if(!empty($rate_user_data->cat_type[$key]))
                            @if($rate_user_data->cat_type[$key]=='cat')
                            selected
                            @endif
                            @endif
                            value="cat">Catalyst factor
                        </option>
                        <option @if(!empty($rate_user_data->cat_type[$key]))
                            @if($rate_user_data->cat_type[$key]=='exp')
                            selected
                            @endif
                            @endif
                            value="exp">Expression
                        </option>
                    </select>
                    <input type="text" disabled="" name="cat_or_exp_val[]" @if(!empty($rate_user_data->catalyst_factor[$key]))
                    value="{{$rate_user_data->catalyst_factor[$key]}}"
                    @endif
                    class="form-control form-control-sm
                    col-dm-12
                    cat_or_exp">
                </td>
            </tr>
            @endforeach
            @else
            <tr class="clone_tr">No record Found</tr>
            @endif
        </tbody>
    </table>
</div>
<hr>
<p><b>Reaction Rate Parameter </b> Calculation </p>
<div class="table-responsive">
    <table class="table table-bordered rate-parameter-cal">
        <thead>
            <th class="th_border">Reaction</th>
            <th class="th_border">Name</th>
            <th class="th_border">A</th>
            <th class="th_border">E(J/mol)</th>
            <th class="th_border">Temperature (K)</th>
            <th class="th_border">Rate Constant(k)</th>
            <th class="th_border">Catalyst factor or Expression</th>
        </thead>
        <tbody class="calculate_rrp_cln">
            @if(!empty($reaction_data->rate_parameter_cal))
            @foreach($rate_cal_data->reaction as $key=>$value)
            <tr class="clone_row">
                <td>
                    <select class="form-control sel_heig td_input_width" name="reaction[]" value="{{$rate_cal_data->name[$key]}}">
                        <option @if($value=='fwd' ) selected @endif value="fwd">Forward</option>
                        <option @if($value=='bwd' ) selected @endif value="bwd">Backward</option>
                    </select>
                </td>
                <td><input type="text" disabled="" name="name[]" class="form-control td_input_width" value="{{$rate_cal_data->name[$key]}}"></td>
                <td><input type="text" disabled="" name="a[]" class="form-control td_input_width calculate_reaction_rate" value="{{$rate_cal_data->a[$key]}}"></td>
                <td><input type="text" disabled="" name="e[]" class="form-control td_input_width calculate_reaction_rate" value="{{$rate_cal_data->e[$key]}}"></td>
                <td><input type="text" disabled="" name="Temperature_k[]" class="form-control td_input_width" value="{{$rate_cal_data->Temperature_k[$key]}}"></td>
                <td><input type="text" disabled="" readonly name="Rate_constant[]" class="form-control td_input_width" value="{{$rate_cal_data->Rate_constant[$key]}}"></td>
                <td>
                    <select class="form-control sel_cat_exp" name="cat_type[]" onchange="select_type(this)">
                        <option value="" selected disabled>Select Option</option>
                        <option @if(!empty($rate_cal_data->cat_type[$key]))
                            @if($rate_cal_data->cat_type[$key]=='cat')
                            selected
                            @endif
                            @endif
                            value="cat">Catalyst factor
                        </option>
                        <option @if(!empty($rate_cal_data->cat_type[$key]))
                            @if($rate_cal_data->cat_type[$key]=='exp')
                            selected
                            @endif
                            @endif
                            value="exp">Expression
                        </option>
                    </select>
                    <input type="text" class="form-control cat_or_exp" disabled="" name="cat_or_exp_val[]" @if(!empty($rate_cal_data->catalyst_factor[$key])) value="{{$rate_cal_data->catalyst_factor[$key]}}"@endif>
                </td>
            </tr>
            @endforeach
            @else
            <tr class="clone_row">No Record Found</tr>
            @endif
        </tbody>
        <tbody class="load_calculate_cln"></tbody>
    </table>
</div>
<div class="table-responsive">
    <table class="table table-bordered equilibrium-cal">
        <thead>
            <th class="th_border">Name</th>
            <th class="th_border">​Keq value</th>
            <th class="th_border">Temperature (K)</th>
        </thead>
        <tbody class="calculate_rrp_cln">
            @if(!empty($reaction_data->equilibrium_user))
            @foreach($equi_user_data->name as $key=>$value)
            <tr class="equi_clone_tr">
                <td><input type="text" disabled="" name="name[]" class="form-control td_input_width" value="{{$equi_user_data->name[$key]}}"></td>
                <td><input type="text" disabled="" name="Keq_value[]" class="form-control td_input_width" value="{{$equi_user_data->Keq_value[$key]}}"></td>
                <td><input type="text" disabled="" name="Temperature_k[]" class="form-control td_input_width" value="{{$equi_user_data->Temperature_k[$key]}}"></td>
            </tr>
            @endforeach
            @else
            <tr class="equi_clone_row">No Record Found</tr>
            @endif
        </tbody>
        <tbody class="load_calculate_cln"></tbody>
    </table>
</div>
<p><b>Equiliburium Constant </b> Calculation </p>
<div class="table-responsive">
    <table class="table table-bordered equilibrium-user">
        <thead>
            <th class="th_border">Name</th>
            <th class="th_border">​Keq value</th>
            <th class="th_border">Temperature (K)</th>
        </thead>
        <tbody class="">
            @if($reaction_data->equilibrium_cal)
            @foreach($equi_cal_data->name as $key=>$value)
            <tr class="equi_clone_tr">
                <td><input type="text" disabled="" name="name[]" class="form-control td_input_width" value="{{$equi_cal_data->name[$key]}}"></td>
                <td><input type="text" disabled="" name="Keq_value[]" class="form-control td_input_width" value="{{$equi_cal_data->Keq_value[$key]}}"></td>
                <td><input type="text" disabled="" name="Temperature_k[]" class="form-control td_input_width" value="{{$equi_cal_data->Temperature_k[$key]}}"></td>
            </tr>
            @endforeach
            @else
            <tr class="equi_clone_tr">No Record Found</tr>
            @endif
        </tbody>
    </table>
</div>
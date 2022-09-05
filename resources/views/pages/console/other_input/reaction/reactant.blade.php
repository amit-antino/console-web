<tr>
    <td>
        <input type="hidden" name="sort_order_r[]" value="1" class="sort_order_r" />
        <select id="mol_f" name="reactant_chm_r[]" onChange="is_generic(this, 'gen_selected')" class="js-example-basic-single _chm dvalue">
            @if(!empty($chemical))
            <option value="" selected disabled>Select Chemical</option>
            @foreach($chemical as $chem)
            <option value="{{$chem['molecular_formula']}}">{{$chem['chemical_name']}}|{{$chem['molecular_formula']}}</option>
            @endforeach
            @endif
        </select>
    </td>
    <td>
        <input type="text" min="1" max="99" name="ra_count_r[]" value="1" class="form-control dvalue stoi_val validate_decimal" onkeyup="live_eq_r(this);if(this.value>99){this.value='99';}else if(this.value<0){this.value='0';}" />
    </td>
    <td>
        <input type="text" min="1" max="99" onkeyup="forward_order(this);if(this.value>99){this.value='99';}else if(this.value<0){this.value='0';}" name="fwr[]" class="form-control dvalue fwd_in validate_decimal" />
    </td>
    <td>
        <select name="base_comp[]" class="js-example-basic-single one_true_sel" id="change_val" onchange="select_single_true_val_reactant(this)">
            <option value="true">True </option>
            <option selected value="false">False</option>
        </select>
    </td>
    <td style="border-top:none">
        <i class="fas fa-plus-circle" onClick="clone_reac_r(this)" style="cursor:pointer"></i>
    </td>
    <td style="border-top:none">
        <i class="fas fa-minus-circle" onClick="remove_reac_r(this)" style="cursor:pointer"></i>
    </td>
</tr>
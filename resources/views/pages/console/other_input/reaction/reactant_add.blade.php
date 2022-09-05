<div class="modal fade bd-product-modal-md" id="reactantModal" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-md" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form method="POST" action="{{url('admin/master/chemical/category')}}" role="plan">
            @CSRF
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Create Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="control-label"> SELECT CHEMICAL <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter SELECT CHEMICAL"></i></span>
                            </label>
                            <input type="hidden" name="sort_order_r[]" class="sort_order_r" />
                            <select id="mol_f" name="reactant_chm_r[]" onChange="is_generic(this, 'gen_selected')" class="js-example-basic-single _chm dvalue">
                                @if(!empty($chemical))
                                <option value="" selected dissabled>Select Chemical</option>
                                @foreach($chemical as $chem)
                                <option value="{{$chem['id']}}_{{$chem['molecular_formula']}}">
                                    {{$chem['chemical_name']}}|{{$chem['molecular_formula']}}
                                </option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label"> STOICHIOMETRIC COEFFICIENT <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Name"></i></span>
                            </label>
                            <input onkeyup="live_eq_r(this);if(this.value>99){this.value='99';}else if(this.value<0){this.value='0';}" type="text" min="1" max="99" name="ra_count_r[]" class="form-control form-control-sm dvalue stoi_val validate_decimal" />
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label"> FORWARD ORDER <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Name"></i></span>
                            </label>
                            <input type="text" min="1" max="99" onkeyup="forward_order(this);if(this.value>99){this.value='99';}else if(this.value<0){this.value='0';}" name="fwr[]" class="form-control form-control-sm dvalue fwd_in validate_decimal" />
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Base Component</label>
                            <select name="base_comp[]" class="form-control one_true_sel" id="change_val" onchange="select_single_true_val_reactant(this)">
                                <option value="true">True </option>
                                <option selected value="false">False</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="plan"]' class="btn btn-sm btn-secondary submit">
                        Submit
                    </button>
                    <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        {{Config::get('constants.message.loader_button_msg')}}
                    </button>
                    <button class="btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
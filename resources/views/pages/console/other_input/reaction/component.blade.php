
<div class="form-group col-md-12">
    <input type="hidden" id="left_equation" name="left_equation" />
    <input type="hidden" id="right_equation" name="right_equation" />
    <input type="hidden" id="l_equation" name="l_equation" />
    <input type="hidden" id="r_equation" name="r_equation" />
    <div class="card">
        <div class="card-header text-center">
            <h4 class="mb-3 mb-md-0">Component</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 mb-3">
                    <div class="card">
                        <div class="card-header text-center">
                            <input type="hidden" name="error_message" class="form-control">
                            <h5 class="mb-3 mb-md-0">Reactants</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table_reaction table_reactants" id="reactants_tour_id">
                                    <thead>
                                        <th>Select Chemical <span class="text-danger">*</span></th>
                                        <th>Stoichiometric Coefficient <span class="text-danger">*</span></th>
                                        <th>Forward Order </th>
                                        <th>Reaction Phase </th>
                                        <th>Base Component</th>
                                        <th colspan="2">Action </th>
                                    </thead>
                                    <tbody class="clone_con_r">
                                        <tr id="rowToClone">
                                            <td>
                                                <div id="chemSelect">
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
                                            </td>
                                            <td><input onkeyup="live_eq_r(this);if(this.value>99){this.value='99';}else if(this.value<0){this.value='0';}" type="text" min="1" max="99" name="ra_count_r[]" class="form-control form-control-sm dvalue stoi_val validate_decimal ra_count_r" /></td>
                                            <td><input type="text" min="1" max="99" onkeyup="forward_order(this);if(this.value>99){this.value='99';}else if(this.value<0){this.value='0';}" name="fwr[]" class="form-control form-control-sm dvalue fwd_in validate_decimal" /></td>
                                            <td>
                                                <select name="reaction_phase[]" onchange="reactantsEqution()" class="form-control reaction_phase svalue " id="reaction_phase">
                                                    <option value="0">Select Reaction Phase</option>
                                                    @if(!empty($reaction_phase))
                                                    @foreach($reaction_phase as $phase)
                                                    <option value="{{$phase->notation}}">{{$phase->notation}} {{$phase->name}}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                            <td>
                                                <select name="base_comp[]" class="form-control one_true_sel" id="change_val" 
                                                data-request="alert-popup-reaction" 
                                                data-target=".one_true_sel" 
                                                data-ask_image="warning" 
                                                data-ask="Only one component can be true for a given reaction. Are you sure, do you want to change the base component?">
                                                    <option value="true">True </option>
                                                    <option selected value="false">False</option>
                                                </select>
                                            </td>
                                            <td style="border-top:none"><i class="fas fa-plus text-secondary" onClick="clone_reac_r(this)" style="cursor:pointer"></i></td>
                                            <td style="border-top:none"><i class="fas fa-minus text-secondary" onClick="remove_reac_r(this)" style="cursor:pointer"></i></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-md-12 col-sm-12 mb-3">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5 class="mb-3 mb-md-0">Products</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table_reaction table_products" id="product_id">
                                    <thead>
                                        <th>Select Chemical <span class="text-danger">*</span></th>
                                        <th>Stoichiometric Coefficient <span class="text-danger">*</span></th>
                                        <th>Backward Order </th>
                                        <th>Reaction Phase </th>
                                        <th>Base Component</th>
                                        <th colspan="2">Action </th>
                                    </thead>
                                    <tbody class="clone_con_p">
                                        <tr>
                                            <td>
                                                <input type="hidden" name="sort_order_p[]" class="sort_order_p" />
                                                <select name="reactant_chm_p[]" onChange="is_generic(this, 'gen_selected')" class="js-example-basic-single _chm dvalue">
                                                    @if(!empty($chemical))
                                                    <option value="" selected disabled>Select Chemical</option>
                                                    @foreach($chemical as $chem)
                                                    <option value="{{$chem['id']}}_{{$chem['molecular_formula']}}">
                                                        {{$chem['chemical_name']}}|{{$chem['molecular_formula']}}
                                                    </option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                            <td><input onkeyup="live_eq_p(this);if(this.value>99){this.value='99';}else if(this.value<0){this.value='0';}" type="text" min="1" max="99" name="ra_count_p[]" class="form-control form-control-sm dvalue validate_decimal ra_count_p" /></td>
                                            <td><input type="text" min="1" max="99" onkeyup="if(this.value>99){this.value='99';}else if(this.value<0){this.value='0';}" name="bwr_p[]" class="form-control form-control-sm dvalue validate_decimal" /></td>
                                            <td>
                                                <select name="product_reaction_phase[]" onchange="productEqution()" class="form-control reaction_phase_product" id="reaction_phase_product">
                                                    <option value="0">Select Reaction Phase</option>
                                                    @if(!empty($reaction_phase))
                                                    @foreach($reaction_phase as $phase)
                                                    <option value="{{$phase->notation}}">{{$phase->notation}} {{$phase->name}}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                            <td>
                                                <select name="base_comp_p[]" class="form-control one_pro_true_sel" id="change_pro_val" data-request="alert-popup-reaction" data-target=".one_pro_true_sel" data-ask_image="warning" data-ask="Only one component can be true for a given reaction. Are you sure, do you want to change the base component?">
                                                    <option value="true">True </option>
                                                    <option selected value="false">False</option>
                                                </select>
                                            </td>

                                            <td style="border-top:none"><i class="fas fa-plus text-secondary" onClick="clone_reac_p(this)" style="cursor:pointer"></i></td>
                                            <td style="border-top:none"><i class="fas fa-minus text-secondary" onClick="remove_reac_p(this)" style="cursor:pointer"></i></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5 class="mb-3 mb-md-0">Chemical Equation</h5>
                        </div>
                        <div class="card-body">
                            <div class="live_eq_con row">
                                <div class="inner_seperator l col-md-5 bg-secondary text-white"></div>
                                <div class="col-md-2 text-center">
                                    <span id="exchange_arrow"><i class="fas fa-exchange-alt"></i></span>
                                    <span id="right_arrow"><i class="fas fa-arrow-right"></i></span>
                                </div>
                                <div class="inner_seperator r col-md-5 bg-secondary text-white"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5 class="mb-3 mb-md-0">Rate Equation</h5>
                        </div>
                        <div class="card-body">
                            <div class="live_eq_con">
                                <div class="rate_eq"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="mole_left" name="reactan_mole" />
            <input type="hidden" id="mole_right" name="product_mole" />
            <input type="hidden" id="reaction_mole_left" name="reaction_mole_left" />
            <input type="hidden" id="product_mole_right" name="product_mole_right" />
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center flex-wrap grid-margin">
                            <h5 class="mb-3 mb-md-0">Stoichiometric Balance</h5>
                            <button type="button" id="show_balance_details" class="btn btn-info btn-sm">Show details</button>
                        </div>
                        <div class="card-body" style="display:none;" id="showhide">
                            <input type="hidden" name="blnc" id="blnc">
                            <div id="stoichemi"></div>
                            <div class="row" id="broken_molecular_formula">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
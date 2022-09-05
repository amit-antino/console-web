<div id="remove-product-{{$count+1}}">
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="chemical_pro">Chemical</label>
            <select data-count="0" data-type='product' data-request="chemical-product" class="form-control" id="chemical_pro-{{$count+1}}" name="chemical_pro[{{$count+1}}]">
                @if(!empty($chemical))
                <option value="" selected disabled>Slecet Chemical</option>
                @foreach($chemical as $chem)
                <option value="{{$chem['molecular_formula']}}">{{$chem['chemical_name']}}|{{$chem['molecular_formula']}}</option>
                @endforeach
                @endif
            </select>
        </div>
        <div class="form-group col-md-3">
            <label for="stoic_coef_pro">Stoichiometric Coefficient</label>
            <input id="stoic_coef_pro-{{$count+1}}" data-count="{{$count+1}}" data-type='product' data-request="chemical-product" type="text" name="stoic_coef_pro[{{$count+1}}]" class="form-control">
        </div>
        <div class="form-group col-md-2">
            <label for="backward_order_pro">Backward Order</label>
            <input type="text" id="backward_order_pro-{{$count+1}}" data-count="{{$count+1}}" data-type='product' data-request="chemical-product" name="backward_order_pro[{{$count+1}}]" class="form-control">
        </div>
        <div class="form-group col-md-4">
            <label for="base_component_pro">Base Component</label>
            <div class="row">
                <div class="form-group col-md-8">
                    <select data-count="{{$count+1}}" data-type='product' data-request="chemical-product" class="form-control" id="base_component_pro-{{$count+1}}" name="base_component_pro[{{$count+1}}]">
                        <option value="true">True</option>
                        <option value="false">False</option>
                    </select>
                </div>
                <div class="col-sm-4">
                    <button class="btn btn-sm btn-danger" type="button">
                        <i class="fas fa-minus-circle" data-target="#remove-product-{{$count+1}}" data-request="remove"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
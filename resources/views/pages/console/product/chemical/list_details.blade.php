<div class="modal fade bd-product-modal-lg " id="viewListModal{{___encrypt($list->id)}}" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-lg" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <input type="hidden" name="_method" value="PUT">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Chemical Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <p>Molecular Formula - <b>{{$chemical->molecular_formula}}</b></p>
                    </div>
                    <div class="form-group col-md-6">
                        <p>Product Brand Name - <b>{{$chemical->product_brand_name}}</b></p>
                    </div>
                    <div class="form-group col-md-6">
                        <p>Category - <b>{{$chemical->chemicalCategory->name}}</b></p>
                    </div>
                    <div class="form-group col-md-6">
                        <p>Classification - <b>{{$chemical->chemicalClassification->name}}</b></p>
                    </div>
                    <div class="form-group col-md-6">
                        <p>EC Number - <b>{{$chemical->ec_number}}</b></p>
                    </div>
                </div>
            </div>
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">List Details</h5>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    
                    <div class="form-group col-md-6">
                        <label for="">Category Name - {{!empty($list->categoryList->category_name) ? $list->categoryList->category_name : ''}}</label>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Classification Name - {{$list->classificationList->classification_name}}</label>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Color Code - {{ucfirst($list->color_code)}}</label>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Source Name - {{ucfirst($list->source_name)}}</label>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Source URL - {{ucfirst($list->source_url)}}</label>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Hover Message - {{ucfirst($list->hover_msg)}}</label>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="">Description
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Description"></i></span>
                        </label>
                        <textarea name="" id="" rows="5" class="form-control" readonly>{{$list->description}}</textarea>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="">Chemical Name - {{$list_product->chemical_name}}</label>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Cas No - @foreach($list_product->cas as $cas)
                                                    <span class="badge badge-info">{{$cas}}</span>
                                                    @endforeach</label>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Smiles - {{$list_product->smiles}}</label>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Inchi - {{$list_product->inchi}}</label>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">EC Number - {{$list_product->ec_number}}</label>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">IUPAC - {{$list_product->iupac}}</label>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Molecular Formula - {{$list_product->molecular_formula}}</label>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Hazard Class - {{$list_product->hazard_class}}</label>
                    </div>
                    @php
                    $picto_path="";
                    if(!empty($list_product->hazard_pictogram_details->pictogram_id)){
                        $picto_path = get_pictogram_path($list_product->hazard_pictogram_details->pictogram_id);
                    }
                    @endphp
                    <div class="form-group col-md-6">
                        <label for="">Hazard Code - {{$list_product->hazard_code}} &nbsp;
                            @if(!empty($picto_path))
                            <img src="{{url(!empty($picto_path)?$picto_path:'')}}" height="30" width="30">
                            @endif
                        </label>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Hazard Category - {{$list_product->hazard_category}}</label>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Hazard Statement - {{$list_product->hazard_statement}}</label>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">EU Hazard Statement - {{$list_product->eu_hazard_statement}}</label>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">RSL Limit - {{$list_product->rsl_limits_table}}</label>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Notes - {{$list_product->notes}}</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{url('organization/list/'.___encrypt($list->id))}}" class="btn btn-sm btn-secondary submit">
                    More Details
                </a>
                <button class="btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-edit-{{___encrypt($property['chemical_property_id'])}}" tabindex="1" role="dialog" aria-labelledby="modal-eqipLabel" aria-hidden="true">
    <div class="tab-pane" id="v-{{___encrypt($property['chemical_property_id'])}}" role="tabpanel" aria-labelledby="v-{{___encrypt($property['chemical_property_id'])}}-tab">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-eqipLabel">Edit New Property - {{$property['property_name']}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" action="{{url('product/chemical/'.___encrypt($property['product_id']).'/addprop/'.___encrypt($property['chemical_property_id']))}}" method="POST" enctype="multipart/form-data" role="property-id-edit{{___encrypt($property['property_id'])}}">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="main_property_id" value="{{___encrypt($property['property_id'])}}">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="prop_name">Select Sub Property
                                    <span class="text-danger">*</span>
                                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Sub Property"></i></span>
                                </label>
                                <select class="js-example-basic-single select2me" data-url="{{url('product/chemical/'.___encrypt($property['product_id']).'/property/'.___encrypt($property['property_id']).'/form')}}" data-type="form" data-request="ajax-append-fields" data-target="#edit-form-content-{{___encrypt($property['property_id'])}}" alt="{{___encrypt($property['property_id'])}}" name="property_id">
                                    <option value="">Select Sub Property</option>
                                    @foreach($property['sub_prop_list'] as $sub_property)
                                    <option @if(___encrypt($property['sub_property_id'])==___encrypt($sub_property['id'])) selected="" @endif value="{{___encrypt($sub_property['id'])}}">{{$sub_property['sub_property_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="edit-form-content{{___encrypt($property['property_id'])}}" id="edit-form-content-{{___encrypt($property['property_id'])}}">
                            @include('pages.console.product.chemical.manage_properties.edit.edit-dynamic-form')
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{Config::get('constants.message.loader_button_msg')}}
                        </button>
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="property-id-edit{{___encrypt($property['property_id'])}}"]' class="btn btn-sm btn-secondary submitBtn">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
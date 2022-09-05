<div class="row font-weight-normal">
    <div class="col-md-6">
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="">Category: <span class="badge badge-info">{{$process_experiment_info['category']}}</span></label>
                <label for="">Classification:
                    @if(!empty($process_experiment_info['classification']))
                    @foreach($process_experiment_info['classification'] as $classification)
                    <span class="badge badge-info">
                        {{$classification['name']}}
                    </span>
                    @endforeach
                    @endif
                </label>
                <label for="">Data Source: <span class="badge badge-info">{{$process_experiment_info['data_source']}}</span></label>
            </div>
            <div class="form-group col-md-12 experiment_unit_section_scroll">
                <label for="">Selected Experiment Units</label>
                <ul class="list-group">
                    @if(!empty($process_experiment_info['experiment_units']))
                    @foreach($process_experiment_info['experiment_units'] as $experiment_unit)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{$experiment_unit['experiment_unit_name']}}
                        <span class="badge badge-info" data-toggle="tooltip" data-placement="bottom" title="Experiment Unit Name">{{$experiment_unit['experiment_equipment_unit']['experiment_unit_name']}}</span>
                    </li>
                    @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-row">
            <div class="form-group col-md-12" style="display:none">
                <label for="">Selected Products:
                    @if(!empty($process_experiment_info['product_list']))
                    @foreach($process_experiment_info['product_list'] as $product)
                    <span class="badge badge-info">
                        {{$product['name']}}
                    </span>
                    @endforeach
                    @endif
                </label>
            </div>
            <div class="form-group col-md-12">
                <label for="">Selected Energy Utilities:
                    @if(!empty($process_experiment_info['energy_list']))
                    @foreach($process_experiment_info['energy_list'] as $energy_utility)
                    <span class="badge badge-info">
                        {{$energy_utility['energy_name']}}
                    </span>
                    @endforeach
                    @endif
                </label>
            </div>
            <div class="form-group col-md-12">
                <label for="">Main Product Input:
                    @if(!empty($process_experiment_info['main_product_inputs']))
                    @foreach($process_experiment_info['main_product_inputs'] as $product)
                    <span class="badge badge-info">
                        {{$product['name']}}
                    </span>
                    @endforeach
                    @endif
                </label>
            </div>
            <div class="form-group col-md-12">
                <label for="">Main Product Output:
                    @if(!empty($process_experiment_info['main_product_outputs']))
                    @foreach($process_experiment_info['main_product_outputs'] as $product)
                    <span class="badge badge-info">
                        {{$product['name']}}
                    </span>
                    @endforeach
                    @endif
                </label>
            </div>
            <div class="form-group col-md-6">
                <label for="">Tags</label>
                @if(!empty($process_experiment_info['tags']))
                @foreach($process_experiment_info['tags'] as $tag)
                <span class="badge badge-info">{{$tag}}</span>
                @endforeach
                @endif
            </div>
            <div class="form-group col-md-12">
                <label for="">Description</label>
                <textarea class="form-control" rows="4" readonly>{{$process_experiment_info['description']}}</textarea>
            </div>
        </div>
        
    </div>
    </div>
    <div class="table-responsive">
        <table id="chemical_list" class="table">
            <thead>
                <th>Selected Products</th>
                <th>List</th>
            </thead>
            <tbody>
                @php
                    $cnt=count($process_experiment_info['product_list'])
                @endphp
                @if(!empty($process_experiment_info['product_list']))
                @foreach($process_experiment_info['product_list'] as $product)
                <tr>
                    <td>
                        {{$product['name']}}
                    </td>
                    <td>
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                                                @php
                                                $list_unique=[];
                                                $molecular_formula = !empty($product['molecular_formula'])?$product['molecular_formula']:'';
                                                $lists="";
                                                $lists = get_list_name(!empty($product['cas_no'])?$product['cas_no']:'',$molecular_formula,$product['inchi_key'],$product['ec_number'],!empty($product['other_name'])?$product['other_name']:'');
                                                @endphp
                                                <p class="card-text">
                                                    @if(!empty($lists))
                                                    @foreach($lists as $list_detail)
                                                    @foreach($list_detail as $list)
                                                    @php
                                                    if(!in_array($list->id, $list_unique)){
                                                        $list_unique[]=$list->id;
                                                    @endphp
                                                    <b data-url="{{url('product/chemical/list_view/'.___encrypt($list->id).'/'.___encrypt($product['id']))}}" data-request="ajax-popup" data-target="#view_list_div" data-toggle="tooltip" data-tab="#viewListModal{{___encrypt($list->id)}}" data-placement="top" title="{{$list->hover_msg}}">
                                                        <span class="badge badge-danger">{{$list->list_name}}</span>
                                                    </b>
                                                    @php
                                                    }
                                                    @endphp
                                                    @endforeach
                                                    @endforeach
                                                    @else
                                                    <b><span class="badge badge-danger">No Records Found</span></b>
                                                    @endif
                                                </p>
                                                
                                            </div>
                                        </div>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>


<div id="view_list_div"></div>

<script>
    var cnt = '{{$cnt}}'
    if(cnt>10){
    $('#chemical_list').DataTable({});
    }
</script>

<div class="table">
    <table id="dataset_raw" class="table">
        <thead>
            <tr>
                <th>Stream Name <i class="fas fa-lock-open" data-toggle="tooltip" title="Open Stream"></i></th>
                <th>Value and Flow Rate</th>
                <th>Product and Percentage</th>
                @if($viewflag!="view_config")
                <th class="text-center">Actions</th>
                @endif
            </tr>
        </thead>
        <tbody class="font-weight-normal" id="outcome_raw_material">
            @if(!empty($raw_material))
            @foreach($raw_material as $count =>$process_diagram_value)
            <tr>
                <td>{{$process_diagram_value['process_diagram_name']}}</td>
                <td>
                    <div class="d-flex justify-content-between align-items-center">
                        <p data-toggle="tooltip" data-placement="top" title="Flow Rate">
                            {{!empty($process_diagram_value['value_flow_rate'])?$process_diagram_value['value_flow_rate']:0}}
                            {{$process_diagram_value['unit_constant_name']}}
                        </p>
                    </div>
                </td>
                <td>
                    <div>
                        @if(!empty($process_diagram_value['product']))
                        @php
                        $k=1;
                        @endphp
                        @foreach($process_diagram_value['product'] as $key=>$product)
                        <div class="d-flex align-items-center">
                                <div class="col-md-6">
                                    <p>{{$k}}. {{$product['product_name']}}</p>
                                </div>
                                <div class="6">
                                    <span class="badge badge-info align-right">{{!empty($product['value'])?$product['value']:0}}&#37;</span>
                                </div>
                        </div>
                        @php
                        $k++;
                        @endphp
                        @endforeach
                        @endif
                    </div>
                </td>
                @if($viewflag!="view_config")
                <td class="text-center">
                    <a href="javascript:void(0);" data-url="{{url('experiment/raw_material/'.___encrypt($process_diagram_value['pfd_stream_id']).'/popup?simulate_input_id='.___encrypt($simulate_input->id))}}" data-request="ajax-popup" data-count="{{$count}}" data-target="#editprocessdiagram" data-tab="#pd{{___encrypt($process_diagram_value['pfd_stream_id'])}}" type="button" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit Stream Details">
                        <i class="fas fa-edit text-secondary"></i>
                    </a>
                </td>
                @endif
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>
<div id="editprocessdiagram"></div>

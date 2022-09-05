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
        <!-- <ol> -->
        <div class="row">
            @if(!empty($process_diagram_value['product']))
            @foreach($process_diagram_value['product'] as $key=>$product)
            <div class="col-md-4">{{$product['product_name']}}</div>
            <!-- <li class="d-flex justify-content-between align-items-center text-center">{{$product['product_name']}} -->
            <div class="col-md-4">
                @if($product['criteria_data']['is_range_type'] == 'true')
                <i class="text-secondary criteria-arrow" data-toggle="tooltip" title="{{$product['criteria_data']['name']}}">{{$product['criteria_data']['symbol']}}</i>
                @else
                <i class="text-secondary criteria-arrow" data-toggle="tooltip" title="{{$product['criteria_data']['name']}}">{{$product['criteria_data']['symbol']}}</i>
                @endif
            </div>
            <div class="col-md-4">
                {{!empty($product['value'])?$product['value']:0}}&#37;
                @if($product['criteria_data']['is_range_type']=='true')
                - {{$product['max_value']}}&#37;
                @endif
            </div>
            </li>
            @endforeach
            @endif
            <!-- </ol> -->
        </div>
    </td>
    <td class="text-wrap width-100 text-left">
        <a href="javascript:void(0);" data-count="{{$count}}" data-url="{{url('experiment/raw_material/'.___encrypt($process_diagram_value['pfd_stream_id']).'/popup_set_point?simulate_input_id='.___encrypt($simulate_input->id).'&count='.$count)}}" data-request="ajax-popup" data-target="#editprocessdiagram" data-tab="#pd{{___encrypt($process_diagram_value['pfd_stream_id'])}}" type="button" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit Stream Details">
            <i class="fas fa-edit text-secondary"></i>
        </a>
    </td>
</tr>
@endforeach
@endif
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
            $ks=0;
            @endphp
            @foreach($process_diagram_value['product'] as $key=>$product)
            <div class="d-flex justify-content-between align-items-center">
                <p>{{$ks+1}}. {{$product['product_name']}}</p>
                <span class="badge badge-info align-right">{{!empty($product['value'])?$product['value']:0}}&#37;</span>
            </div>
            @php
            $ks++;
            @endphp
            @endforeach
            @endif
        </div>
    </td>

    <td class="text-center">
        <a href="javascript:void(0);" data-url="{{url('experiment/raw_material/'.___encrypt($process_diagram_value['pfd_stream_id']).'/popup?simulate_input_id='.___encrypt($simulate_input->id))}}" data-count="{{$count}}" data-request="ajax-popup" data-target="#editprocessdiagram" data-tab="#pd{{___encrypt($process_diagram_value['pfd_stream_id'])}}" type="button" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit Stream Details">
            <i class="fas fa-edit text-secondary"></i>
        </a>
    </td>

</tr>
@endforeach
@endif

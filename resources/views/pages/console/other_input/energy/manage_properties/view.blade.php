@php 
$per = request()->get('sub_menu_permission');
$permission=!empty($per['properties']['method'])?$per['properties']['method']:[];
@endphp
@foreach($property['sub_property'] as $sub_prop)
@if(!empty($sub_prop['energy_properties']))
<div class="col-md-12 mb-3 card shadow">
    <div class="card-header">
        <h5 class="mb-3 mb-md-0">{{$sub_prop['sub_property_name']}}</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <th>Details</th>
                    <th>Recommended</th>
                    <th class="text-center">Actions</th>
                </thead>
                <tbody>
                    @foreach($sub_prop['energy_properties'] as $energy_prop)
                    <tr id="remove-section-chemical-prop{{$energy_prop['id']}}">
                        <td>
                            @if(!empty($energy_prop['dynamic_json']))
                            <ul class="list-group">
                                @foreach($energy_prop['dynamic_json'] as $key_name => $prop_value)
                                @php
                                $arr = array(5, 6, 7);
                                @endphp
                                @if(in_array($prop_value['field_type_id'],$arr))
                                @if(!empty($prop_value['select_list']['units']))
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>{{$prop_value['field_name']}} : </strong>
                                    <span class="badge badge-secondary badge-pill">
                                        {{!empty($prop_value['value'])?$prop_value['value']:''}}
                                        @foreach($prop_value['select_list']['units'] as $list)
                                        @if($prop_value['field_type_id']==7)
                                        @if(in_array($list['id'],$prop_value['unit_constant_id']))
                                        {{$list['unit_name']}},
                                        @endif
                                        @else
                                        @if($list['id']==$prop_value['unit_constant_id'])
                                        {{$list['unit_name']}}
                                        @endif
                                        @endif
                                        @endforeach
                                    </span>
                                </li>
                                @endif
                                @elseif($prop_value['field_type_id']=='13')
                                <!--Start ADD MORE  -->
                                @foreach($prop_value['select_list'] as $key_add_more => $add_more_lists)
                                @if(!empty($add_more_lists['add_more']))
                                @foreach($add_more_lists['add_more'] as $last_loop)
                                @if(!empty($last_loop))
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>{{$last_loop['name']}} : </strong>
                                    <span class="badge badge-secondary badge-pill">
                                        {{!empty($last_loop['value'])?$last_loop['value']:''}}
                                        @foreach($last_loop['units'] as $lists)
                                        @if($lists['id']==$last_loop['unit_constant_id'])
                                        {{$lists['unit_name']}}
                                        @endif
                                        @endforeach
                                    </span>
                                </li>
                                @endif
                                @endforeach
                                @endif

                                @if($add_more_lists['refrence_source'])
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>Refrence Source</strong>
                                    <span class="badge badge-secondary badge-pill">
                                        {{!empty($add_more_lists['refrence_source'])?$add_more_lists['refrence_source']:''}}
                                    </span>
                                </li>
                                @endif
                                @if($add_more_lists['recommended'])
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>Recommended</strong>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" data-url="{{url('/other_inputs/energy/'.___encrypt($energy_prop['energy_id']).'/addprop/'.___encrypt($energy_prop['id']).'?add_more_id='.$add_more_lists['add_more_id'].'&status='.$add_more_lists['recommended'].'&type=add_more')}}" data-ask="Are you sure you want to change Recommended?" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" class="custom-control-input" id="customSwitchList{{$energy_prop['id']}}{{___encrypt($key_add_more)}}" @if($add_more_lists['recommended']=='on' ) checked @endif>
                                        <label class="custom-control-label" for="customSwitchList{{$energy_prop['id']}}{{___encrypt($key_add_more)}}"></label>
                                    </div>
                                </li>
                                @endif
                                <hr>
                                @endforeach
                                <!--END ADD MORE  -->
                                @else
                                @if(!empty($prop_value['value']))
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>{{!empty($prop_value['field_name'])?$prop_value['field_name']:''}}</strong>
                                    @if(!empty($prop_value['value']))
                                    @if($prop_value['field_type_id']=='11')
                                    <span>
                                        : <a target="_blank" href="{{url(!empty($prop_value['value'])?$prop_value['value']:'')}}" download="">{{url(!empty($prop_value['value'])?$prop_value['value']:'')}}</a>
                                    </span>
                                    @else
                                    <span class="badge badge-secondary badge-pill">
                                        {{!empty($prop_value['value'])?$prop_value['value']:''}}
                                    </span>
                                    @endif
                                    @endif
                                </li>
                                @endif
                                @endif
                                @endforeach
                            </ul>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" data-url="{{url('/other_inputs/energy/'.___encrypt($energy_prop['energy_id']).'/addprop/'.___encrypt($energy_prop['id']).'?status='.$energy_prop['recommended'].'&type='.$energy_prop['recommended'])}}" data-ask="Are you sure you want to change Recommended?" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" class="custom-control-input" id="customSwitch{{___encrypt($energy_prop['id'])}}" @if($energy_prop['recommended']=='on' ) checked @endif>
                                <label class="custom-control-label" for="customSwitch{{___encrypt($energy_prop['id'])}}"></label>
                            </div>
                        </td>
                        <td class="text-center">
                            <a class="btn btn-icon">
                                <i class="fas fa-history text-secondary" data-toggle="tooltip" title="Created DateTime - {{$energy_prop['created_at']}}"></i>
                                <i class="fas fa-clock text-secondary" data-toggle="tooltip" title="Updated DateTime - {{$energy_prop['updated_at']}}"></i>
                            </a>
                            <a href="javascript:void(0);" data-request="ajax-popup" data-target="#edit-property" data-tab="#modal-edit-{{___encrypt($energy_prop['id'])}}" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit Energy Property"
                                @if(in_array('edit',$permission))
                                data-url="{{ url('other_inputs/energy/'.___encrypt($energy_prop['energy_id']).'/addprop/'.___encrypt($energy_prop['id']).'/edit') }}"
                                @else
                                    data-request="ajax-permission-denied"
                                @endif
                            >
                                <i class="fas fa-edit text-secondary"></i>
                            </a>
                            <a href="javascript:void(0);" data-method="DELETE" data-target="#remove-section-chemical-prop{{$energy_prop['id']}}" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Delete Energy Property"
                                @if(in_array('delete',$permission))
                                    data-url="{{ url('other_inputs/energy/'.___encrypt($energy_prop['energy_id']).'/addprop/'.___encrypt($energy_prop['id'])) }}" 
                                @else
                                    data-request="ajax-permission-denied"
                                @endif
                            >
                                <i class="fas fa-trash text-secondary"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endforeach
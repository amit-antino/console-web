@php
$cnt=count($data_curation)
@endphp
@if(!empty($data_curation))
@foreach($data_curation as $pro)
<tr>
    <td><input type="checkbox" value="{{___encrypt($pro->id)}}" class="checkSingle" name="select_all[]"></td>
    <td>{{$pro->name}}</td>
    <td>{{$pro->data_set_experiment_id}}</td>
    <td>{{dateFormate($pro->created_at)}}</td>
    <!-- <td>{{$pro->tags}}</td> -->
    <!-- <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" data-url="{{url('data_management/data_curation/'.___encrypt($pro->id).'?status='.$pro->status)}}" data-ask="Are you sure ? You want change Status." data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" id="customSwitch{{___encrypt($pro->id)}}" @if($pro->status=='active') checked @endif>
                                        <label class="custom-control-label" for="customSwitch{{___encrypt($pro->id)}}"></label>
                                    </div>
                                </td> -->
    <td class="text-center">
        @if ($pro->status == 'success')
        <i class="fas fa-check-circle text-success" data-toggle="tooltip" data-placement="bottom" title="Success"></i>
        @elseif($pro->status == 'failure')
        <i class="fas fa-times-circle text-danger" data-toggle="tooltip" data-placement="bottom" title="Failed {{$pro->message}}"></i>
        @else
        <i class="fas fa-sync-alt text-warning" data-toggle="tooltip" data-placement="bottom" title="Processing"></i>
        @endif
    </td>
    <td class="text-center">
        <div class="btn-group btn-group-sm" role="group">
            @if ($pro->status == 'success')
            <a href="{{url('data_management/data_curation/'.___encrypt($pro->id))}}" data-url="" data-tab="#editProjectModal{{___encrypt($pro->id)}}" data-target="#edit-div" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="view Curation">
                <i class="fas fa-eye  text-secondary"></i>
            </a>
            @else
            <a type="button" href="javascript:void(0);" data-url="{{ url('data_management/data_curation/' . ___encrypt($pro->id) . '/retry') }}" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to retry?" type="button" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Try Again">
                <i class="fas fa-redo text-secondary"></i>
            </a>
            @endif
            <a href="javascript:void(0);" data-url="{{url('data_management/data_curation/'.___encrypt($pro->id))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Delete Curation">
                <i class="fas fa-trash text-secondary"></i>
            </a>
        </div>
    </td>
</tr>
@endforeach
@endif
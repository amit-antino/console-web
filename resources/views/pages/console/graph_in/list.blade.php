    @if(!empty($tolerances))
    @foreach($tolerances as $tolerance)
    <tr>
        <!-- <td><input type="checkbox" value="{{___encrypt($tolerance->id)}}" class="checkSingle" name="select_all[]"></td> -->
        <td>{{$tolerance->tolerance_value}}</td>

        <td class="text-center">
            @if($tolerance->status == 'success')
            <i class="fas fa-check-circle text-success" data-toggle="tooltip" data-placement="bottom" title="Success"></i>
            @elseif($tolerance->status == 'failure')
            <i class="fas fa-times-circle text-danger" data-toggle="tooltip" data-placement="bottom" title="Failed"></i>
            @else
            <i class="fas fa-sync-alt text-warning" data-toggle="tooltip" data-placement="bottom" title="Processing"></i>
            @endif
        </td>
        <td class="text-center">
            <div class="btn-group btn-group-sm" role="group">
                @if($tolerance->status=='success')
                <a href="{{url('/graph-in/'.___encrypt($tolerance->id))}}" class="btn btn-icon" data-toggle=" tooltip" data-placement="bottom" title="edit">
                    <i class="fas fa-eye text-secondary"></i>
                </a>
                @endif
                <a href="javascript:void(0);" data-url="{{ url('/graph-in/'.___encrypt($tolerance->id)) }}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" type="button" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Delete Data">
                    <i class="fas fa-trash text-secondary"></i>
                </a>
            </div>
        </td>
    </tr>
    @endforeach
    @endif
@php
    $ps_selected=[]; 
@endphp
@foreach($simulation_data as $key=>$data)
@php
    $ps_selected[]=$data['process_simulation']; 
@endphp
<tr>
    <td>
        {{$data['process_simulation_name']}}
        <input type="hidden" name="simulation[]">
    </td>
    <td>
        {{$data['simulation_type_name']}}
        <input type="hidden" name="process_sim[]">
    </td>
    <td>
        {{$data['dataset_name']}}
        <input type="hidden" name="process_sim[]">
    </td>
    <td>
        <button type="button" class="btn btn-sm btn-icon" data-request="add-another-display-text" data-target="#process-simulation" data-url="{{url('/product_system/product-addmore')}}" data-count="0" data-status="true" data-remove="{{$key}}" data-toggle="tooltip" data-placement="bottom" title="Delete">
            <i class="fas fa-minus text-secondary"></i>
        </button>
    </td>
</tr>
@endforeach

<script>
    ps_selected = <?php echo '["' . implode('", "', $ps_selected) . '"]' ?>;
    update_list()
    function update_list(){
        $("#process_simulation option").each(function()
        {
            if(jQuery.inArray($(this).val(), ps_selected)==-1){
                $(this).prop('disabled', false);
            }else{
                $(this).prop('disabled', true);
            }
        });
        $("#process_simulation").val('').trigger('change')
        $("#simulation_type").val('').trigger('change')
        $("#dataset").val('').trigger('change')
    }
</script>
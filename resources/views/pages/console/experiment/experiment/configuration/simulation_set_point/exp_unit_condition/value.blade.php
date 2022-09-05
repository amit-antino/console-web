<div id="range_value">
    @if($type=='raw_material')
        <input type="number" min="0.0000000001" data-request="isnumeric" id="max_value" placeholder="max Value" name="product_arr[{{$count}}][max_value]" class="form-control">
    @else
    <input type="number" min="0.0000000001" data-request="isnumeric" id="max_value" placeholder="max Value" name="max_value" class="form-control">
    @endif
</div>
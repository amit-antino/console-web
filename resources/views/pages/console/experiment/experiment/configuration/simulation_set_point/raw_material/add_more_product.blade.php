<div class="col-md-12" id="remove-raw-material-product{{$data['count']}}">
    <div class="form-row">
        <div class="form-group col-md-4">
            <select class="form-control rm_product" onchange="check_duplicate($(this))" id="product_id{{$data['count']}}" name="product_arr[{{$data['count']}}][product_id]">
                <option value="">Select Product</option>
                @if(!empty($data['product']))
                @foreach($data['product'] as $chemical)
                @if(!empty($data['request']->product_id))
                <option @if(___decrypt($data['request']->product_id)==$chemical->id)) selected @endif
                    value="{{___encrypt($chemical->id)}}">{{$chemical->chemical_name}}</option>
                @else
                <option value="{{___encrypt($chemical->id)}}">{{$chemical->chemical_name}}</option>
                @endif
                @endforeach
                @endif
            </select>
        </div>
        <div class="form-group col-md-3">
            <select data-target="#setpoint-raw-material-value{{$data['count']}}" data-count="{{$data['count']}}" data-method="POST" data-type="raw_material" data-request="ajax-append-fields" data-url="{{url('experiment/experiment/range-value-field')}}" class="form-control" id="criteria{{$data['count']}}" name="product_arr[{{$data['count']}}][criteria]">
                <option value="">Select Criteria</option>
                @if(!empty($criteria))
                @foreach($criteria as $criterias)
                <option value="{{___encrypt($criterias->id)}}">{{$criterias->name}}</option>
                @endforeach
                @endif
            </select>
        </div>
        <div class="form-group col-md-4">
            <div class="form-row ">
                <div class="input-group">
                    <div class="col-md-12">
                    <input type="number" min="0.0000000001" data-request="isnumeric" class="form-control" value="{{$data['total']}}" id="value{{$data['count']}}" name="product_arr[{{$data['count']}}][value]" placeholder="Enter Total Value">
                    </div>
                    <div class="col-md-12">
                    <div id="setpoint-raw-material-value{{$data['count']}}">
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group col-md-1 ">
            <button type="button" class="btn btn-danger btn-sm btn-icon" data-request="remove" data-target="#remove-raw-material-product{{$data['count']}}">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>


<script>
setval({{$data['count']}})
</script>

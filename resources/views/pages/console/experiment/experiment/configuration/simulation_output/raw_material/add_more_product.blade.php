<div class="col-md-12" id="remove-raw-material-product{{$data['count']}}">
    <div class="form-row">
        <div class="form-group col-md-6">
           
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
        <div class="form-group col-md-5">
            <div class="form-row">
                <div class="input-group">
                    <input type="number" min="0.0000000001" data-request="isnumeric" class="form-control" value="{{$data['total']}}" id="value{{$data['count']}}" name="product_arr[{{$data['count']}}][value]" placeholder="Enter Total Value">
                </div>
            </div>
        </div>
        <div class="form-group col-md-1">
            <button type="button" class="btn btn-sm btn-icon" data-request="remove" data-target="#remove-raw-material-product{{$data['count']}}" data-toggle="tooltip" title="Remove">
                <i class="fas fa-minus text-danger"></i>
            </button>
        </div>
    </div>


<script type="text/javascript" style="display: none">
    setval('{{$data['count']}}').style.visibility = "hidden";
   </script>

@if($type=='mass_balance')
<div id="remove-section-mass_balance-{{$count+1}}">
    <div class="form-row">
        <div class="form-group col-md-11">
            <input type="text" class="form-control" name="mass_balance[{{$count+1}}][data_source]" placeholder="Enter Mass Balance Data Source">
        </div>
        <div class="form-group col-md-1">
            <button type="button" class="btn btn-sm btn-secondary btn-icon" data-target="#remove-section-mass_balance-{{$count+1}}" data-count="{{$count+1}}" data-type="mass_balance" data-request="remove">
                <i class="fas fa-minus-circle"></i>
            </button>
        </div>
    </div>
</div>
@else
<div id="remove-section-{{$count+1}}">
    <div class="form-row">
        <div class="form-group col-md-11">
            <input type="text" class="form-control" name="enery_utilities[{{$count+1}}][data_source]" placeholder="Enter Energy Utilities Data Source">
        </div>
        <div class="form-group col-md-1">
            <button type="button" class="btn btn-sm btn-secondary btn-icon" data-target="#remove-section-{{$count+1}}" data-count="{{$count+1}}" data-type="enery_utilities" data-request="remove">
                <i class="fas fa-minus-circle"></i>
            </button>
        </div>
    </div>
</div>
@endif
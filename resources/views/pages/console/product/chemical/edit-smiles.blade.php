@php 
$nw_count = 1 ;
$count=0;
@endphp
@if(!empty($chemical->smiles))

@php $nw_count = count($chemical->smiles) @endphp
@foreach($chemical->smiles as  $smiles)
<div id="remove-section-{{$count}}">
    <div class="form-group">
        <div class="row">
            <div class="col-sm-4">
                <select class="form-control js-example-basic-single" name="smiles[{{$count}}][types]">
                    <option @if($smiles['types']=='isotopes' ) selected @endif value="isotopes">Isotopes</option>
                    <option @if($smiles['types']=='canonical' ) selected @endif value="canonical">Canonical</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <input type="text" class="form-control" name="smiles[{{$count}}][smile]" placeholder="Enter SMILES" value="{{$smiles['smile']}}">
            </div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-icon" data-target="#remove-section-{{$count}}" data-count="{{$count}}" data-type="reactant" data-request="remove">
                    <i class="fas fa-minus text-secondary"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@php 
$count++;
@endphp
@endforeach
@endif
<div class="row">
    <div class="col-sm-4">
        <select class="form-control js-example-basic-single" name="smiles[{{$nw_count}}][types]">
            <option value="isotopes">Isotopes</option>
            <option value="canonical">Canonical</option>
        </select>
    </div>
    <div class="form-group col-md-6">
        <input type="text" class="form-control" name="smiles[{{$nw_count}}][smile]" placeholder="Enter SMILES">
    </div>
    <div class="col-sm-2">
        <button type="button" class="btn btn-sm btn-secondary" data-types="smiles" data-target="#smiles" data-url="{{url('add-more-chemicals-field')}}" data-request="add-another" data-count="{{$nw_count}}">
            <i class="fas fa-plus-circle"></i>
        </button>
    </div>
</div>
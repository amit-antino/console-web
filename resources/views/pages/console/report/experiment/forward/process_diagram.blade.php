<div class="card-body mb-3 grid-margin text-center">
    @if(!empty($data['process_diagram']['var_img']['process_flow_chart']))
    <img src="{{url($data['process_diagram']['var_img']['process_flow_chart'])}}" alt="Image" class="img-fluid" height="600" width="1000" />
    @else
    <img src="{{url('assets/images/Reckitt_PFD.png')}}" alt="Image" class="img-fluid" height="600" width="1000" />
    @endif
</div>
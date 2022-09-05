<div class="row">
    @if(!empty($data['list_of_models']))
    <div class="col-md-12 grid-margin stretch-card">
        <div class="p pl-3">
            <ol class="list-group">
                @if(!empty($data['list_of_models']))
                @foreach($data['list_of_models'] as $model)
                <li class="font-weight-normal" data-toggle="tooltip" data-placement="bottom" title="Model Name">
                    {{str_replace("_", " ", $model)}}
                </li>
                @endforeach
                @endif
            </ol>
        </div>
    </div>
    @endif
</div>
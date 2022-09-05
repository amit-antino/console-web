<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="p pl-3">
            <ol class="list-group">
                @if(!empty($data['assumptions']))
                @foreach($data['assumptions'] as $assumption)
                <li class="font-weight-normal">
                    {{str_replace("_", " ", $assumption)}}
                </li>
                @endforeach
                @endif
            </ol>
        </div>
    </div>
</div>
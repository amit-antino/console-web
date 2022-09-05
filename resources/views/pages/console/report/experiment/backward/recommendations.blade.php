<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="p pl-3">
            <ol class="list-group">
                @if(!empty($data['recommendations']))
                @foreach($data['recommendations'] as $recommendation)
                <li class="font-weight-normal">
                    {{str_replace("_", " ", $recommendation)}}
                </li>
                @endforeach
                @endif
            </ol>
        </div>
    </div>
</div>
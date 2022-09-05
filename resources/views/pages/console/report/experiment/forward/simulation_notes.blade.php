<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="p pl-3">
            <ol class="list-group">
                @if(!empty($data['simulation_notes']))
                @foreach($data['simulation_notes'] as $note)
                <li class="font-weight-normal">
                    {{str_replace("_", " ", $note)}}
                </li>
                @endforeach
                @endif
            </ol>
        </div>
    </div>

</div>
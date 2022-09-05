<div class="row">
    <div class="col-md-2" id="stream_list_div">
        <div class="nav nav-tabs nav-tabs-vertical unit_specification_scroll" id="v-tab" role="tablist" aria-orientation="vertical">
            @if(!empty($processdiagram))
            @foreach($processdiagram as $pd)
            @if(!empty($pd['to_unit']))
            <?php $stream_id = ___encrypt($pd['id']);
            $stream_name = $pd['name'];
            $tab_id = ___encrypt($pd['id']);
            ?>
            <a class="nav-link profilenav" onclick='testing("{{$stream_id}}","{{$tab_id}}")' id="v-expdata-tab" data-toggle="pill" href="#v-expdata" role="tab" aria-controls="v-expdata" aria-selected="true">{{$pd['name']}}</a>
            @endif
            @endforeach
            @endif
        </div>
    </div>
    <div class="col-md-10" id="data_div">
        <div class="tab-content tab-content-vertical border p-3" id="v-tabContent">
            <div class="mb-3 grid-margin" id="setData"></div>
        </div>
    </div>

    <div class="col-md-12 mt-2 @if($template_used!='yes') text-right @endif">
        @if($template_used=='yes')
        <div class="alert alert-warning">
            <strong>Note!</strong> Template is being used in simulation inputs section, please delete the simulation inputs before changing or deleting the template itself.
        </div>
        @endif
        <input type="hidden" id="setexpcon" value="1" />
        <button type="button " onclick="save_data()" class="btn btn-sm btn-secondary submit" @if($template_used=='yes' ) style="display:none" @endif>Submit</button>
    </div>
</div>
<label for="description">Update model code (<span id="file_name_view"></span>)
    <i data-toggle="tooltip" title="Add Description. You can enter maximum 1000 characters. " class="icon-sm" data-feather="info" data-placement="top"></i>
</label>
<div id="ace_html">
    <textarea id="ace_html" name="ace_html" class="ace-editor w-100 ace_editor_val txt">
    {{$contentfile}}
    </textarea>
</div>

<script>
    if ($('#ace_html').length) {
        $(function() {
            var editor = ace.edit("ace_html");
            editor.setTheme("ace/theme/dracula");
            editor.getSession().setMode("ace/mode/html");
            editor.setOption("showPrintMargin", false)
        });
    }
</script>
<select data-width="100%" class="form-control" onchange="getFileContent(this.value)" id="associated_file_md" name="associated_file_md" required>
    <option value="">Select Files</option>
    @if(!empty($data->files))
    @foreach($data->files as $k=>$v)
    <option value="{{$k}}">{{$v['filename']}}</option>
    @endforeach
    @endif
</select>
<input type="hidden" id="mid" value="{{$data->id}}">
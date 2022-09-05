@extends('layout.admin.master')
@push('plugin-styles')
<link href="{{asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endpush
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/admin/master/chemical/hazard/hazard')}}">Hazard Statement</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Hazard Statement</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form action="{{url('admin/master/chemical/hazard/hazard/'.___encrypt($hazards->id))}}" role="hazard-edit" method="POST">
                <input type="hidden" name="_method" value="PUT">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Edit Hazard Statement</h4>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="hazard_class_id">Hazard Class
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Hazard Class"></i></span>
                            </label>

                            <select id="hazard_class_id" class="js-example-basic-multiple form-control" name="hazard_class_id[]" multiple>
                                @if(!empty($hazard_classes))
                                @foreach($hazard_classes as $hazard_class)
                                <option @if(in_array($hazard_class->id,$hazards->hazard_class_id)) selected="" @endif value="{{___encrypt($hazard_class->id)}}">{{$hazard_class->hazard_class_name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="hazard_category_id">Hazard Category
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Hazard Category"></i></span>
                            </label>
                            <select id="hazard_category_id" class="js-example-basic-multiple" name="hazard_category_id[]" multiple>
                                @if(!empty($hazard_categories))
                                @foreach($hazard_categories as $hazard_category)
                                <option @if(in_array($hazard_category->id,$hazards->category_id)) selected="" @endif value="{{___encrypt($hazard_category->id)}}">{{$hazard_category->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="hazard_pictogram_id">Hazard Pictogram
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Hazard Pictogram"></i></span>
                            </label>
                            <select id="hazard_pictogram_id" class="js-example-basic-single" name="hazard_pictogram_id">
                                <option @if($hazards->pictogram_id == 0) selected="" @endif value="{{___encrypt(0)}}">None</option>
                                @if(!empty($hazard_pictograms))
                                @foreach($hazard_pictograms as $hazard_pictogram)
                                <option @if(___encrypt($hazard_pictogram->id) == ___encrypt($hazards->pictogram_id)) selected="" @endif value="{{___encrypt($hazard_pictogram->id)}}">{{$hazard_pictogram->title}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="signal_word">Signal Word
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Signal Word"></i></span>
                            </label>
                            <select id="signal_word" class="form-control" name="signal_word">
                                <option value="">Select Signal Word</option>
                                <option @if('Danger'==$hazards->signal_word) selected="" @endif value="Danger">Danger</option>
                                <option @if('Warning'==$hazards->signal_word) selected="" @endif value="Warning">Warning</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="code">Code
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Code"></i></span>
                            </label>
                            <input type="text" id="code" class="form-control" value="{{$hazards->hazard_code}}" name="code" placeholder="Enter Code">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="hazard_statement">Hazard Statement
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Hazard Statement"></i></span>
                            </label>
                            <input type="text" id="hazard_statement" class="form-control" value="{{$hazards->hazard_statement}}" name="hazard_statement" placeholder="Enter Hazard Statement">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="p_codes">P-Codes
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select P-Codes"></i></span>
                            </label>
                            <select id="p_codes" class="js-example-basic-multiple form-control" multiple="" name="p_codes[]">
                                @if(!empty($code_statements))
                                @foreach($code_statements as $code_statement)
                                @php
                                if(!empty($hazards->code_statement_id)){
                                $codes=$hazards->code_statement_id;
                                }else{
                                $codes=[];
                                }
                                @endphp
                                <option @if(in_array($code_statement->id,$codes)) selected="" @endif value="{{___encrypt($code_statement->id)}}">{{$code_statement->code}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="hazard-edit"]' class="btn btn-sm btn-secondary submit">Submit</button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{Config::get('constants.message.loader_button_msg')}}
                        </button>
                        <a href="{{ url('/admin/master/chemical/hazard/hazard') }}" class="btn btn-sm btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('plugin-scripts')
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
@endpush
@push('custom-scripts')
<script>
    $(function() {
        if ($(".js-example-basic-single").length) {
            $(".js-example-basic-single").select2();
        }
        if ($(".js-example-basic-multiple").length) {
            $(".js-example-basic-multiple").select2();
        }
    });
</script>
@endpush

<div class="tab-pane fade" id="v-note" role="tabpanel" aria-labelledby="v-note-tab">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <form method="POST" action="{{url('/other_inputs/reaction/'.___encrypt($reaction_id).'/addprop')}}" role="reaction-note">
                    <div class="card-header">
                        <h4 class="card-title">Notes</h4>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="type" value="notes_editor">
                        <textarea class="form-control" name="note" id="simpleMdeExample" rows="5">@if(!empty($reaction_data['notes'])) {{$reaction_data['notes']}} @endif </textarea>
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="reaction-note"]' class="btn btn-sm btn-secondary">Submit</button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{Config::get('constants.message.loader_button_msg')}}
                        </button>
                        <button type="reset" class="btn btn-sm btn-danger">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
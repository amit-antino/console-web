 <div id="remove-section-{{$count+1}}">
     <div class="form-group">
         <!-- <label class="control-label">SMILES <i data-toggle="tooltip" title="" data-original-title="Enter Molecular Formula. You can enter maximum 50 values comma seperated. Example: CH3CH2CH2CH2OH, C4H9OH" sclass="mdi mdi-information-outline"></i></label> -->
         <div class="row">
             <div class="col-sm-4">
                 <select class="form-control" name="smiles[{{$count+1}}][types]">
                     <option value="isotopes">Isotopes</option>
                     <option value="canonical">Canonical</option>
                 </select>
             </div>
             <div class="form-group col-md-6">
                 <input type="text" class="form-control" name="smiles[{{$count+1}}][smile]" placeholder="Enter SMILES">
             </div>
             <div class="col-sm-2">
                 <button type="button" class="btn btn-sm btn-danger" data-target="#remove-section-{{$count+1}}" data-count="{{$count+1}}" data-type="reactant" data-request="remove">
                     <i class="fas fa-minus-circle"></i>
                 </button>
             </div>
         </div>
     </div>
 </div>
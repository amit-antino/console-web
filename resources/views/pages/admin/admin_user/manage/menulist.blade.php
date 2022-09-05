 <div class="grid-margin stretch-card">
     <div class="card border-left-secondary shadow h-100 py-2">
         <div class="form-group col-md-12">
             <label for="role_access_level">Permission
                 <span class="text-danger">*</span>
                 <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Menu Group Access Level"></i></span>
             </label>
             <div>
                 <div class="form-check form-check-inline">
                     <label class="form-check-label">
                         <input type="checkbox" id="select-all" class="form-check-input">
                         Check All
                     </label>
                 </div>
             </div>

         </div>

         <div class="form-group col-md-12">
             <div class="row">
                 @if(!empty($data['value']))
                 @foreach($data['value'] as $sk =>$sv)
                 <div class="col-md-6 grid-margin stretch-card">
                     <div class="card border-left-secondary shadow h-100 py-2">
                         <div class="card-header">
                             <div class="row no-gutters align-items-center">
                                 <i data-feather="{{$sv['menu_icon']}}" class="text-secondary text-gray-200 link-icon"></i> &nbsp;
                                 <div class="col mr-2">
                                     <div class="h5 font-weight-bold text-secondary text-uppercase">
                                         {{$sv['menu']}}
                                         &nbsp; &nbsp; &nbsp;
                                     </div>
                                 </div>
                                 <div class="col-auto">
                                     <div class="form-check form-check-inline ">
                                         <label class="form-check-label">
                                             <input type="checkbox" id="{{$sv['menu_id']}}" class="form-check-input select-sub">
                                         </label>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         @if(!empty($sv['submenu']))
                         <div class="card-body">
                             @foreach($sv['submenu'] as $subk=>$subv)
                             <div class="row">
                                 <div class="col-sm-3">
                                     {{$subv['name']}}
                                 </div>
                                 <div class="col-sm-9 table-responsive">
                                     <div class=" form-check form-check-inline">
                                         <label class="form-check-label">
                                             <input type="checkbox" name="permission[{{$subv['id']}}][index]" class="form-check-input">
                                             Read
                                         </label>
                                     </div>
                                     <div class="form-check form-check-inline">
                                         <label class="form-check-label">
                                             <input type="checkbox" name="permission[{{$subv['id']}}][create]" class="form-check-input">
                                             Create
                                         </label>
                                     </div>
                                     <div class="form-check form-check-inline">
                                         <label class="form-check-label">
                                             <input type="checkbox" name="permission[{{$subv['id']}}][show]" class="form-check-input">
                                             View
                                         </label>
                                     </div>
                                     <div class="form-check form-check-inline">
                                         <label class="form-check-label">
                                             <input type="checkbox" name="permission[{{$subv['id']}}][edit]" class="form-check-input">
                                             Edit
                                         </label>
                                     </div>
                                     <div class="form-check form-check-inline">
                                         <label class="form-check-label">
                                             <input type="checkbox" name="permission[{{$subv['id']}}][delete]" class="form-check-input">
                                             Delete
                                         </label>
                                     </div>
                                     <div class="form-check form-check-inline">
                                         <label class="form-check-label">
                                             <input type="checkbox" name="permission[{{$subv['id']}}][manage]" class="form-check-input">
                                             Manage
                                         </label>
                                     </div>
                                 </div>
                             </div>
                             @endforeach
                         </div>
                         @else
                         <div class="card-body">
                             <div class="form-check form-check-inline">
                                 <label class="form-check-label">
                                     <input @if($sv['menu_id']==1) checked @endif type="checkbox" name="permission[{{$sv['menu_id']}}][index]" class="form-check-input">
                                     Read
                                 </label>
                             </div>
                             @if($sv['menu_id']!=1)
                             <div class="form-check form-check-inline">
                                 <label class="form-check-label">
                                     <input type="checkbox" name="permission[{{$sv['menu_id']}}][create]" class="form-check-input">
                                     Create
                                 </label>
                             </div>
                             <div class="form-check form-check-inline">
                                 <label class="form-check-label">
                                     <input type="checkbox" name="permission[{{$sv['menu_id']}}][show]" class="form-check-input">
                                     View
                                 </label>
                             </div>
                             <div class="form-check form-check-inline">
                                 <label class="form-check-label">
                                     <input type="checkbox" name="permission[{{$sv['menu_id']}}][edit]" class="form-check-input">
                                     Edit
                                 </label>
                             </div>
                             <div class="form-check form-check-inline">
                                 <label class="form-check-label">
                                     <input type="checkbox" name="permission[{{$sv['menu_id']}}][delete]" class="form-check-input">
                                     Delete
                                 </label>
                             </div>
                             <div class="form-check form-check-inline">
                                 <label class="form-check-label">
                                     <input type="checkbox" name="permission[{{$sv['menu_id']}}][manage]" class="form-check-input">
                                     Manage
                                 </label>
                             </div>
                             @endif
                         </div>
                         @endif

                     </div>
                 </div>
                 @endforeach
                 @endif



             </div>


         </div>
     </div>
 </div>
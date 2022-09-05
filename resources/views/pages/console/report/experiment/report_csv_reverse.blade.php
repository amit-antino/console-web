<table>
    <thead>
        <tr>
            <th style="font-weight: bold;">Experiment name</th>
            <th>{{ $expirementname }}</th>

        </tr>
        <tr>
            <th style="font-weight: bold;">Variation name</th>
            <th>{{ $varname->name }}</th>

        </tr>
        <tr>
            <th style="font-weight: bold;">simulation set name</th>
            <th>{{ $simname->name }}</th>

        </tr>
        <tr>
            <th></th>
       </tr>
       
    </thead>
    
</table>

@if(!empty($desired_outcome))
<table id="desierd_master_outcomes" class="table">
   
    <thead>
        <tr>
            <th></th>
        </tr>
        <tr>
            <th style="font-weight: bold;">Master outcome</th>
        </tr>
        <tr>
        <th class="text-center">Outcome Name</th>
        <th class="text-center">Criteria </th>
        <th class="text-center">Value </th>
        </tr>
    </thead>
    <tbody class="font-weight-normal">
        @if(!empty($desired_outcome))
        @foreach($desired_outcome as $master_outcomes)
        <tr>
            <td class="text-center">{{$master_outcomes['outcome_name']}}</td>
            <td class="text-center">{{$master_outcomes['criteria']}}</td>
            <td class="text-center">
                {{$master_outcomes['value']}}
                {{(!empty($master_outcomes['unit_constant_name']))?$master_outcomes['unit_constant_name']['unit_constant']['unit_name']:'-'}}
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
@endif
@if (!empty($raw_materials))
<table>
  
   <tbody>
       <tr>
           <td>RAW MATERIALS
           </td>
       </tr>
       @if (!empty($raw_materials))
           @foreach ($raw_materials as $ack => $acv)
               <tr>
                   <td style="text-align: center;">STREAM NAME
                     
                   </td>
                   <td style="text-align: center;">
                    {{ $acv['stream'] }}
                   </td>
                   
               </tr>
               <tr>
                <td style="text-align: center;">VALUE AND FLOW RATE
                  
                </td>
                <td style="text-align: center;">
                 {{ $acv['flow_rate_value'] }}{{ $acv['unit_constant_name'] }}
                </td>
                
            </tr>
            <tr>
                <td  style="text-align: center;">Product
                </td >
                <td  style="text-align: center;">Criteria
                </td>
                <td  style="text-align: center;">Percentage
                </td>
            </tr>
            @foreach($acv['detail'] as $k=>$v)
            <tr>
                <td  style="text-align: center;">{{$v['product_name']}}
                </td>
                <td  style="text-align: center;">{{$v['criteria']}}
                </td>
                <td  style="text-align: center;">{{$v['value']}}
                </td>
            </tr>
            @endforeach
           @endforeach
       @endif
   </tbody>

</table>
@endif
<table id="" class="table font-weight-normal ">
    <tr>
        <td>PREDICTED RAW MATERIALS
        </td>
    </tr>
    <tr>
        <td style="text-align: center;">Product</td>
        @if(!empty($predicted_result_headers))
        @foreach($predicted_result_headers as $kpk=>$pkv)
        <td style="text-align: center;">{{$pkv}}</td>
        @endforeach
        @endif
      
    </tr>
    <tbody>
        @if(!empty($predicted_result_list))
        @foreach($predicted_result_list as $dk=> $dv)
        <tr>
            <td style="text-align: center;">{{getsingleChemicalName($dv['product_id'])}}</td>
             @foreach($predicted_result_headers as $pvv)
            <td style="text-align: center;">{{$dv[$pvv]}} </td>
            @endforeach
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
<table id="accuracy_outcome" class="table font-weight-normal">
    
    <tr>
        <td>ACCURACY OF MASTER OUTCOMES</td>
    </tr>
    <tr>
        <td>Outcome Name</td>
        <td>Criteria</td>
        <td>Desired value</td>
        @foreach($master_accuracy_header as $k=>$v)
        <td class="text-center">{{$v}}</td>
        @endforeach
    </tr>
    <tbody>
        @if(!empty($master_accuracy_list))
        @foreach($master_accuracy_list as $mkey=>$mv)
        <tr>
            <td>
                {{getOutcomeName($mv['outcome_name'])}}
            </td>
            <td>
                {{get_criteria_data($mv['criteria'])}}
            </td>
            <td>
                {{$mv['Desired value']}}
            </td>
            @foreach($master_accuracy_header as $kk=>$vV)
            <td>{{$mv[$vV]}}</td>
            @endforeach
           
          
        </tr>
        @endforeach
        @endif
    </tbody>
</table>

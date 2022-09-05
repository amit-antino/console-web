<!DOCTYPE html>
<html>

<head>
  <style>
    table,
    th,
    td {
      border: 1px solid black;
      text-align: center;
    }
  </style>
</head>

<body>
  <table>
    <tr>
      <th></th>
      <th colspan={{$data['rm_cnt']}}>Raw Material</th>
      @if(!empty($data['master_condition']))
      <th colspan={{count($data['master_condition'])}}>Master Condition</th>
      @endif
      @if(!empty($data['exp_unit_condition']))
      <th colspan={{$data['ec_cnt']}}>Experiment Unit Condition</th>
      @endif
      @if(!empty($data['master_outcome']))
      <th colspan={{count($data['master_outcome'])}}>Master Outcome</th>
      @endif
      @if(!empty($data['exp_unit_outcome']))
      <th colspan={{$data['eo_cnt']}}>Experiment Unit Outcome</th>
      @endif
    </tr>
    <tr>
      <th></th>
      @foreach($data['raw_material'] as $raw_material)
      @if(!empty($raw_material['products']))
      <th colspan={{count($raw_material['products'])+1}}>{{$raw_material['stream_name']}} <br>
        #{{$raw_material['stream_id']}}#{{$raw_material['unit_id']}}</th>
      @else
      <th colspan={{count($raw_material['products'])+1}}>{{$raw_material['stream_name']}} <br>
        #{{$raw_material['stream_id']}}#{{$raw_material['unit_id']}}</th>
      @endif
      @endforeach
      @foreach($data['master_condition'] as $master_condition)
      <th></th>
      @endforeach

      @foreach($data['exp_unit_condition'] as $key=>$exp_unit)
      <th colspan={{$exp_unit['cnt']}}>{{$exp_unit['exp_unit']}} #{{$key}} <br>
        @endforeach
        @foreach($data['master_outcome'] as $master_outcome)
      <th></th>
      @endforeach
      @foreach($data['exp_unit_outcome'] as $key=>$exp_unit)
      <th colspan={{$exp_unit['cnt']}}>{{$exp_unit['exp_unit']}} #{{$key}} <br>
        @endforeach
    </tr>
    <tr>
      <th>Simulation Input Name#{{$data['template_id']}}#{{$data['type']}}</th>
      @foreach($data['raw_material'] as $raw_material)
      <th>Flow Rate ({{$raw_material['unit_constant_name']}}) #{{$raw_material['unit_constant_id']}}</th>
      @foreach($raw_material['products'] as $products)
      @if(!empty($products['product_name']))
      <th>{{$products['product_name']}} in % #{{$products['product_id']}}</th>
      @endif
      @endforeach
      @endforeach
      @if(!empty($data['master_condition']))
      @foreach($data['master_condition'] as $master_condition)
      <th>{{$master_condition['condition']}} in {{$master_condition['unit_constant']}}<br>
        #{{$master_condition['conditionid']}}#{{$master_condition['unitid']}}#{{$master_condition['unit_constant_id']}}#{{___encrypt($master_condition['criteria_id'])}}
      </th>
      @endforeach
      @endif
      @if(!empty($data['exp_unit_condition']))
      @foreach($data['exp_unit_condition'] as $key=>$exp_unit)
      @foreach($exp_unit['conditions'] as $condition)
      <th>{{$condition['condition']}} in {{$condition['unit_constant']}}<br>
        #{{$condition['conditionid']}}#{{$condition['unitid']}}#{{$condition['unit_constant_id']}}#{{___encrypt($condition['criteria_id'])}}
      </th>
      @endforeach
      @endforeach
      @endif
      @if(!empty($data['master_outcome']))
      @foreach($data['master_outcome'] as $master_outcome)

      <th>{{$master_outcome['outcome']}} in {{$master_outcome['unit_constant']}}<br>
        #{{$master_outcome['outcomeid']}}#{{$master_outcome['unitid']}}#{{$master_outcome['unit_constant_id']}}#{{___encrypt($master_outcome['criteria_id'])}}
      </th>
      @endforeach
      @endif
      @if(!empty($data['exp_unit_outcome']))
      @foreach($data['exp_unit_outcome'] as $key=>$exp_unit)
      @foreach($exp_unit['outcomes'] as $outcome)
      <th>{{$outcome['outcome']}} in {{$outcome['unit_constant']}}<br>
        #{{$outcome['outcomeid']}}#{{$outcome['unitid']}}#{{$outcome['unit_constant_id']}}#{{___encrypt($outcome['criteria_id'])}}
      </th>
      @endforeach
      @endforeach
      @endif
    </tr>
    @if(isset($products['value']))
    <tr>
      <th>{{explode('(',$data['simulate_input_name'])[0]}}</th>
      @foreach($data['raw_material'] as $raw_material)
      <th>{{$raw_material['flow_rate_value']}}</th>
      @foreach($raw_material['products'] as $products)
      @if(!empty($products['product_name']))
      <th>{{$products['value']}}
        @if($products['criteria_id']!="")
          {{getCriteriaValue($products['criteria_id'],$products['max'])}}
        @endif
      </th>
      @endif
      @endforeach
      @endforeach
      @if(!empty($data['master_condition']))
      @foreach($data['master_condition'] as $master_condition)
      <th>{{$master_condition['value']}}
        @if($master_condition['criteria_id']!="")
          {{getCriteriaValue($master_condition['criteria_id'],$master_condition['max'])}}
        @endif
      </th>
      @endforeach
      @endif
      @if(!empty($data['exp_unit_condition']))
      @foreach($data['exp_unit_condition'] as $key=>$exp_unit)
      @foreach($exp_unit['conditions'] as $condition)
      <th>{{$condition['value']}}
        @if($condition['criteria_id']!="")
          {{getCriteriaValue(is_numeric($condition['criteria_id'])?$condition['criteria_id']:___decrypt($condition['criteria_id']),$condition['max'])}}
        @endif
      </th>
      @endforeach
      @endforeach
      @endif
      @if(!empty($data['master_outcome']))
      @foreach($data['master_outcome'] as $master_outcome)
      <th>{{$master_outcome['value']}}
        @if($master_outcome['criteria_id']!="")
          {{getCriteriaValue($master_outcome['criteria_id'],$master_outcome['max'])}}
        @endif
      </th>
      @endforeach
      @endif
      @if(!empty($data['exp_unit_outcome']))
      @foreach($data['exp_unit_outcome'] as $key=>$exp_unit)
      @foreach($exp_unit['outcomes'] as $outcome)
      <th>{{$outcome['value']}}
        @if($outcome['criteria_id']!="")
          {{getCriteriaValue(is_numeric($outcome['criteria_id'])?$outcome['criteria_id']:___decrypt($outcome['criteria_id']),$outcome['max'])}}
        @endif
      </th>
      @endforeach
      @endforeach
      @endif
    </tr>
    @endif
  </table>
</body>

</html>

<input type='hidden' id='e_nos' name='e_nos' value=" {{(sizeof($variable_r) + 1)}}">
<input type='hidden' id='e_nos' name='e_nos' value="{{(sizeof($variable_p) + 1)}}">
<div class='col-md-4 mb-3'>
    <div class='card'>
        <div class='card-header'>
            <h5 class='mb-3 mb-md-0'>Reactants</h5>
        </div>
        <div class='card-body'>
            <div class="table">
                <table class='table table-bordered'>
                    <thead>
                        <th class='mol_sep_tb_header'><b>Elements</b></th>
                        <th class='mol_sep_tb_header'><b>Values</b></th>
                    </thead>
                    <tbody>
                        @php
                        $total_count_r = 0;
                        foreach ($cumulitive_values as $key => $value) {
                        @endphp
                        <tr id="m_box{{$j}}">
                            <td>{{$key}}</td>
                            <td>{{$value}}</td>
                        </tr>
                        @php
                        $total_count_r = $total_count_r + $value;
                        }
                        @endphp
                        <tr>
                            <td>Total count</td>
                            <td>{{$total_count_r}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class='col-md-4'>
    <div class='card'>
        <div class='card-header'>
            <h5 class='mb-3 mb-md-0'>Products</h5>
        </div>
        <div class='card-body'>
            <div class="table">
                <table class='table table-bordered'>
                    <thead>
                        <th class='mol_sep_tb_header'><b>Elements</b></th>
                        <th class='mol_sep_tb_header'><b>Values</b></th>
                    </thead>
                    <tbody>
                        @php
                        $total_count_p = 0;
                        foreach ($cumulitive_values_p as $key => $value) {
                        @endphp
                        <tr id="m_box{{$j}}">
                            <td>{{$key}}</td>
                            <td>{{$value}}</td>
                        </tr>
                        @php
                        $total_count_p = $total_count_p + $value;
                        }
                        @endphp
                        <tr>
                            <td>Total count</td>
                            <td>{{$total_count_p}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@php
$resultArray = $cumulitive_values_p;
foreach ($cumulitive_values as $key => $value) {
if (isset($resultArray[$key])) {
$resultArray[$key] -= $value;
} else {
$resultArray[$key] = $value;
}
}
@endphp
<div class='col-md-4'>
    <div class='card'>
        <div class='card-header'>
            <h5 class='mb-3 mb-md-0'>Balance</h5>
        </div>
        <div class='card-body'>
            <div class="table">
                <table class='table table-bordered' style='width:100%;'>
                    <thead>
                        <th class='mol_sep_tb_header'><b>Elements</b></th>
                        <th class='mol_sep_tb_header'><b>Values</b></th>
                    </thead>
                    <tbody>
                        @php
                        if ($resultArray != false) {
                        $total_count = 0;
                        $is_balance = true;
                        foreach ($resultArray as $key => $value) {
                        @endphp
                        <tr id="m_box{{$j}}">
                            <td>{{$key}}</td>
                            <td>{{$value}}</td>
                        </tr>
                        @php
                        if ($value != 0 && $is_balance == true) {
                        $is_balance = false;
                        }
                        $total_count = $total_count + $value;
                        }
                        @endphp
                        <tr>
                            <td>Total count</td>
                            <td>{{$total_count}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@php
if ($is_balance == true) {
@endphp
<script type="text/javascript">
    $("#blnc").val('Balanced');
    document.getElementById("stoichemi").innerHTML = "Balanced"
</script>
@php
} else {
@endphp
<script type="text/javascript">
    $("#blnc").val('Not Balanced');
    document.getElementById("stoichemi").innerHTML = "Not Balanced"
</script>
@php
}
}
@endphp

<script type="text/javascript">
    //Add New Field
    $("#add_molecule").click(function() {
        //Get Count
        var counter = $("#e_nos").val();
        counter = parseInt(counter);
        //Increment Counter
        document.getElementById('e_nos').value = parseInt(counter + 1);
        //Append new Input Field
        $("#broken_molecular_formula").append("<table id='m_box" + counter +
            "'><tr><td><input type='text' class='form-control' name='element_" + counter +
            "' value=''/></td><td><input type='text' class='form-control' name='no_atoms_" +
            counter + "' value=''/></td><td></tr></table>");
        return false;
    }); //end Add
</script>
<table style="width:100%">
    <tr>
        <th>Element</th>
        <th>No Of Items</th>
    </tr>
    @if(!empty($elements))
    @for ($i = 0; $i < sizeof($elements); $i++) 
        <tr>
        <td style="color:black">{{$elements[$i]}}<input type="hidden" readonly name="element_[]" value="{{$elements[$i]}}"></td>
        <td style="color:black">{{$numbers[$i]}}<input type="hidden" readonly name="no_atoms_[][]" value="{{$numbers[$i]}}"></td>
        </tr>
        @endfor
        @endif
</table>
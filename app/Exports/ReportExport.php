<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class ReportExport implements FromView, WithColumnWidths
{
    protected $id;

    function __construct($id)
    {
        $this->id = $id;
    }

    public function view(): View
    {
        $experiment_report = ExperimentReport::find($this->id);
        $generated_output = json_decode($experiment_report->output_data, true);
        $experiment_info = ProcessExperiment::find($experiment_report->experiment_id);
        $expirementname = $experiment_info->process_experiment_name;
        $varname = get_variation($experiment_report->variation_id);
        $simname = get_simulation($experiment_report->simulation_input_id);
        return view(
            'pages.console.report.experiment.repor_csv',
            compact('expirementname', 'varname', 'simname')
        );
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 25,
            'C' => 25,
            'D' => 25,
            'E' => 25,
            'F' => 25,
            'G' => 25,
            'H' => 25,
            'I' => 25,
            'J' => 25,
            'K' => 25,
            'L' => 25,
            'M' => 25,
            'N' => 25,
            'O' => 25,
            'P' => 25,
            'Q' => 25,
            'R' => 25,
            'S' => 25,
            'T' => 25,
            'U' => 25,
            'V' => 25,
            'W' => 25,
            'X' => 25,
            'Y' => 25,
            'Z' => 25
        ];
    }
}

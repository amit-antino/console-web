<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Experiment\SimulateInputExcelTemplate;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SimTemplate implements FromView, ShouldAutoSize
{
    public function  __construct($data)
    {
        $this->data = $data;
    }
    
    public function view(): View
    {
        if ($this->data['type'] == 'reverse') {
            return view('pages.console.experiment.experiment.configuration.simulate_input_excel_template.reverse_template')->with('data', $this->data);
        }
        return view('pages.console.experiment.experiment.configuration.simulate_input_excel_template.template')->with('data', $this->data);
    }
}

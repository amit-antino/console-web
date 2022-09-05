<?php

namespace App\Http\Controllers\Console\KnowledgeBank\Experiment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProcessExperiment\ProcessExperiment;
use Illuminate\Support\Facades\Auth;
use App\Models\Master\ProcessSimulation\SimulationType;

class ExperimentController extends Controller
{
    public function index()
    {
        try {
            if (Auth::user()->role == 'console') {
                $process_experiments = ProcessExperiment::where('knowledge_bank', 1)->where('tenant_id', session()->get('tenant_id'))->with('experiment_category', 'get_project')->get();
            } else {
                $process_experiments = ProcessExperiment::where('tenant_id', session()->get('tenant_id'))->with('experiment_category', 'get_project')->get();
            }
            $process_exp_list = [];
            $classifications = [];
            foreach ($process_experiments as $process_experiment) {
                $varcount = Variation::where('experiment_id', $process_experiment->id)->get();
                $simInputcount = SimulateInput::where('experiment_id', $process_experiment->id)->get();
                if (Auth::user()->role != 'admin') {
                    // echo Auth::user()->role ;exit;
                    $pro = Project::where('id', $process_experiment->project_id)->first();
                    $users = !empty($pro->users) ? $pro->users : [];
                    if (in_array(Auth::user()->id, $users)) {
                        if (!empty($process_experiment->classification_id)) {
                            $classifications = experiment_classification($process_experiment->classification_id);
                        }
                        $process_exp_list[] = [
                            "id" => $process_experiment->id,
                            "name" => $process_experiment->process_experiment_name,
                            "category" => (!empty($process_experiment->category_id)) ? $process_experiment->experiment_category->name : '',
                            "classification" => $classifications,
                            "data_source" => $process_experiment->data_source,
                            "status" => $process_experiment->status,
                            "created_by" => get_user_name($process_experiment->created_by),
                            "project" => (!empty($process_experiment->project_id)) ? $process_experiment->get_project->name : '',
                            "variation_count" => count($varcount->toArray()),
                            "simInputcount" => count($simInputcount->toArray())
                        ];
                    }
                } else {
                    if (!empty($process_experiment->classification_id)) {
                        $classifications = experiment_classification($process_experiment->classification_id);
                    }
                    $process_exp_list[] = [
                        "id" => $process_experiment->id,
                        "name" => !empty($process_experiment->process_experiment_name) ? $process_experiment->process_experiment_name : '',
                        "category" => (!empty($process_experiment->experiment_category->name)) ? $process_experiment->experiment_category->name : '',
                        "classification" => $classifications,
                        "data_source" => $process_experiment->data_source,
                        "status" => $process_experiment->status,
                        "created_by" => get_user_name($process_experiment->created_by),
                        "project" => (!empty($process_experiment->project_id)) ? $process_experiment->get_project->name : '',
                        "variation_count" => count($varcount->toArray()),
                        "simInputcount" => count($simInputcount->toArray())
                    ];
                }
            }
        } catch (\Exception $e) {
            return view('pages.error.cusome_error')->with('listerror', $e->getMessage())->with('line_number', $e->getLine())->with('filename', $e->getFile());
        } catch (ModelNotFoundException $exception) {
            return view('pages.error.cusome_error')->with('listerror', $exception->getMessage())->with('line_number', $exception->getLine())->with('filename', $exception->getFile());;
        } catch (RelationNotFoundException $r) {
            return view('pages.error.cusome_error')->with('listerror', $r->getMessage())->with('line_number', $r->getLine())->with('filename', $r->getFile());;
        }
        return view('pages.console.knowledge_bank.experiment.index')->with(compact('data'));;
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
        try {
            $simulationData = ProcessSimulation::find(___decrypt($id));
            $simulationData->updated_at = now();
            $simulationData->updated_by = Auth::user()->id;
            $simulationData->knowledge_bank = 0;
            $simulationData->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('/knowledge_bank/process_simulation');
            $this->message = "Knowledge Bank Delete Successfully!";
        } catch (\Exception $e) {
            $this->status = false;
            $this->message = $e->getMessage();
        }
        return $this->populateresponse();
    }
    public function bulkDelete(Request $request)
    {
        $this->redirect = url('/knowledge_bank/process_simulation');
        return $this->populateresponse();
    }
}

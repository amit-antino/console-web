<?php

namespace App\Http\Controllers\Admin\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class DocumentUpdateController extends Controller
{
    public function show($id)
    {
        $data['tenant'] = Tenant::where('id', ___decrypt($id))->first();
        $documents = $data['tenant']->guide_document;
        $data['quick_start_doc'] = !empty($documents['quick_start_doc']) ? $documents['quick_start_doc'] : '';
        $data['experiment_doc'] = !empty($documents['experiment_doc']) ? $documents['experiment_doc'] : '';
        $data['report_doc'] = !empty($documents['report_doc']) ? $documents['report_doc'] : '';
        $data['benchmark_doc'] = !empty($documents['benchmark_doc']) ? $documents['benchmark_doc'] : '';
        return view('pages.admin.tenant.document_update.edit', $data);
    }

    public function edit($id)
    {
        $data['tenant'] = Tenant::where('id', ___decrypt($id))->first();
        return view('pages.admin.tenant.document_update.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quick_start_doc' => 'nullable|mimes:pdf',
            'experiment_doc' => 'nullable|mimes:pdf',
            'report_doc' => 'nullable|mimes:pdf',
            'benchmark_doc' => 'nullable|mimes:pdf',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $id = ___decrypt($id);
            $tenant = Tenant::find($id);
            $quick_start_doc = '';
            $doc = $tenant->guide_document;
            if (!empty($request->quick_start_doc)) {
                $quick_start_doc = upload_file($request, 'quick_start_doc', 'quick_start_doc');
                $images['quick_start_doc'] = $quick_start_doc;
            } else
                $images['quick_start_doc'] = isset($doc['quick_start_doc']) ? $doc['quick_start_doc'] : '';
            $experiment_doc = '';
            if (!empty($request->experiment_doc)) {
                $experiment_doc = upload_file($request, 'experiment_doc', 'experiment_doc');
                $images['experiment_doc'] = $experiment_doc;
            } else
                $images['experiment_doc'] = isset($doc['experiment_doc']) ? $doc['experiment_doc'] : '';
            if (!empty($request->report_doc)) {
                $report_doc = upload_file($request, 'report_doc', 'report_doc');
                $images['report_doc'] = $report_doc;
            } else
                $images['report_doc'] = isset($doc['report_doc']) ? $doc['report_doc'] : '';

            if (!empty($request->benchmark_doc)) {
                $benchmark_doc = upload_file($request, 'benchmark_doc', 'benchmark_doc');
                $images['benchmark_doc'] = $benchmark_doc;
            } else
                $images['benchmark_doc'] = isset($doc['benchmark_doc']) ? $doc['benchmark_doc'] : '';

            $tenant->guide_document = $images;
            $tenant->updated_by = Auth::user()->id;
            $tenant->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = true;
            $this->message = "Updated Successfully!";
        }
        return $this->populateresponse();
    }
}

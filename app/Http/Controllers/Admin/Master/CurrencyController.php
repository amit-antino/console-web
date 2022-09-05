<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Currency;
use Illuminate\Http\Request;
use App\Imports\CurrencyImport;
use Illuminate\Support\Facades\Validator;

class CurrencyController extends Controller
{
    public function index(Request $request)
    {
        $data['currecny'] = Currency::orderBy('id', 'desc')->get();
        return view('pages.admin.master.currency.index', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'currency_file' => 'required',
            ]
        );
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            \Excel::import(new CurrencyImport, request()->file('currency_file'));
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/master/currency');
            $this->message = "Added Successfully!";
        }
        return $this->populateresponse();
    }
}

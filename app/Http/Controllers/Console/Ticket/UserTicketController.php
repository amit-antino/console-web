<?php

namespace App\Http\Controllers\Console\Ticket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserTicket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade as PDF;

class UserTicketController extends Controller
{
    public function index()
    {
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $validations = [
            'title' => ['required'],
        ];
        $validator = Validator::make($request->all(), $validations, []);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $data = new UserTicket();
            $data['title'] = $request->title;
            $data['priority'] = $request->priorty;
            $data['type'] = $request->type;
            $data['description'] = $request->description;
            $data['status'] = 'pending';
            $data['created_by'] = Auth::user()->id;
            $data['updated_by'] = Auth::user()->id;
            $data->save();
            $url = url('admin/ticket/' . ___encrypt($data->id));
            Mail::send('email_templates.ticket', [
                'url' => $url
            ], function ($message) use ($request) {
                $message->to(['abhijit.jagtap@simreka.com', 'anupama.a@simreka.com'])->subject('Issue Reported');
            });
            $this->status = true;
            $this->alert = true;
            $this->modal = true;
            $this->redirect = true;
            $this->message = "Ticket Submit Successfully!";
        }
        return $this->populateresponse();
    }

    public function download()
    {
        $file_path = storage_path() . "/json/Documentation.pdf"; //public_path('files/' . $file_name);
        return response()->download($file_path);
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
    }
}

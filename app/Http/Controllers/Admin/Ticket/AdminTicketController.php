<?php

namespace App\Http\Controllers\Admin\Ticket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserTicket;
use Illuminate\Support\Facades\Auth;

class AdminTicketController extends Controller
{
    public function getView($id)
    {
        $data = UserTicket::find(___decrypt($id));
        return view('pages.admin.ticket.view', compact('data'));
    }

    public function index()
    {
        $data = UserTicket::get();
        return view('pages.admin.ticket.index', compact('data'));
    }

    public function destroy($id)
    {
        $data = UserTicket::destroy(___decrypt($id));
        $this->status = true;
        $this->modal = true;
        $this->redirect = true;
        return $this->populateresponse();
    }
}

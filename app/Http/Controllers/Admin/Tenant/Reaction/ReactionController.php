<?php

namespace App\Http\Controllers\Admin\Tenant\Reaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReactionController extends Controller
{
    public function reaction_manage($id)
    {
        return view('pages.admin.master.reaction.reaction_type.index');
    }
}

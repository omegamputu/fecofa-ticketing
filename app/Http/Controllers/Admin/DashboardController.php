<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public string $search='', $status='all', $priority='all';

    public function index()
    {
        $tickets = Ticket::latest()->paginate(10);

        return view('admin.dashboard', compact('tickets'))->title('Dashboard');
    }
}


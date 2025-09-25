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
        // Statistiques globales
        $base = Ticket::with(['requester', 'assignee'])
        ->whereHas('requester', fn($q) => $q->role('Demandeur'));

        $stats = [
            'tickets_total' => (clone $base)->count(),
            'tickets_open' => (clone $base)->whereIn('status', ['open', 'in_progress'])->count(),
            'tickets_non_assignés' => (clone $base)->whereNull('assigned_to')->count(),
        ];

        // Derniers tickets
        $lastTickets = (clone $base)->latest()->limit(10)->get();

        return view('admin.dashboard', compact('stats', 'lastTickets'))->title('Dashboard');
    }
}


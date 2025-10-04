<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SupportManagementController extends Controller
{
    public function index(): View
    {
        $tickets = Ticket::with('user')->latest()->paginate(20);

        return view('admin.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket): View
    {
        $ticket->load('replies.user');

        return view('admin.tickets.show', compact('ticket'));
    }

    public function update(Ticket $ticket): RedirectResponse
    {
        $data = request()->validate([
            'status' => ['required', 'in:open,pending,closed'],
            'reply' => ['nullable', 'string'],
        ]);

        $ticket->update(['status' => $data['status']]);

        if (! empty($data['reply'])) {
            TicketReply::create([
                'ticket_id' => $ticket->id,
                'user_id' => request()->user()->id,
                'message' => $data['reply'],
            ]);
        }

        return back()->with('status', 'Ticket updated');
    }
}

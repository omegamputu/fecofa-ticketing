<?php

namespace App\Livewire;

use Illuminate\Notifications\DatabaseNotification;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class NotificationsPanel extends Component
{

    public $notifications;
    public $unreadCount;

    public function mount()
    {
        $user = auth()->user();

        if (!$user) {
            abort(403);
        }

        // On ne ramène que les 20 plus récentes, pas toute l'historique
        $rows = $user->notifications()
            ->latest()
            ->limit(20)
            ->get([
                'id',
                'type',
                'data',
                'read_at',
                'created_at',
            ]);
        
        // On transforme en structure simple pour éviter une surcharge Livewire
        $this->notifications = $rows->map(function (DatabaseNotification $n) {
            return [
                'id'         => $n->id,
                'is_unread'  => is_null($n->read_at),
                'created_at' => $n->created_at?->diffForHumans(),
                'data'       => [
                    'message'      => $n->data['message']      ?? 'Notification',
                    'ticket_id'    => $n->data['ticket_id']    ?? null,
                    'subject'      => $n->data['subject']      ?? null,
                    'status'       => $n->data['status']       ?? null,
                    'assigned_by'  => $n->data['assigned_by']  ?? null,
                    'created_by'   => $n->data['created_by']   ?? null,
                    'resolved_by'  => $n->data['resolved_by']  ?? null,
                ],
            ];
        });

        $this->unreadCount = $rows->whereNull('read_at')->count();
    }

    public function markAsRead(string $notificationId)
    {
        $user = auth()->user();

        $notif = $user->notifications()->whereKey($notificationId)->first();

        if ($notif && is_null($notif->read_at)) {
            $notif->markAsRead();
        }

        // Refresh notifications and unread count
        $this->reloadData();
    }

    public function markAllAsRead()
    {
        $user = auth()->user();

        $user->unreadNotifications->markAsRead();

        // Refresh notifications and unread count
        $this->reloadData();
    }

    public function reloadData()
    {
        $user = auth()->user();

        $rows = $user->notifications()
            ->latest()
            ->limit(20)
            ->get([
                'id',
                'type',
                'data',
                'read_at',
                'created_at',
            ]);

        $this->notifications = $rows->map(function (DatabaseNotification $n) {
            return [
                'id'         => $n->id,
                'is_unread'  => is_null($n->read_at),
                'created_at' => $n->created_at?->diffForHumans(),
                'data'       => [
                    'message'      => $n->data['message']      ?? 'Notification',
                    'ticket_id'    => $n->data['ticket_id']    ?? null,
                    'subject'      => $n->data['subject']      ?? null,
                    'status'       => $n->data['status']       ?? null,
                    'assigned_by'  => $n->data['assigned_by']  ?? null,
                    'created_by'   => $n->data['created_by']   ?? null,
                    'resolved_by'  => $n->data['resolved_by']  ?? null,
                ],
            ];
        });

        $this->unreadCount = $rows->whereNull('read_at')->count();
    }

    public function render()
    {
        return view('livewire.notifications-panel')->title('Notifications')->layout('components.layouts.app');
    }
}

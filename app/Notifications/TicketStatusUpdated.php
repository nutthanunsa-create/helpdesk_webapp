<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    public $ticket;

    /**
     * Create a new notification instance.
     */
    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // Simulate Line Notify by logging
        \Log::info("LINE NOTIFY: อัปเดตสถานะใบงาน (Ticket ID: {$this->ticket->ticket_no}) เป็น: {$this->ticket->status}");

        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('ITDeskService - อัปเดตสถานะใบงาน: '.$this->ticket->ticket_no)
            ->greeting('สวัสดี '.$notifiable->name.',')
            ->line('ใบงาน '.$this->ticket->ticket_no.' ของคุณมีการอัปเดตสถานะเป็น: '.strtoupper($this->ticket->status))
            ->action('ตรวจสอบรายละเอียด', route('tickets.show', $this->ticket->id))
            ->line('ขอบคุณที่ใช้บริการ ITDeskService');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'ticket_id' => $this->ticket->id,
            'ticket_no' => $this->ticket->ticket_no,
            'title' => 'สถานะอัปเดตเป็น '.strtoupper($this->ticket->status),
            'type' => 'updated',
        ];
    }
}

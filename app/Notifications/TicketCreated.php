<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketCreated extends Notification implements ShouldQueue
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
        \Log::info("LINE NOTIFY: มีการแจ้งซ่อมใหม่ (Ticket ID: {$this->ticket->ticket_no}) หัวข้อ: {$this->ticket->title}");

        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('ITDeskService - ได้รับแจ้งปัญหาใหม่: '.$this->ticket->ticket_no)
            ->greeting('สวัสดี '.$notifiable->name.',')
            ->line('ระบบได้รับแจ้งปัญหาของคุณเรียบร้อยแล้ว')
            ->line('รหัสใบงาน: '.$this->ticket->ticket_no)
            ->line('หัวข้อ: '.$this->ticket->title)
            ->action('ดูรายละเอียดใบงาน', route('tickets.show', $this->ticket->id))
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
            'title' => 'เปิดใบงานใหม่: '.$this->ticket->title,
            'type' => 'created',
        ];
    }
}

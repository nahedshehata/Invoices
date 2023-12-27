<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AddInvoices extends Notification
{
    use Queueable;

    private $invoice_id;

    public function __construct($invoice_id)
    {
        $this->invoice_id = $invoice_id;

    }
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = 'http://127.0.0.1:8000/invoices/'.$this->invoice_id;
        return (new MailMessage)->subject('اضافة فاتورة جديدة')
        ->greeting('مرحبا !')
        ->line('تم اضافة فاتورة جديدة بنجاح !')
        ->action('عرض الفاتوره', url($url))
        ->line('شكرا لاستخدامك برنامج ادارة الفواتير');
    }
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

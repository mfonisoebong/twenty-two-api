<?php

namespace App\Notifications\Invoice;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoiceAction extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Invoice $invoice)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $subject = "";
        $appName = config('app.name');
        if ($this->invoice->status === 'pending') {
            $subject = "Your $appName Cart Awaits!";
        }

        if ($this->invoice->status === 'paid') {
            $subject = "Your $appName Order Confirmation (# {$this->invoice->id})";
        }

        if ($this->invoice->status === 'in_transit') {
            $subject = "Your $appName Order (# {$this->invoice->id})  is on its way!";
        }

        if ($this->invoice->status === 'delivered') {
            $subject = "Your $appName Order (# {$this->invoice->id}) has been delivered!";
        }

        if ($this->invoice->status === 'cancelled') {
            $subject = "Your $appName Order (# {$this->invoice->id}) has been cancelled";
        }


        return (new MailMessage)
            ->subject($subject)
            ->view("emails.invoice.{$this->invoice->status}", [
                'invoice' => $this->invoice
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

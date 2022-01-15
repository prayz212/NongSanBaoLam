<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentInvoiceNotification extends Notification implements ShouldQueue
{
    use Queueable;
    protected $carts, $bill, $voucher;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($carts, $bill, $voucher)
    {
        $this->carts = $carts;
        $this->bill = $bill;
        $this->voucher = $voucher;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('[Nông sản Bảo Lâm] Hóa đơn')
            ->view('mail.payment-invoice-template', ['carts' => $this->carts, 'bill' => $this->bill, 'voucher' => $this->voucher]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

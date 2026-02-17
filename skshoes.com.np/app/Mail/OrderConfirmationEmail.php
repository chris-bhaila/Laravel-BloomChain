<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $orderData; // Public property to hold order data

    /**
     * Create a new message instance.
     *
     * @param array $orderData The data of the order to be sent in the email.
     * @return void
     */
    public function __construct(array $orderData)
    {
        $this->orderData = $orderData;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Confirmation', // Subject of the email
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order_confirmation', // The view for the email body.  Create this in resources/views/emails
            with: [
                'order' => $this->orderData, // Pass the order data to the view as 'order'
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments(): array
    {
        return [];
    }
}

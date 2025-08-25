<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $order;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $order)
    {
        $this->user = $user;
        $this->order = $order;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Invoice - ' . $this->order->tnx_id,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'vendor.invoices.templates.invoice-template', // create resources/views/vendor/invoices/templates/invoice-temple.blade.php
            with: [
                'user'  => $this->user,
                'order' => $this->order,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    // public function attachments(): array
    // {
    //     return [
    //         Attachment::fromPath(storage_path('app/public/'.$this->pdfPath))
    //             ->as('invoice_'.$this->order->tnx_id.'.pdf')
    //             ->withMime('application/pdf'),
    //     ];
    // }
}

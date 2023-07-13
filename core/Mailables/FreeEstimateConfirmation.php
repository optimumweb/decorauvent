<?php

namespace Theme\Mailables;

use Illuminate\Bus\Queueable;
use Illuminate\Http\UploadedFile;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FreeEstimateConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public array $fields = [],
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: site()->trans('mail.freeEstimateConfirmation.subject'),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.free-estimate-confirmation.markdown',
            with: [
                'fields' => $this->fields,
            ],
        );
    }
}

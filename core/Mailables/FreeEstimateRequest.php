<?php

namespace Theme\Mailables;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FreeEstimateRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $replyTo = [];

    public function __construct(
        public array $fields = [],
    ) {
        foreach ($fields as $field) {
            if (isset($field['value']) && filter_var($field['value'], FILTER_VALIDATE_EMAIL)) {
                $this->replyTo[] = new Address($field['value']);
                break;
            }
        }
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            replyTo: $this->replyTo,
            subject: "Demande d'estimé sans frais",
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.free-estimate.markdown',
            with: [
                'fields' => $this->fields,
            ],
        );
    }

    public function attachments(): array
    {
        $attachments = [];

        if (isset($this->fields['files'])) {
            foreach ($this->fields['files'] as $file) {
                if ($file->isValid()) {
                    $attachments[] = Attachment::fromPath($file->getRealPath())
                        ->as($file->getClientOriginalName());
                }
            }
        }

        return $attachments;
    }
}

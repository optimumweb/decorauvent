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

class FreeEstimateRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $identifier;
    public $replyTo = [];

    public function __construct(
        public array $fields = [],
    ) {
        foreach ($fields as $field) {
            if (isset($field['value'])) {
                $this->identifier ??= $field['value'];

                if (filter_var($field['value'], FILTER_VALIDATE_EMAIL)) {
                    $this->replyTo[] = new Address($field['value']);
                }
            }
        }
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            replyTo: $this->replyTo,
            subject: site()->trans('mail.freeEstimateRequest.subject', ['identifier' => $this->identifier]),
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
                try {
                    if ($file instanceof UploadedFile) {
                        if ($file->isValid()) {
                            $attachments[] = Attachment::fromPath($file->getRealPath())
                                ->as($file->getClientOriginalName());
                        }
                    } elseif (is_array($file) && isset($file['name'], $file['content'])) {
                        if ($filepath = mkfile($file['content'])) {
                            $attachments[] = Attachment::fromPath($filepath)
                                ->as($file['name']);
                        }
                    }
                } catch (\Exception $e) {
                    \Sentry\captureException($e);
                }
            }
        }

        return $attachments;
    }
}

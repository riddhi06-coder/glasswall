<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BrandedFormMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  array{value?:string,label?:string}|null  $highlight
     * @param  array<string,mixed>  $rows
     */
    public function __construct(
        public string $subjectLine,
        public string $heading,
        public string $intro,
        public array $rows = [],
        public string $note = '',
        public ?array $highlight = null,
        public ?string $replyToEmail = null,
        public ?string $replyToName = null,
        public ?string $attachmentPath = null,
        public ?string $attachmentName = null,
    ) {}

    public function envelope(): Envelope
    {
        $envelope = new Envelope(subject: $this->subjectLine);

        if ($this->replyToEmail) {
            $envelope->replyTo[] = new \Illuminate\Mail\Mailables\Address($this->replyToEmail, $this->replyToName ?? '');
        }

        return $envelope;
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.branded',
            with: [
                'heading'   => $this->heading,
                'intro'     => $this->intro,
                'rows'      => $this->rows,
                'note'      => $this->note,
                'highlight' => $this->highlight,
            ],
        );
    }

    public function attachments(): array
    {
        if ($this->attachmentPath && is_file($this->attachmentPath)) {
            return [
                Attachment::fromPath($this->attachmentPath)
                    ->as($this->attachmentName ?: basename($this->attachmentPath)),
            ];
        }

        return [];
    }
}

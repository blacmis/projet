<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $otp, public string $email)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your MarketSmart verification code',
        );
    }

    public function content(): Content
    {
        return new Content(
            htmlString: '
                <div style="font-family:sans-serif;max-width:480px;margin:0 auto;padding:24px;">
                    <h2 style="color:#c47a1a;">MarketSmart</h2>
                    <p>Your verification code is:</p>
                    <p style="font-size:28px;font-weight:bold;letter-spacing:6px;color:#1a1a1a;">'
                    . e($this->otp) .
                    '</p>
                    <p style="color:#666;font-size:14px;">This code expires in 10 minutes.</p>
                    <p style="color:#999;font-size:12px;">If you did not request this, ignore this email.</p>
                </div>
            ',
        );
    }
}
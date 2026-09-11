<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationReceivedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $marketName, public string $ownerName)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre demande MarketSmart a bien été reçue',
        );
    }

    public function content(): Content
    {
        return new Content(
            htmlString: '
                <div style="font-family:sans-serif;max-width:480px;margin:0 auto;padding:24px;">
                    <h2 style="color:#c47a1a;">MarketSmart</h2>
                    <p>Bonjour ' . e($this->ownerName) . ',</p>
                    <p>Nous avons bien reçu votre demande de création d\'espace pour <strong>' . e($this->marketName) . '</strong>.</p>
                    <p>Votre demande est en cours de validation. Vous recevrez un email dès que votre accès sera activé — vous pourrez alors vous connecter avec l\'email et le mot de passe que vous avez choisis.</p>
                    <p style="color:#999;font-size:12px;">Une question en attendant ? Répondez simplement à cet email.</p>
                </div>
            ',
        );
    }
}
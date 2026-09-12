<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $marketName,
        public string $ownerName,
        public string $email,
        public string $password
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre espace MarketSmart est prêt : ' . $this->marketName,
        );
    }

    public function content(): Content
    {
        return new Content(
            htmlString: '
                <div style="font-family:sans-serif;max-width:480px;margin:0 auto;padding:24px;">
                    <h2 style="color:#c47a1a;">MarketSmart</h2>
                    <p>Bonjour ' . e($this->ownerName) . ',</p>
                    <p>Votre espace pour <strong>' . e($this->marketName) . '</strong> a été créé et est prêt à l\'emploi.</p>
                    <p><strong>Email :</strong> ' . e($this->email) . '<br>
                    <strong>Mot de passe :</strong> ' . e($this->password) . '</p>
                    <p style="color:#666;font-size:14px;">Nous vous recommandons de changer ce mot de passe après votre première connexion, depuis votre profil.</p>
                    <p style="color:#999;font-size:12px;">Une question ? Répondez simplement à cet email.</p>
                </div>
            ',
        );
    }
}
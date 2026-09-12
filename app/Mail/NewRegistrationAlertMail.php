<?php

namespace App\Mail;

use App\Models\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewRegistrationAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Tenant $tenant)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouvelle inscription MarketSmart : ' . $this->tenant->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            htmlString: '
                <div style="font-family:sans-serif;max-width:480px;margin:0 auto;padding:24px;">
                    <h2 style="color:#c47a1a;">MarketSmart</h2>
                    <p>Un nouveau supermarché vient de s\'inscrire en ligne :</p>
                    <p style="font-size:18px;font-weight:bold;color:#1a1a1a;">' . e($this->tenant->name) . '</p>
                    <p><strong>Secteur :</strong> ' . e($this->tenant->sector ?? '—') . '<br>
                    <strong>Contact :</strong> ' . e($this->tenant->owner_name) . ' — ' . e($this->tenant->owner_email) . '<br>
                    ' . ($this->tenant->owner_phone ? '<strong>Téléphone :</strong> ' . e($this->tenant->owner_phone) . '<br>' : '') . '</p>
                    <p>Il est en statut <strong>en attente</strong> — rendez-vous dans votre espace Super-Admin pour l\'activer.</p>
                </div>
            ',
        );
    }
}
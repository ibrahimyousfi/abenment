<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SessionSpotAvailable extends Notification
{
    use Queueable;

    protected $session;

    /**
     * Create a new notification instance.
     */
    public function __construct($session)
    {
        $this->session = $session;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Place disponible : ' . $this->session->name)
                    ->line('Une place s\'est libérée pour la séance ' . $this->session->name . '.')
                    ->line('Vous avez été automatiquement inscrit.')
                    ->action('Voir la séance', route('gym.sessions.show', $this->session->id))
                    ->line('Merci de votre confiance !');
    }

    /**
     * Get the SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return mixed
     */
    public function toSms($notifiable)
    {
        // Placeholder for SMS integration (e.g., Vonage, Twilio)
        // This method will be called if 'vonage' or 'nexmo' is added to the via() array
        return (object) [
            'content' => 'Place disponible pour ' . $this->session->name . '. Vous avez été inscrit.',
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'session_id' => $this->session->id,
            'message' => 'Une place s\'est libérée pour la séance ' . $this->session->name,
        ];
    }
}

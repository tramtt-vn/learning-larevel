<?php
namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
class CustomVerifyEmail extends Notification implements ShouldQueue {
    use Queueable;
    protected $expiration = 60*24;
    public function via($notifieble) {
        return ['mail'];
    }
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes($this->expiration),
            ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]
        );
    }

    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Xác minh email của bạn')
            ->view('emails.verify', [
                'user' => $notifiable,
                'verificationUrl' => $verificationUrl,
            ]);
    }
}
?>

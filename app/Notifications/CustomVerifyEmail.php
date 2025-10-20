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

    public function toMail($notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);
        $appName = config('app.name');

        return (new MailMessage)
            ->subject('Xác thực địa chỉ Email - ' . $appName)
            ->greeting('Xin chào ' . $notifiable->name . '!')
            ->line('Cảm ơn bạn đã đăng ký tài khoản tại **' . $appName . '**.')
            ->line('Để hoàn tất quá trình đăng ký, vui lòng nhấn vào nút bên dưới để xác thực địa chỉ email của bạn:')
            ->action('Xác thực Email', $verificationUrl)
            ->line('Link xác thực này sẽ hết hạn sau **24 giờ**.')
            ->line('Nếu bạn không tạo tài khoản này, vui lòng bỏ qua email này.')
            ->salutation('Trân trọng, ' . $appName);
    }
}
?>

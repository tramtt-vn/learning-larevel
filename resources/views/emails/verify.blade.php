<!doctype html>
<html>
<head><meta charset="utf-8"></head>
<body style="font-family: Arial, sans-serif; line-height:1.4;">
  <h2>Xin chào {{ $user->fullname ?? $user->email }},</h2>
  <p>Cảm ơn bạn đã đăng ký. Bấm nút phía dưới để xác minh email:</p>
  <p style="text-align:center; margin:20px 0;">
    <a href="{{ $verificationUrl }}" style="display:inline-block; padding:12px 20px; text-decoration:none; border-radius:6px; background:#2563eb; color:#fff;">
      Xác minh email
    </a>
  </p>
  <p>Nếu không dùng được nút, sao chép link dưới đây:</p>
  <p style="word-break:break-all;"><small>{{ $verificationUrl }}</small></p>
  <hr>
  <p style="color:#666; font-size:12px;">Nếu bạn không yêu cầu xác minh, bỏ qua email này.</p>
</body>
</html>

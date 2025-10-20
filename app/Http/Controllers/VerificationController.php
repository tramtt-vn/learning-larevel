<?php
namespace App\Http\Controllers;

use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class VerificationController extends Controller {
    public function notice() {
        return view('auth.verify');
    }
    public function verify(EmailVerificationRequest $request) {
        if($request->user()->hasVerifiedEmail()){
            return redirect()->route('dashboard')->with('info', 'Email đã được xác minh trước đó');
        }
        if($request->user()->markEmailAsVerified()){
            $request->user()->update(['verification_token' => null]);
            event(new Verified($request->user()));
        }
        return redirect()->route('dashboard')->with('success', "Email xác thực thành công");

    }
    public function resend(Request $request){
        if($request->user()->hasVerifiedEmail()){
            return redirect()->route('dashboard');
        }
        $request->user()->sendEmailVerificationNotification();
        return back()->with('success', "Đã gửi xác minh tới email thành công");
    }
}
?>

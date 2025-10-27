<?php
namespace App\Http\Controllers;

use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Models\User;

class VerificationController extends Controller {
    public function show() {
        return view('auth.verify-email');
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
        $user = User::find($request->id);
        if($user && $user->hasVerifiedEmail()){
            return redirect()->route('dashboard');
        }
        if(!$user) {
            return back()->withErrors(['error' => 'Không tìm thấy người dùng']);
        }
        $user->sendEmailVerificationNotification();
        return back()->with('success', "Đã gửi xác minh tới email thành công")->with(['email'=>  $user->email, 'id' => $user->id]);
    }
}
?>

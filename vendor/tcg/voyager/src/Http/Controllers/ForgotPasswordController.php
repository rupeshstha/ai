<?php

namespace TCG\Voyager\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User, TCG\Voyager\Models\PasswordReset;
use TCG\Voyager\Facades\Voyager;

class ForgotPasswordController extends Controller
{
    private $folder;

    private function generateToken() {
        $seed = md5(rand(100,999).time());
        while( true ) {
            $token = substr($seed, 0, 12);
            $passwordResetCount = PasswordReset::where('token', $token)->get()->count();
            if( $passwordResetCount < 1 ) break;
        }
        return $token;
    }

    public function __construct()
    {
        $this->folder = 'forgot-password.';
    }

    public function index()
    {
        return Voyager::view('voyager::'.$this->folder.'index');
    }

    public function reset( Request $request )
    {
        $data = $request->validate([
            'email' => 'required|email|exists:users,email'
        ],[
            'email.required' => 'Please enter an email.',
            'email.email' => 'Please enter a valid email.',
            'email.exists' => 'The email does not exist in our records.'
        ]);
        $data['token'] = $this->generateToken();
        $data['created_at'] = now();

        $passwordReset = PasswordReset::create($data);
        return redirect()->route('voyager.login')->withErrors(['success'=> 'Reset link has been sent to your email.']);
    }

    public function token( $token )
    {
        $passwordReset = PasswordReset::where('token', $token)->firstOrFail();
        return Voyager::view('voyager::'.$this->folder.'reset', compact('passwordReset'));
    }

    public function update( $token, Request $request )
    {
        $passwordReset = PasswordReset::where('token', $token)->firstOrFail();
        $data = $request->validate([
            'password' => 'required|confirmed'
        ],[
            'password.required' => 'Please enter a new password.',
            'password.confirmed' => 'Passwords do not match.'
        ]);
        $data['password'] = bcrypt($request->password);

        $user = User::where('email', $passwordReset->email)->update($data);
        $passwordResetDelete = PasswordReset::where('token', $token)->delete();

        return redirect()->route('voyager.login')->withErrors(['success'=> 'Password has been successfully resetted.']);
    }
}

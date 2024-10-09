<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\UserStatus;
use App\UserType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Helpers\CMail;

class AuthController extends Controller
{
    public function loginForm(Request $request) {
        $data = [
            'pageTitle' => 'Login'
        ];
        return view('back.pages.auth.login', $data);
    }

    public function forgotForm(Request $request) {
        $data = [
            'pageTitle' => 'Forgot Password'
        ];

        return view('back.pages.auth.forgot', $data);
    }

    public function loginHandler(Request $request) {
        $fieldType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if($fieldType == 'email') {
            $request->validate([
                'login_id' => 'required|email|exists:users,email',
                'password' => 'required|min:5'
            ], [
                'login_id.required' => 'Enter your email or username',
                'login_id.email' => 'Invalid email address',
                'login_id.exists' => 'No account found for this email'
            ]);
        } else {
            $request->validate([
                'login_id' => 'required|exists:users,username',
                'password' => 'required|min:5'
            ], [
                'login_id.required' => 'Enter your email or username',
                'login_id.exists' => 'No account found for this username'
            ]);
        }

        $creds = array(
            $fieldType => $request->login_id,
            'password' => $request->password,
        );

        if(Auth::attempt($creds)) {
            // Check if account is inactive mode
            if(auth()->user()->status == UserStatus::Inactive) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('admin.login')->with('fail', 'Your account is currently inactive. Please, contact support at (support@email.com) for further assistance');
            }

            // Check if account is in Pending mode
            if(auth()->user()->status == UserStatus::Pending) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('admin.login')->with('fail', 'Your account is currently pending approval. Please, check your email further instructions or contact support at (support@email.com) assistance');
            }

            // Redirect use to dashboard
            return redirect()->route('admin.dashboard')->with('success', 'You are now logged in');
        } else {
            return redirect()->route('admin.login')->withInput()->with('fail', 'Incorrect password.');
        }
    }

    public function sendPasswordResetLink(Request $request) {
        DB::enableQueryLog();	//query log 시작 선언부

        // Validate the form
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.required' => 'The :attribute is required',
            'email.email' => 'Invalid email address',
            'email.exists' => 'We can not find a user with this email address'
        ]);

        // Get User Details
        $user = User::where('email', $request->email)->first();

        // Generate Token
        $token = base64_encode(Str::random(64));

        // Check if there is an existing token
        $oldToken = DB::table('password_reset_tokens')->where('email', $user->email)->first();

        if($oldToken) {
            // Update existing token
            DB::table('password_reset_tokens')->where('email', $user->email)->update([
                'token' => $token,
                'created_at' => Carbon::now()
            ]);
        } else {
            // Add new reset password token
            DB::table('password_reset_tokens')->insert([
                'email' => $user->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);
        }

        // Create clickable action link
        $actionLink = route('admin.reset_password_form', ['token'=>$token]);

        $data = array(
            'actionlink' => $actionLink,
            'user' => $user
        );

        $mail_body = view('email-templates.forgot-template', $data)->render();

        $mailConfig = array(
            'recipient_address' => $user->email,
            'recipient_name' => $user->name,
            'subject' => 'Reset Password',
            'body' => $mail_body
        );

        if(CMail::send($mailConfig)) {
            // echo "성공<br>";
            return redirect()->route('admin.forgot')->with('success', 'We have e-mailed your password reset link.');
        } else {
            // echo "실패!<br>";
            return redirect()->route('admin.forgot')->with('fail', 'Something went wrong. Resetting password link not sent. Try again later.');
        }
    }

    public function resetForm(Request $request, $token) {
        DB::enableQueryLog();	//query log 시작 선언부

        // Check if this token is exists.
        $isTokenExists = DB::table('password_reset_tokens')->where('token', $token)->first();

        if(!$isTokenExists) {
            // echo "Invalid token!<br>\n";
            return redirect()->route('admin.forgot')->with('fail', 'Invalid token, Request another reset password link.');
        } else {
            // Check if Token is not expired
            $diffMins = Carbon::createFromFormat('Y-m-d H:i:s', $isTokenExists->created_at)->diffInMinutes(Carbon::now());

            if( $diffMins > 15) {
                // When token is older this 15 minutes
                return redirect()->route('admin.forgot')->with('fail', 'The password reset link you clicked has expired. Please request a new link');
            }
            $data = [
                'pageTitle' => 'Reset Password',
                'token' => $token
            ];

            return view('back.pages.auth.reset', $data);
        }

    }

    public function resetPasswordHandler(Request $request) {
        // Validate the form
        $request->validate([
            'new_password' => 'required|min:5|required_with:new_password_confirmation|same:new_password_confirmation',
            'new_password_confirmation' => 'required'
        ]);

        $dbToken = DB::table('password_reset_tokens')->where('token', $request->token)->first();

        // Get User details
        $user = User::where('email', $dbToken->email)->first();

        // Update Password
        User::where('email', $user->email)->update([
            'password' => Hash::make($request->new_password)
        ]);

        // Send notification email to this user email addrss that contains new password
        $data = array(
            'user' => $user,
            'new_password' => $request->new_password
        );

        $mail_body = view('email-templates.password-changes-template', $data)->render();

        $mailConfig = array(
            'recipient_address' => $user->email,
            'recipient_name' => $user->name,
            'subject' => 'Password Changed',
            'body' => $mail_body
        );

        if( CMail::send($mailConfig) ) {
            // Delete token from DB
            DB::table('password_reset_tokens')->where([
                'email' => $dbToken->email,
                'token' => $dbToken->token
            ])->delete();

            return redirect()->route('admin.login')->with('success', 'Done!, Your password has been changed successfully. Use your new password for login into system.');
        } else {
            return redirect()->route('admin.reset_password_form', ['token' => $dbToken->token])->with('fail', 'Something went wrong! Please try again.');
        }
    }
}
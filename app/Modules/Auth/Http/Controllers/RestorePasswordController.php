<?php namespace App\Modules\Auth\Http\Controllers;

use Str, Mail, Sentinel, Reminder, Redirect, Captcha, User, Input, FrontController;

class RestorePasswordController extends FrontController {
    
    public function getIndex()
    {
        $this->pageView('auth::restore_password');
    }

    /**
     * This method will generate a reset password code, save it with the user model
     * and send it to the user's email address.
     */
    public function postIndex()
    {
        if (! Captcha::check(Input::get('captcha'))) {
            return Redirect::to('auth/restore')
                ->withInput()->withErrors(['message' => trans('app.captcha_invalid')]);
        }

        $email = Input::get('email');

        $user = Sentinel::findByCredentials(['login' => $email]);

        if (! $user) {
            $this->alertError(trans('auth::email_invalid'));
            return;
        }

        $reminder = Reminder::create($user); // This will generate a new code

        Mail::send('auth::emails.restore_password', compact('user', 'reminder'), function($message) use ($email, $user)
        {
            $message->to($email, $user->username)->subject(trans('auth::password_reset'));
        });

        $this->alertSuccess(
            trans('auth::email_gen_pw')
        );
    }

    /**
     * This method will check the email and the submitted code (it is included into the URL)
     * and if they pass generate a new password and send it to the user.
     * 
     * @param  string $email The user's email adress
     * @param  string $code  Reset password code
     */
    public function getNew($email, $code)
    {
        $user = Sentinel::findByCredentials(['login' => $email]);

        if (! $user) {
            $this->alertError(trans('auth::email_invalid'));
            return;
        }

        $password = strtolower(Str::random(9)); // Generate a new password

        // Check the stored code with the passed and if they match, save the new password.
        if (! Reminder::complete($user, $code, $password)) {
            $this->alertError(trans('auth::code_invalid'));
            return;
        }

        Mail::send('auth::emails.send_password', compact('user', 'password'), function($message) use ($email, $user)
        {
            $message->to($email, $user->username)->subject(trans('auth::new_pw'));
        });

        $this->alertSuccess(
            trans('auth::email_new_pw')
        );
    }
}
<?php

namespace App\Mail;

use App\User;
use App\Users;
use Config;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PasswordResetEmailNew extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Users $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
                ->subject('Password Reset request')
                ->view('email.password_reset_emailnewtemplate')
                ->with([
                        'reset_link' => trans('CommonData.frontendurl')."create-password/".$this->user->password_reset_token,
                         'user'=>$this->user,
                        //'logo' => resource_path("assets/images/munttoo-emailer-logo.jpg")
                    ]);
    }
}

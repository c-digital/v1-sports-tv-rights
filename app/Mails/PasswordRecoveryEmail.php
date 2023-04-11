<?php

namespace App\Mails;

use View;

class PasswordRecoveryEmail extends Mail
{
    /**
     * Set from for email.
     *
     * @var string
     */
    public string $from = 'info@base.com';

    /**
     * Set subject for email.
     *
     * @var string
     */
    public string $subject = 'Recuperación de contraseña de Base PHP';

    /**
     * Set attach for email.
     *
     * @var array
     */
    public array $attach = [];

    /**
     * User data for email
     *
     * @var mixed
     */
    public mixed $user;

    /**
     * Create a email instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the email.
     *
     * @return View
     */
    public function build(): View
    {
        return view('recover', ['user' => $this->user]);
    }
}

<?php

namespace App\Errors;

class AccountErrors {
  public const ACCOUNT_NOT_FOUND = 'Account not found.';

  public const INCORRECT_PASSWORD = 'Incorrect password.';

  public const EMAIL_ALREADY_IN_USE = 'This email is already in use.';
  public const EMAIL_ALREADY_VERIFIED = 'This email has already been verified before.';
}

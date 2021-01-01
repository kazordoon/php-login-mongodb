<?php

namespace App\Errors;

class ValidationErrors {
  public const INVALID_NAME_LENGTH = 'Name too long, try using only the first and last name.';

  public const INVALID_EMAIL_FORMAT = 'The provided email has an invalid format.';

  public const DIFFERENT_PASSWORDS = 'The passwords don\'t match.';
  public const INVALID_PASSWORD_LENGTH = 'The password must have between 8 and 50 characters.';

  public const EMPTY_FIELDS = 'Fill in all fields.';
  public const EMPTY_EMAIL_FIELD = 'Fill in the email field.';
  public const EMPTY_NAME_FIELD = 'Fill in the name field.';
}

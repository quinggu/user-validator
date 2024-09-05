<?php

class UserValidator
{
    // Validate email method
    public function validateEmail(string $email): bool
    {
        // Regular expression pattern explanation:
        // 1. `^` - Start of the string
        // 2. `[a-zA-Z]` - At least one letter (uppercase or lowercase)
        // 3. `[a-zA-Z0-9._%+-]*` - Zero or more of the following: letters, digits, dot, underscore, percent, plus, or hyphen
        // 4. `@` - The "@" symbol must be present
        // 5. `[a-zA-Z0-9.-]+` - At least one or more of the following: letters, digits, dot, or hyphen
        // 6. `\.` - A dot symbol
        // 7. `[a-zA-Z]{2,}` - At least two or more letters for the domain extension
        // 8. `$` - End of the string
        $pattern = '/^[a-zA-Z][a-zA-Z0-9._%+-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

        return (bool)preg_match($pattern, $email);
    }

    // Validate password method, delegating each rule to separate methods
    public function validatePassword(string $password): bool
    {
        return $this->hasMinimumLength($password) &&
            $this->hasUppercaseLetter($password) &&
            $this->hasLowercaseLetter($password) &&
            $this->hasDigit($password) &&
            $this->hasSpecialCharacter($password);
    }

    // Check if password has a minimum of 8 characters
    private function hasMinimumLength(string $password): bool
    {
        return strlen($password) >= 8;
    }

    // Check if password contains at least one uppercase letter
    private function hasUppercaseLetter(string $password): bool
    {
        return (bool)preg_match('/[A-Z]/', $password);
    }

    // Check if password contains at least one lowercase letter
    private function hasLowercaseLetter(string $password): bool
    {
        return (bool)preg_match('/[a-z]/', $password);
    }

    // Check if password contains at least one digit
    private function hasDigit(string $password): bool
    {
        return (bool)preg_match('/\d/', $password);
    }

    // Check if password contains at least one special character
    private function hasSpecialCharacter(string $password): bool
    {
        return (bool)preg_match('/[\W_]/', $password); // \W matches any non-word character, including special characters
    }
}

// Usage example
$validator = new UserValidator();
$email = "test@example.com";
$password = "StrongPass1!";

if ($validator->validateEmail($email)) {
    echo "Email is valid.\n";
} else {
    echo "Email is invalid.\n";
}

if ($validator->validatePassword($password)) {
    echo "Password is valid.\n";
} else {
    echo "Password is invalid.\n";
}

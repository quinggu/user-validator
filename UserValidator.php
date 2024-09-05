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


////////////////////////////////////////////////////////////////////
//
//// some modifications
//
//// Attribute definition for metadata (optional)
//#[Attribute]
//class MethodMetadata
//{
//    public function __construct(public string $description)
//    {
//    }
//}
//
//readonly class UserValidator
//{
//    // Constructor Property Promotion: Promotes email and password directly from constructor arguments
//    public function __construct(
//        private string $email,
//        private string $password
//    ) {}
//
//    // Validate email method with attribute for metadata
//    #[MethodMetadata(description: "Validates email using a regular expression")]
//    public function validateEmail(): bool
//    {
//        // Check if '@' exists using str_contains() from PHP 8.0
//        if (!str_contains($this->email, '@')) {
//            return false;
//        }
//
//        // Regular expression to validate email structure
//        $pattern = "/^[a-zA-Z][a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
//
//        return (bool)preg_match($pattern, $this->email);
//    }
//
//    // Validate password method with attribute for metadata
//    #[MethodMetadata(description: "Validates password with rules: min 8 chars, 1 uppercase, 1 lowercase, 1 digit, 1 special char")]
//    public function validatePassword(): bool
//    {
//        return $this->hasMinimumLength() &&
//            $this->hasUppercaseLetter() &&
//            $this->hasLowercaseLetter() &&
//            $this->hasDigit() &&
//            $this->hasSpecialCharacter();
//    }
//
//    // Check password length
//    private function hasMinimumLength(): bool
//    {
//        return strlen($this->password) >= 8;
//    }
//
//    // Check for at least one uppercase letter
//    private function hasUppercaseLetter(): bool
//    {
//        return (bool)preg_match('/[A-Z]/', $this->password);
//    }
//
//    // Check for at least one lowercase letter
//    private function hasLowercaseLetter(): bool
//    {
//        return (bool)preg_match('/[a-z]/', $this->password);
//    }
//
//    // Check for at least one digit
//    private function hasDigit(): bool
//    {
//        return (bool)preg_match('/\d/', $this->password);
//    }
//
//    // Check for at least one special character
//    private function hasSpecialCharacter(): bool
//    {
//        return (bool)preg_match('/[\W]/', $this->password);
//    }
//}
//
//// Example of usage
//$validator = new UserValidator("test@example.com", "StrongPass1!");
//if ($validator->validateEmail()) {
//    echo "Email is valid.\n";
//} else {
//    echo "Email is invalid.\n";
//}
//
//if ($validator->validatePassword()) {
//    echo "Password is valid.\n";
//} else {
//    echo "Password is invalid.\n";
//}
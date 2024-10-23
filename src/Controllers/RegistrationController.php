<?php

namespace Controllers;

use Services\UniqueLinkFactory;
use Repositories\UserRepository;

class RegistrationController {
    private $userRepository;
    private $linkFactory;

    public function __construct() {
        $this->userRepository = new UserRepository();
        $this->linkFactory = new UniqueLinkFactory();
    }

    public function showRegistrationForm() {
        require_once __DIR__ . '/../Views/register.php';
    }

    public function registerUser() {
        $username = $_POST['username'];
        $phoneNumber = $_POST['phone_number'];

        $userId = $this->userRepository->createUser($username, $phoneNumber);

        $uniqueLink = $this->linkFactory->createLink($userId);

        echo "Your unique link: <a href='/link/{$uniqueLink}'>{$uniqueLink}</a>";
    }
}

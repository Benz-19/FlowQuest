<?php
//dir:App/Models/Interfaces/UserInterface.php
namespace App\Models\Interfaces;

interface UserInterface
{
    public function manageUser(string $action, array $params);
    public function isUser(string $user_email): ?bool;
    public function login(array $params = []): bool;
    public function register(array $params = []);
    public function verifyUser(string $email): bool;
    public function isVerified(string $email): ?bool;

    public function updatePassword(array $params = []);
    public function updateUserStatus(string $email);

    public function getUserType(string $email);
    public function getUserIdByEmail(string $user_email): ?string;
    public function getUserDetailsById(int $user_id): ?array;
    public function getAllUserData();
};

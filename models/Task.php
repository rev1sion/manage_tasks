<?php


namespace taskBj;


class Task
{
    private User $user;
    private string $body;
    private string $state;

    public function __construct(User $_user, string $_body, $_state = 'New')
    {
        $this->user = $_user;
        $this->body = $_body;
        $this->state = $_state;
    }
}

class User
{
    private string $id;
    private string $email;
    private string $username;

    public function __construct(array $data)
    {
        $this->id = bin2hex(openssl_random_pseudo_bytes(16));
        $this->email = $data['email'];
        $this->username = $data['username'];
    }
}
<?php


namespace Domain\Auth\DTOs;


use Illuminate\Http\Request;
use Support\Traits\Makeable;

class NewUserDTO
{
    use Makeable;

    public string $name;
    public string $email;
    public string $password;

    public function __construct(array $user)
    {
        $this->name = $user['name'];
        $this->email = $user['email'];
        $this->password = $user['password'];

    }

    public static function fromRequest(Request $request)
    {
            return static::make($request->only('name', 'email', 'password'));

    }
}

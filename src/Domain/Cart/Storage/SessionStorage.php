<?php


namespace Domain\Cart\Storage;


class SessionStorage implements \Domain\Cart\Contracts\CartStorageContract
{

    public function get(): string
    {
        return session()->getId();
    }
}

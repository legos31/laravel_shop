<?php


namespace Domain\Cart\Storage;


class FakeSessionStorage implements \Domain\Cart\Contracts\CartStorageContract
{

    public function get(): string
    {
        return 'test';
    }
}

<?php


namespace Domain\Cart\Contracts;


interface CartStorageContract
{
    public function get(): string;
}

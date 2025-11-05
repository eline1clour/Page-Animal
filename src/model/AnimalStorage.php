<?php

interface AnimalStorage {
    public function read($id): ?Animal;
    public function readAll(): array;
}
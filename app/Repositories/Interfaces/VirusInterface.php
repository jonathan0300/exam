<?php

namespace App\Repositories\Interfaces;

interface VirusInterface
{
    public function get();

    public function delete($id);

    public function update($id, $input);

    public function store(array $input);
}

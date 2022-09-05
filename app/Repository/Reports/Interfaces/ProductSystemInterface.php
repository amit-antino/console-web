<?php

namespace App\Repository\Reports\Interfaces;

interface ProductSystemInterface
{
    public function getAll();
    public function createReport($collection);
    public function destroy($id);
}

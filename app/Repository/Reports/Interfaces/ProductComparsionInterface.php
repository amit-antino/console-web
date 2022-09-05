<?php

namespace App\Repository\Reports\Interfaces;

interface ProductComparsionInterface
{
    public function getAll();
    public function createReport($collection);
    public function destroy($id);
}

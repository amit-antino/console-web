<?php

namespace App\Repository\Reports\Interfaces;

interface ProcesComparsionReport
{
    public function getAll();
    public function createReport($collection);
    public function destroy($id);
}

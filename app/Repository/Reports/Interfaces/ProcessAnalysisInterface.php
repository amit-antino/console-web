<?php

namespace App\Repository\Reports\Interfaces;

interface ProcessAnalysisInterface
{
    public function getAll();
    public function createReport($collection);
    public function destroy($id);
}

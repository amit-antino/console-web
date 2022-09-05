<?php

namespace App\Providers;

use App\Models\ProductSystem\ProductComparison;
use App\Models\Report\ProductSystemReport;
use App\Repository\Reports\Eloquent\ProcessAnalysisRepository;
use App\Repository\Reports\Eloquent\ProcessComparsionRepository;
use App\Repository\Reports\Eloquent\ProductSystemRepository;
use App\Repository\Reports\Eloquent\ProductComparsionRepository;
use App\Repository\Reports\Interfaces\ProcesComparsionReport;
use App\Repository\Reports\Interfaces\ProcessAnalysisInterface;
use App\Repository\Reports\Interfaces\ProductComparsionInterface;
use App\Repository\Reports\Interfaces\ProductSystemInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ProcessAnalysisInterface::class, ProcessAnalysisRepository::class);
        $this->app->bind(ProcesComparsionReport::class, ProcessComparsionRepository::class);
        $this->app->bind(ProductSystemInterface::class, ProductSystemRepository::class);
        $this->app->bind(ProductComparsionInterface::class, ProductComparsionRepository::class);
    }

    public function boot()
    {
    }
}

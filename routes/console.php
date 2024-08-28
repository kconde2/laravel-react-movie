<?php

use Domain\Movies\Commands\FetchMoviesCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('telescope:prune')->daily();

Schedule::command(FetchMoviesCommand::class)->daily();

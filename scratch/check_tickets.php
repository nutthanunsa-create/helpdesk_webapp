<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

App\Models\HelpdeskCase::query()->update(['requires_preventive_measure' => null]);
echo "Updated successfully.\n";

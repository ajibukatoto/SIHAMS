<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class DashboardWelcome extends Widget
{
    protected string $view = 'filament.widgets.dashboard-welcome';

    protected int | string | array $columnSpan = 'full';
}

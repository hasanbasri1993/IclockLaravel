<?php

namespace App\Livewire;

use App\Models\Attendance;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class AttendanceTable extends DataTableComponent
{
    protected $model = Attendance::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id')
                ->sortable(),
            Column::make('Employee id', 'employee_id')
                ->sortable(),
            Column::make('Timestamp', 'timestamp')
                ->sortable(),
            Column::make('Status', 'status1')
                ->sortable(),
            Column::make('Verify', 'status2')
                ->sortable(),
            Column::make('Workcode', 'status3')
                ->sortable(),
            Column::make('Reserved', 'status4')
                ->sortable(),
            Column::make('Reserved', 'status5')
                ->sortable(),
            Column::make('Created at', 'created_at')
                ->sortable(),
            Column::make('Updated at', 'updated_at')
                ->sortable(),
        ];
    }
}

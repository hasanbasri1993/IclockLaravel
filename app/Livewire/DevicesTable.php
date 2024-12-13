<?php

namespace App\Livewire;

use App\Models\Device;
use App\Models\DeviceCmd;
use Carbon\Carbon;
use Illuminate\Support\Enumerable;
use Illuminate\Support\Facades\Log;
use RamonRietdijk\LivewireTables\Actions\Action;
use RamonRietdijk\LivewireTables\Columns\Column;
use RamonRietdijk\LivewireTables\Columns\DateColumn;
use RamonRietdijk\LivewireTables\Filters\DateFilter;
use RamonRietdijk\LivewireTables\Livewire\LivewireTable;

class DevicesTable extends LivewireTable
{
    protected string $model = Device::class;

    protected bool $deferLoading = true;

    protected bool $useSession = true;

    protected array $pollingOptions = [
        '' => 'None',
        '5s' => 'Every 5 seconds',
    ];

    protected function columns(): array
    {
        return [

            Column::make('ID', 'SN')
                ->searchable()
                ->sortable(),

            // Status: {{ \Carbon\Carbon::parse($device->LastActivity)->diffInMinutes(now()) < 2 ? 'ONLINE' : 'OFFLINE' }}</h2>
            Column::make('Online', 'LastActivity')
                ->displayUsing(function (mixed $value): string {
                    return Carbon::parse($value)
                        ->diffInMinutes(now()) < 2 ? 'ONLINE' : 'OFFLINE';
                })
                ->sortable(),
            DateColumn::make('Waktu', 'LastActivity')
                ->sortable()
                ->searchable()
                ->format('F jS, Y h:i A'),
        ];
    }

    protected function filters(): array
    {
        return [
            DateFilter::make('Waktu', 'LastActivity'),
        ];
    }

    protected function actions(): array
    {
        return [
            Action::make(__('Check'), 'check', function (Enumerable $device): void {
                foreach ($device as $d) {
                    $deviceCmd = new DeviceCmd;
                    $deviceCmd->setCmd($d->SN, 'CHECK');
                    Log::info('deviceCmd: check ->'.$d->SN);
                }
            }),

            Action::make(__('Info'), 'info', function (Enumerable $device): void {
                foreach ($device as $d) {
                    $deviceCmd = new DeviceCmd;
                    $deviceCmd->setCmd($d->SN, 'INFO');
                    Log::info('deviceCmd: info ->'.$d->SN);
                }
            }),
            Action::make(__('Transfer Data From Device'), 'info',
                function (Enumerable $device): void {
                    foreach ($device as $d) {
                        $deviceM = Device::find($d->SN);
                        $deviceM->LogStamp = 0;
                        $deviceM->OpLogStamp = 0;
                        $deviceM->PhotoStamp = 0;
                        $deviceM->save();

                        $deviceCmd = new DeviceCmd;
                        $deviceCmd->setCmd($d->SN, 'CHECK');
                        Log::info('deviceCmd: Transfer Data From Device ->'.$d->SN);
                    }
                }),
            Action::make(__('Reboot'), 'reboot', function (Enumerable $device): void {
                foreach ($device as $d) {
                    $deviceCmd = new DeviceCmd;
                    $deviceCmd->setCmd($d->SN, 'REBOOT');
                    Log::info('deviceCmd: REBOOT ->'.$d->SN);
                }
            }),
        ];
    }
}

<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire\General\Forms;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;
use Modules\Timecard\Models\BreakTime;

class BreakTimeData extends Form
{
    public ?int $id = null;

    public ?int $userId = null;

    public ?CarbonImmutable $date = null;

    public ?string $inTime = null;

    public ?string $outTime = null;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'inTime' => [
                'required',
                'date_format:H:i',
            ],
            'outTime' => [
                'nullable',
                'date_format:H:i',
                'after:inTime',
            ],
        ];
    }

    public function validationAttributes()
    {
        return [
            'inTime' => '開始時間',
            'outTime' => '終了時間',
        ];
    }

    public function setData(
        BreakTime $breakTime,
    ) {
        $this->userId = $breakTime->user_id;
        $this->date = $breakTime->date;
        $this->id = $breakTime->id;
        $this->inTime = $breakTime->in_time?->format('H:i');
        $this->outTime = $breakTime->out_time?->format('H:i');
    }

    public function clear()
    {
        $this->reset([
            'id',
            'userId',
            'date',
            'inTime',
            'outTime',
        ]);
    }

    public function save()
    {
        $this->validate();

        if (! empty($this->inTime) || ! empty($this->outTime)) {
            BreakTime::updateOrCreate(
                ['id' => $this->id],
                [
                    'user_id' => $this->userId,
                    'date' => $this->date,
                    'in_time' => $this->inTime,
                    'out_time' => $this->outTime,
                ]
            );

            return;
        }

        if (! is_null($this->id)) {
            BreakTime::destroy($this->id);
        }
    }

    public function delete()
    {
        BreakTime::destroy($this->id);
        $this->reset(['id', 'userId', 'date', 'inTime', 'outTime']);
    }

    public function term()
    {
        $inTime = $this->inTime ?? ' -- : -- ';
        $outTime = $this->outTime ?? ' -- : -- ';

        return $inTime . ' ～ ' . $outTime;
    }
}

final class BreakTimeForm extends Form
{
    public array $breakTimes = [];

    public array $deleteList = [];

    public function sync(): void
    {
        collect($this->breakTimes)->each(function ($breakTime) {
            $breakTime->save();
        });

        BreakTime::destroy($this->deleteList);
        $this->deleteList = [];
    }

    public function setBreakTimes(BreakTimeData $breakData, Collection $breakTimes): void
    {
        $this->reset('breakTimes');
        foreach ($breakTimes as $breakTime) {
            $wd = clone $breakData;
            $wd->setData($breakTime);
            array_push($this->breakTimes, $wd);
        }
    }

    public function addBreakTime(BreakTimeData $breakData, CarbonImmutable $date)
    {
        $breakTime = new BreakTime([
            'id' => CarbonImmutable::now()->toString(),
            'user_id' => Auth::id(),
            'date' => $date,
        ]);

        $breakData->setData($breakTime);
        array_push($this->breakTimes, $breakData);
    }

    public function removeBreakTime($key)
    {
        $breakTime = $this->breakTimes[$key];

        $id = $breakTime->id;
        unset($this->breakTimes[$key]);

        if ($id) {
            $this->deleteList[] = $id;
        }
    }
}

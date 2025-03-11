<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire\Forms;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;
use Modules\Timecard\Models\WorkTime;

class WorkTimeData extends Form
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
        WorkTime $workTime,
    ) {
        $this->userId = $workTime->user_id;
        $this->date = $workTime->date;
        $this->id = $workTime->id;
        $this->inTime = $workTime->in_time?->format('H:i');
        $this->outTime = $workTime->out_time?->format('H:i');
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
            WorkTime::updateOrCreate(
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
            WorkTime::destroy($this->id);
        }
    }

    public function delete()
    {
        WorkTime::destroy($this->id);
    }

    public function term()
    {
        $inTime = $this->inTime ?? ' -- : -- ';
        $outTime = $this->outTime ?? ' -- : -- ';

        return $inTime . ' ～ ' . $outTime;
    }
}

final class WorkTimeForm extends Form
{
    public array $workTimes = [];

    public array $deleteList = [];

    public function sync(): void
    {
        collect($this->workTimes)->each(function ($workTime) {
            $workTime->save();
        });

        WorkTime::destroy($this->deleteList);
        $this->deleteList = [];
    }

    public function setWorkTimes(WorkTimeData $workData, Collection $workTimes): void
    {
        $this->reset('workTimes');
        foreach ($workTimes as $workTime) {
            $wd = clone $workData;
            $wd->setData($workTime);
            array_push($this->workTimes, $wd);
        }
    }

    public function addWorkTime(WorkTimeData $workData, CarbonImmutable $date)
    {
        $workTime = new WorkTime([
            'id' => CarbonImmutable::now()->toString(),
            'user_id' => Auth::id(),
            'date' => $date,
        ]);

        $workData->setData($workTime);
        array_push($this->workTimes, $workData);
    }

    public function removeWorkTime($key)
    {
        $workTime = $this->workTimes[$key];

        $id = $workTime->id;
        unset($this->workTimes[$key]);

        if ($id) {
            $this->deleteList[] = $id;
        }
    }
}

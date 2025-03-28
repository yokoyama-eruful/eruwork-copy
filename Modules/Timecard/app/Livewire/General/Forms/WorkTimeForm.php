<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire\General\Forms;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
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

    private function overlappingValidate()
    {
        $workInTime = CarbonImmutable::parse($this->inTime);
        $workOutTime = CarbonImmutable::parse($this->outTime);

        $workTimes = WorkTime::query()
            ->where('user_id', Auth::id())
            ->where('date', $this->date)
            ->where(function ($query) use ($workInTime, $workOutTime) {
                $query->where('id', '!=', $this->id)
                    ->where('in_time', '<=', $workOutTime)
                    ->where('out_time', '>=', $workInTime);
            })->get();

        if ($workTimes->isNotEmpty()) {
            throw ValidationException::withMessages([
                'workError' => '勤務時間が重複しています',
            ]);
        }
    }

    public function save()
    {
        $this->validate();

        $this->overlappingValidate();

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
        $this->reset(['id', 'userId', 'date', 'inTime', 'outTime']);
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
            $validator = Validator::make($workTime->toArray(), [
                'inTime' => 'required|date_format:H:i',
                'outTime' => 'required|date_format:H:i|after:in_time',
            ]);

            if ($validator->fails()) {
                throw new \Illuminate\Validation\ValidationException($validator);
            }

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

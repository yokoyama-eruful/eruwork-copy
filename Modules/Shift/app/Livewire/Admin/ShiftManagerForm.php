<?php

declare(strict_types=1);

namespace Modules\Shift\Livewire\Admin;

use App\Models\User;
use App\Notifications\WebPushNotification;
use Livewire\Form;
use Modules\Shift\Models\Manager;

final class ShiftManagerForm extends Form
{
    public ?string $startDate = null;

    public ?string $endDate = null;

    public ?string $submissionStartDate = null;

    public ?string $submissionEndDate = null;

    public Manager $manager;

    public function rules()
    {
        return [
            'startDate' => [
                'required',
                'date_format:Y-m-d',
                function ($attribute, $value, $fail) {
                    $exists = Manager::where('start_date', '<=', $this->endDate)
                        ->where('end_date', '>=', $this->startDate)
                        ->exists();

                    if ($exists) {
                        $fail('指定した期間は、すでに登録されている期間と重複しています。');
                    }
                },
            ],
            'endDate' => [
                'required',
                'date_format:Y-m-d',
                'after:startDate',
          ],

            'submissionStartDate' => [
                'required',
                'date_format:Y-m-d',
          ],
            'submissionEndDate' => [
                'required',
                'date_format:Y-m-d',
                'after:submissionStartDate',
          ],
        ];
    }

    public function validationAttributes()
    {
        return [
            'startDate' => 'シフト表開始日',
            'endDate' => 'シフト表終了日',
            'submissionStartDate' => 'シフト募集開始日',
            'submissionEndDate' => 'シフト募集終了日',
        ];
    }

    public function setValues(Manager $manager): void
    {
        $this->manager = $manager;
        $this->startDate = $manager->start_date->format('Y-m-d');
        $this->endDate = $manager->end_date->format('Y-m-d');
        $this->submissionStartDate = $manager->submission_start_date->format('Y-m-d');
        $this->submissionEndDate = $manager->submission_end_date->format('Y-m-d');
    }

    public function save(): void
    {
        $this->validate();

        $manager = Manager::create([
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'submission_start_date' => $this->submissionStartDate,
            'submission_end_date' => $this->submissionEndDate,
        ]);

        $allUsers = User::all();
        $userData = [];
        foreach ($allUsers as $user) {
            $userData[$user->id] = ['status' => '未提出'];
        }

        $manager->users()->attach($userData);

        if ($manager->ReceptionStatus === '受付中') {
            $formatMessage =
                $this->startDate . ' から ' . $this->endDate . ' のシフト提出が開始されました。' . "\n" .
                '提出締め切りは ' . $this->submissionEndDate . ' です。';
            $url = route('shift.submission.show', ['manager' => $manager->id]);

            foreach ($allUsers as $user) {
                $user->notify(
                    new WebPushNotification(
                        title: 'エルフルサービス',
                        message : $formatMessage,
                        image: '',
                        url: $url,
                    ));
            }
        }

        $this->reset(['startDate', 'endDate', 'submissionStartDate', 'submissionEndDate']);
    }

    public function update()
    {
        $this->validate();

        $this->manager->update([
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'submission_start_date' => $this->submissionStartDate,
            'submission_end_date' => $this->submissionEndDate,
        ]);

        $this->reset(['startDate', 'endDate', 'submissionStartDate', 'submissionEndDate']);
    }

    // public function delete(): void
    // {
    //     $this->schedule->delete();
    // }
}

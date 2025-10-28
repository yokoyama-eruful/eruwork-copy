<?php

declare(strict_types=1);

namespace Modules\Shift\Livewire\General;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Shift\Models\Pattern;

class PatternCreateModal extends Component
{
    public $startTime1;

    public $startTime2;

    public $startTime3;

    public $endTime1;

    public $endTime2;

    public $endTime3;

    public $pattern1;

    public $pattern2;

    public $pattern3;

    public function mount()
    {
        $this->setPattern();
    }

    public function settingReset()
    {
        $this->startTime1 = null;
        $this->startTime2 = null;
        $this->startTime3 = null;
        $this->endTime1 = null;
        $this->endTime2 = null;
        $this->endTime3 = null;
    }

    public function setPattern()
    {
        $patterns = Auth::user()->patterns->sortBy('title');

        foreach ($patterns as $pattern) {
            switch ($pattern->title) {
                case 1:
                    $this->pattern1 = $pattern->id;
                    $this->startTime1 = $pattern->start_time?->format('H:i');
                    $this->endTime1 = $pattern->end_time?->format('H:i');
                    break;

                case 2:
                    $this->pattern2 = $pattern->id;
                    $this->startTime2 = $pattern->start_time?->format('H:i');
                    $this->endTime2 = $pattern->end_time?->format('H:i');
                    break;

                case 3:
                    $this->pattern3 = $pattern->id;
                    $this->startTime3 = $pattern->start_time?->format('H:i');
                    $this->endTime3 = $pattern->end_time?->format('H:i');
                    break;
            }
        }
    }

    public function save()
    {
        $this->validate([
            'startTime1' => 'nullable|required_with:endTime1',
            'endTime1' => 'nullable|required_with:startTime1',

            'startTime2' => 'nullable|required_with:endTime2',
            'endTime2' => 'nullable|required_with:startTime2',

            'startTime3' => 'nullable|required_with:endTime3',
            'endTime3' => 'nullable|required_with:startTime3',
        ], [
            'startTime1.required_with' => 'パターン1の開始時間を入力してください',
            'endTime1.required_with' => 'パターン1の終了時間を入力してください',

            'startTime2.required_with' => 'パターン2の開始時間を入力してください',
            'endTime2.required_with' => 'パターン2の終了時間を入力してください',

            'startTime3.required_with' => 'パターン3の開始時間を入力してください',
            'endTime3.required_with' => 'パターン3の終了時間を入力してください',
        ]);

        $patterns = [
            ['id' => $this->pattern1, 'start' => $this->startTime1, 'end' => $this->endTime1, 'title' => 1],
            ['id' => $this->pattern2, 'start' => $this->startTime2, 'end' => $this->endTime2, 'title' => 2],
            ['id' => $this->pattern3, 'start' => $this->startTime3, 'end' => $this->endTime3, 'title' => 3],
        ];

        foreach ($patterns as $data) {
            if (! is_null($data['id'])) {
                Pattern::find($data['id'])->update([
                    'start_time' => $data['start'],
                    'end_time' => $data['end'],
                    'title' => $data['title'],
                ]);
            } else {
                Pattern::create([
                    'user_id' => Auth::id(),
                    'start_time' => $data['start'],
                    'end_time' => $data['end'],
                    'title' => $data['title'],
                ]);
            }
        }

        $this->setPattern();
        $this->dispatch('close-modal', 'pattern-create-modal');
    }

    public function render()
    {
        return view('shift::general.livewire.pattern-create-modal');
    }
}

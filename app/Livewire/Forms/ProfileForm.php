<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Form;
use Livewire\WithFileUploads;
use Modules\Account\Models\Profile;

class ProfileForm extends Form
{
    use WithFileUploads;

    public $currentPassword;

    public $newPassword;

    public $newPasswordConfirmation;

    public $notifyMessage;

    public $icon;

    public ?User $user;

    public function setValue($user)
    {
        $this->user = $user;
        $this->notifyMessage = $user->notify_message;
    }

    public function update()
    {
        $user = Auth::user();

        $values = [];

        if ($this->currentPassword || $this->newPassword || $this->newPasswordConfirmation) {
            if (! Hash::check($this->currentPassword, $user->password)) {
                $this->addError('currentPassword', '現在のパスワードが違います');

                return;
            }

            if ($this->newPassword != $this->newPasswordConfirmation) {
                $this->addError('currentPassword', '新しいパスワードと確認用パスワードが一致しません');

                return;
            }

            $values['password'] = Hash::make($this->newPassword);
        }

        $values['notify_message'] = $this->notifyMessage;

        $this->user->update($values);

        if ($this->icon) {
            $iconPath = $this->icon->store('profile/' . $user->id);
            $user = Profile::where('user_id', $this->user->id)->first();
            $user->update(['icon' => $iconPath]);
        }

        $this->reset(['currentPassword', 'newPassword', 'newPasswordConfirmation', 'icon']);
    }
}

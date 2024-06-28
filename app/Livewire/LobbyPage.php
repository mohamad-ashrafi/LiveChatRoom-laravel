<?php

namespace App\Livewire;

use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('چت روم آنلاین تکومیکس')]
class LobbyPage extends Component
{
    /**
     * Get the system messages.
     *
     * @return array
     */
    #[Computed]
    public function systemMessages(): array
    {
        return [
            'سلام ، به چت روم آنلاین تکومیکس خوش اومدید 😍',
        ];
    }
}

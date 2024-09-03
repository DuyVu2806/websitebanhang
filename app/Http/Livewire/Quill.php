<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Quill extends Component
{
    const EVENT_VALUE_UPDATED = 'quill_value_updated';

    public $value;
    
    public $quillId;

    public $quillStyles;

    public function mount($value = '', $quillStyles = [])
    {
        $this->value = $value;
        $this->quillId = 'quill-' . uniqid();
        $this->quillStyles = $quillStyles;
    }

    public function updatedValue($value) {
        $this->emit(self::EVENT_VALUE_UPDATED, $this->value);
    }
    public function render()
    {
        return view('livewire.quill');
    }
}

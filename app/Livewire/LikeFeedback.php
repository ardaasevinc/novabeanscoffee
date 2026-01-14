<?php


namespace App\Livewire;

use App\Models\Like;
use Livewire\Component;

class LikeFeedback extends Component
{
    public $is_liked = null;
    public $user_name;
    public $user_comment;
    public $showForm = false;
    public $submitted = false;

    protected $rules = [
        'user_name' => 'required|min:2',
        'user_comment' => 'nullable|min:5',
    ];

    public function setLike($status)
    {
        $this->is_liked = $status;
        $this->showForm = true;
    }

    public function submit()
    {
        $this->validate();

        Like::create([
            'is_liked' => $this->is_liked,
            'user_name' => $this->user_name,
            'user_comment' => $this->user_comment,
            'is_published' => false, // Filament panelinden onaylanana kadar gizli kalır
            'ip_address' => request()->ip(),
        ]);

        $this->submitted = true;
        $this->showForm = false;
    }

    public function render()
    {
        return view('livewire.like-feedback');
    }

    public function submitFeedback()
{
    if ($this->is_liked === true) {
        $this->validate(['user_name' => 'required|min:2']);
    }

    Like::create([
        'is_liked' => $this->is_liked,
        'user_name' => $this->user_name ?? 'Ziyaretçi',
        'user_comment' => $this->user_comment,
        'is_published' => false,
        'ip_address' => request()->ip(),
    ]);

    $this->submitted = true;
    $this->showForm = false;
}
}
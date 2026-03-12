<?php
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    public function deleteUser(int $id): void
    {
        User::findOrFail($id)->delete();
    }

    public function with(): array
    {
        return [
            'users' => User::where('name', 'like', "%{$this->search}%")
                ->paginate(10),
        ];
    }

};
?>

<div>
    <input wire:model.live="search" placeholder="Buscar..." />

    @foreach ($users as $user)
        <div>
            {{ $user->name }} — {{ $user->email }}
            <button wire:click="deleteUser({{ $user->id }})" wire:confirm="¿Eliminar?">
                Eliminar
            </button>
        </div>
    @endforeach

    {{ $users->links() }}
</div>
@props(['action', 'confirm'])

<form method="POST" action="{{ $action }}" data-confirm="{{ $confirm }}">
    @csrf
    @method('DELETE')
    <x-admin.button variant="danger">Sil</x-admin.button>
</form>

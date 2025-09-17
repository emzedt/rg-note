<x-mail::message>
    # Halo!

    Anda telah diundang oleh **{{ $inviter->name }}** untuk berkolaborasi pada catatan berjudul
    **"{{ $note->title }}"**.

    Anda diberi akses sebagai **{{ $role }}**.

    <x-mail::button :url="route('notes.show', $note)">
        Lihat Catatan
    </x-mail::button>

    Terima kasih,<br>
    {{ config('app.name') }}
</x-mail::message>

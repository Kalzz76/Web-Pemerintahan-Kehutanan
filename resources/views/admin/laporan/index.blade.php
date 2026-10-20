@extends('layouts.admin')

@section('title', 'Kelola Laporan Darurat')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
    <div>
        <h1 class="text-lg md:text-xl font-bold text-stone-900 tracking-tight">Kelola Laporan Darurat</h1>
        <p class="text-stone-500 text-xs mt-0.5">Verifikasi laporan darurat warga desa, tentukan kawasan, dan berikan catatan tindak lanjut.</p>
    </div>
</div>

<livewire:admin.laporan-table />
@endsection

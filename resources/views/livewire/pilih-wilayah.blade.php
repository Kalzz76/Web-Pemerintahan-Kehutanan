<div class="bg-white p-3.5 rounded-2xl border border-stone-200 shadow-sm flex flex-col sm:flex-row items-stretch sm:items-center gap-3 text-xs">
    <div class="flex items-center gap-2 text-stone-700 font-bold uppercase tracking-wider text-[11px] shrink-0">
        <i class="fa-solid fa-location-dot text-green-700 text-sm"></i>
        <span>Pilih Wilayah:</span>
    </div>

    <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-2">
        <select wire:model.live="idKabupatenKota" class="w-full px-3 py-2 rounded-xl border border-stone-200 text-xs text-stone-700 bg-white focus:outline-none focus:border-stone-900 transition">
            <option value="">Semua Kabupaten/Kota</option>
            @foreach ($daftarKabupaten as $kab)
                <option value="{{ $kab->id }}">{{ $kab->nama }}</option>
            @endforeach
        </select>

        <select wire:model.live="idKawasan" class="w-full px-3 py-2 rounded-xl border border-stone-200 text-xs text-stone-700 bg-white focus:outline-none focus:border-stone-900 transition">
            <option value="">-- Pilih Kawasan Hutan --</option>
            @foreach ($daftarKawasan as $kws)
                <option value="{{ $kws->id }}">{{ $kws->nama }}</option>
            @endforeach
        </select>
    </div>

    @if (!empty($idKabupatenKota) || !empty($idKawasan))
        <button type="button" wire:click="resetPilihan" class="px-3 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 border border-stone-300 font-semibold rounded-xl text-xs transition text-center shrink-0">
            Reset
        </button>
    @endif
</div>

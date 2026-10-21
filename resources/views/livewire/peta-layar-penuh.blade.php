<div class="{{ $layarPenuh ? 'fixed inset-0 z-[9999] bg-white wadah-peta-fullscreen' : 'relative w-full' }}" style="{{ $layarPenuh ? 'height: 100vh; width: 100vw;' : 'height: ' . $tinggi . ';' }}">
    <div class="absolute top-3 right-3 z-[10000]">
        <button type="button" wire:click="toggleLayarPenuh" class="tombol-layar-penuh-peta inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/95 hover:bg-white text-stone-800 rounded-xl shadow border border-stone-200 text-xs font-semibold backdrop-blur transition active:scale-95">
            <i class="fa-solid {{ $layarPenuh ? 'fa-compress' : 'fa-expand' }} text-stone-600"></i>
            <span>{{ $layarPenuh ? 'Perkecil' : 'Layar Penuh' }}</span>
        </button>
    </div>
    <div id="{{ $idPeta }}" wire:ignore class="w-full h-full" style="height: 100% !important; width: 100% !important;"></div>
</div>

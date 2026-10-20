@if (session('sukses') || session('info') || session('error'))
<div id="modal-pesan" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-stone-950/50 backdrop-blur-xs transition-opacity duration-200">
    <div class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-2xl border border-stone-200/80 text-center transform transition-all duration-200">
        <div class="w-12 h-12 rounded-2xl bg-stone-100 text-stone-800 flex items-center justify-center mx-auto mb-4 text-base">
            @if (session('sukses'))
                <i class="fa-solid fa-circle-check"></i>
            @elseif (session('error'))
                <i class="fa-solid fa-triangle-exclamation"></i>
            @else
                <i class="fa-solid fa-circle-info"></i>
            @endif
        </div>

        @if (session('sukses'))
            <h3 class="text-base font-bold text-stone-900 mb-1.5">Berhasil</h3>
            <p class="text-stone-500 text-xs leading-relaxed mb-6">{{ session('sukses') }}</p>
        @elseif (session('error'))
            <h3 class="text-base font-bold text-stone-900 mb-1.5">Terjadi Kesalahan</h3>
            <p class="text-stone-500 text-xs leading-relaxed mb-6">{{ session('error') }}</p>
        @else
            <h3 class="text-base font-bold text-stone-900 mb-1.5">Informasi</h3>
            <p class="text-stone-500 text-xs leading-relaxed mb-6">{{ session('info') }}</p>
        @endif

        <button type="button" onclick="tutupModalPesan()" class="w-full py-2.5 px-4 rounded-xl bg-stone-900 hover:bg-stone-800 text-white text-xs font-semibold transition cursor-pointer shadow-xs">
            Mengerti
        </button>
    </div>
</div>

<script>
function tutupModalPesan() {
    var modal = document.getElementById('modal-pesan');
    if (modal) {
        modal.classList.add('hidden');
    }
}

document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('modal-pesan');
    if (modal) {
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                tutupModalPesan();
            }
        });
    }
});
</script>
@endif

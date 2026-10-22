@if (session('sukses') || session('info') || session('error'))
<div id="modal-pesan" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-stone-950/70 backdrop-blur-sm transition-opacity duration-200">
    <div class="bg-white rounded-3xl p-6 sm:p-7 max-w-sm w-full shadow-2xl border border-stone-200/90 text-center transform transition-all duration-200">
        <div id="modal-pesan-icon-wrapper" class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-4 text-xl shadow-xs border transition-colors
            @if (session('sukses')) bg-emerald-50 text-emerald-600 border-emerald-200/60
            @elseif (session('error')) bg-rose-50 text-rose-600 border-rose-200/60
            @else bg-sky-50 text-sky-600 border-sky-200/60 @endif">
            @if (session('sukses'))
                <i class="fa-solid fa-circle-check"></i>
            @elseif (session('error'))
                <i class="fa-solid fa-triangle-exclamation"></i>
            @else
                <i class="fa-solid fa-circle-info"></i>
            @endif
        </div>

        @if (session('sukses'))
            <h3 class="text-base sm:text-lg font-bold text-stone-900 mb-1.5 tracking-tight">Berhasil</h3>
            <p class="text-stone-500 text-xs sm:text-sm leading-relaxed mb-6">{{ session('sukses') }}</p>
        @elseif (session('error'))
            <h3 class="text-base sm:text-lg font-bold text-stone-900 mb-1.5 tracking-tight">Terjadi Kesalahan</h3>
            <p class="text-stone-500 text-xs sm:text-sm leading-relaxed mb-6">{{ session('error') }}</p>
        @else
            <h3 class="text-base sm:text-lg font-bold text-stone-900 mb-1.5 tracking-tight">Informasi</h3>
            <p class="text-stone-500 text-xs sm:text-sm leading-relaxed mb-6">{{ session('info') }}</p>
        @endif

        <button type="button" id="modal-pesan-btn" onclick="tutupModalPesan()" class="w-full py-2.5 px-4 rounded-xl text-white text-xs sm:text-sm font-semibold transition cursor-pointer shadow-md
            @if (session('error')) bg-rose-600 hover:bg-rose-500 shadow-rose-950/20
            @elseif (session('sukses')) bg-emerald-700 hover:bg-emerald-600 shadow-emerald-950/20
            @else bg-emerald-700 hover:bg-emerald-600 shadow-emerald-950/20 @endif">
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

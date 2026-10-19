@if (session('sukses') || session('info') || session('error'))
<div id="modal-pesan" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-stone-950/60 backdrop-blur-sm">
    <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl text-center transform transition-all">
        @if (session('sukses'))
            <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <h3 class="text-xl font-bold text-stone-900 mb-2">Berhasil</h3>
            <p class="text-stone-600 text-sm mb-6">{{ session('sukses') }}</p>
        @elseif (session('error'))
            <div class="w-16 h-16 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <h3 class="text-xl font-bold text-stone-900 mb-2">Terjadi Kesalahan</h3>
            <p class="text-stone-600 text-sm mb-6">{{ session('error') }}</p>
        @else
            <div class="w-16 h-16 bg-sky-100 text-sky-600 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl">
                <i class="fa-solid fa-circle-info"></i>
            </div>
            <h3 class="text-xl font-bold text-stone-900 mb-2">Informasi</h3>
            <p class="text-stone-600 text-sm mb-6">{{ session('info') }}</p>
        @endif

        <button type="button" onclick="tutupModalPesan()" class="w-full py-3 px-6 bg-green-700 hover:bg-green-600 text-white font-semibold rounded-xl transition">
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
</script>
@endif

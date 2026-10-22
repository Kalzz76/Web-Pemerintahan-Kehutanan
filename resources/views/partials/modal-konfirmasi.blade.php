<div id="modal-konfirmasi" class="fixed inset-0 z-[99999] hidden items-center justify-center p-4 bg-stone-950/70 backdrop-blur-sm transition-opacity duration-200">
    <div class="bg-white rounded-3xl p-6 sm:p-7 max-w-sm w-full shadow-2xl border border-stone-200/90 text-center transform transition-all scale-95 opacity-0 duration-200" id="modal-konfirmasi-box">
        <div id="modal-konfirmasi-icon-wrapper" class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mx-auto mb-4 text-xl shadow-xs border border-amber-200/60 transition-colors">
            <i id="modal-konfirmasi-icon" class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <h3 id="modal-konfirmasi-title" class="text-base sm:text-lg font-bold text-stone-900 mb-1.5 tracking-tight">Konfirmasi Tindakan</h3>
        <p id="modal-konfirmasi-message" class="text-stone-500 text-xs sm:text-sm leading-relaxed mb-6">Apakah Anda yakin ingin melanjutkan tindakan ini?</p>

        <div class="flex items-center gap-3">
            <button type="button" id="modal-konfirmasi-batal" onclick="tutupModalKonfirmasi()" class="flex-1 py-2.5 px-4 rounded-xl border border-stone-200 bg-stone-100 hover:bg-stone-200 text-stone-700 text-xs sm:text-sm font-semibold transition cursor-pointer shadow-xs">
                Batal
            </button>
            <button type="button" id="modal-konfirmasi-ok" class="flex-1 py-2.5 px-4 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs sm:text-sm font-semibold transition cursor-pointer shadow-md shadow-rose-950/20">
                Ya, Lanjutkan
            </button>
        </div>
    </div>
</div>

<script>
let targetFormKonfirmasi = null;
let callbackKonfirmasi = null;

function bukaModalKonfirmasi(options = {}) {
    const modal = document.getElementById('modal-konfirmasi');
    const box = document.getElementById('modal-konfirmasi-box');
    const titleEl = document.getElementById('modal-konfirmasi-title');
    const msgEl = document.getElementById('modal-konfirmasi-message');
    const iconEl = document.getElementById('modal-konfirmasi-icon');
    const iconWrapper = document.getElementById('modal-konfirmasi-icon-wrapper');
    const btnOk = document.getElementById('modal-konfirmasi-ok');

    if (!modal || !box) return;

    const judul = options.judul || 'Konfirmasi Tindakan';
    const pesan = options.pesan || 'Apakah Anda yakin ingin melanjutkan tindakan ini?';
    const teksOk = options.teksOk || 'Ya, Lanjutkan';

    titleEl.textContent = judul;
    msgEl.textContent = pesan;
    btnOk.textContent = teksOk;

    // Deteksi aksi berbahaya (Hapus / Keluar / Danger)
    const isDanger = (options.tipe === 'danger') ||
                     (teksOk && (teksOk.toLowerCase().includes('hapus') || teksOk.toLowerCase().includes('keluar'))) ||
                     (judul && (judul.toLowerCase().includes('hapus') || judul.toLowerCase().includes('keluar')));

    if (isDanger) {
        btnOk.className = "flex-1 py-2.5 px-4 rounded-xl bg-rose-600 hover:bg-rose-500 text-white text-xs sm:text-sm font-semibold transition cursor-pointer shadow-md shadow-rose-950/30";
        if (iconWrapper) {
            iconWrapper.className = "w-14 h-14 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center mx-auto mb-4 text-xl shadow-xs border border-rose-200/60 transition-colors";
        }
        btnOk.classList.remove('btn-konfirmasi-primer');
    } else {
        btnOk.className = "flex-1 py-2.5 px-4 rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white text-xs sm:text-sm font-semibold transition cursor-pointer shadow-md shadow-emerald-950/30 btn-konfirmasi-primer";
        if (iconWrapper) {
            iconWrapper.className = "w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mx-auto mb-4 text-xl shadow-xs border border-amber-200/60 transition-colors";
        }
    }

    if (options.icon) {
        iconEl.className = options.icon;
    } else {
        iconEl.className = isDanger ? 'fa-solid fa-triangle-exclamation' : 'fa-solid fa-circle-question';
    }

    targetFormKonfirmasi = options.form || null;
    callbackKonfirmasi = options.onConfirm || null;

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => {
        box.classList.remove('scale-95', 'opacity-0');
        box.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function tutupModalKonfirmasi() {
    const modal = document.getElementById('modal-konfirmasi');
    const box = document.getElementById('modal-konfirmasi-box');
    if (!modal || !box) return;

    box.classList.remove('scale-100', 'opacity-100');
    box.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        targetFormKonfirmasi = null;
        callbackKonfirmasi = null;
    }, 150);
}

document.addEventListener('DOMContentLoaded', function () {
    const btnOk = document.getElementById('modal-konfirmasi-ok');
    if (btnOk) {
        btnOk.addEventListener('click', function () {
            if (callbackKonfirmasi) {
                const cb = callbackKonfirmasi;
                tutupModalKonfirmasi();
                cb();
            } else if (targetFormKonfirmasi) {
                const f = targetFormKonfirmasi;
                tutupModalKonfirmasi();
                f.submit();
            } else {
                tutupModalKonfirmasi();
            }
        });
    }

    document.addEventListener('submit', function (e) {
        const form = e.target;
        if (form && form.hasAttribute('data-confirm')) {
            if (form.checkValidity && !form.checkValidity()) {
                form.reportValidity();
                return;
            }
            e.preventDefault();
            const pesan = form.getAttribute('data-confirm');
            const judul = form.getAttribute('data-confirm-title') || 'Konfirmasi';
            const teksOk = form.getAttribute('data-confirm-ok') || 'Ya, Lanjutkan';
            const icon = form.getAttribute('data-confirm-icon') || 'fa-solid fa-triangle-exclamation';
            bukaModalKonfirmasi({
                judul: judul,
                pesan: pesan,
                teksOk: teksOk,
                icon: icon,
                form: form
            });
        }
    });

    const modalBackdrop = document.getElementById('modal-konfirmasi');
    if (modalBackdrop) {
        modalBackdrop.addEventListener('click', function (e) {
            if (e.target === modalBackdrop) {
                tutupModalKonfirmasi();
            }
        });
    }
});
</script>

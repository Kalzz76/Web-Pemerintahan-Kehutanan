<div id="modal-konfirmasi" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-stone-950/50 backdrop-blur-xs transition-opacity duration-200">
    <div class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-2xl border border-stone-200/80 text-center transform transition-all scale-95 opacity-0 duration-200" id="modal-konfirmasi-box">
        <div class="w-12 h-12 rounded-2xl bg-stone-100 text-stone-800 flex items-center justify-center mx-auto mb-4 text-base">
            <i id="modal-konfirmasi-icon" class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <h3 id="modal-konfirmasi-title" class="text-base font-bold text-stone-900 mb-1.5">Konfirmasi Tindakan</h3>
        <p id="modal-konfirmasi-message" class="text-stone-500 text-xs leading-relaxed mb-6">Apakah Anda yakin ingin melanjutkan tindakan ini?</p>

        <div class="flex items-center gap-2.5">
            <button type="button" onclick="tutupModalKonfirmasi()" class="flex-1 py-2.5 px-4 rounded-xl border border-stone-200 bg-white hover:bg-stone-100 text-stone-700 text-xs font-semibold transition cursor-pointer">
                Batal
            </button>
            <button type="button" id="modal-konfirmasi-ok" class="flex-1 py-2.5 px-4 rounded-xl bg-stone-900 hover:bg-stone-800 text-white text-xs font-semibold transition cursor-pointer shadow-xs">
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
    const btnOk = document.getElementById('modal-konfirmasi-ok');

    if (!modal || !box) return;

    titleEl.textContent = options.judul || 'Konfirmasi Tindakan';
    msgEl.textContent = options.pesan || 'Apakah Anda yakin ingin melanjutkan tindakan ini?';
    btnOk.textContent = options.teksOk || 'Ya, Lanjutkan';

    if (options.icon) {
        iconEl.className = options.icon;
    } else {
        iconEl.className = 'fa-solid fa-triangle-exclamation';
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

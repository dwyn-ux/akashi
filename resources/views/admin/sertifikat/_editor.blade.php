@php
$editorId = $editorId ?? 'cert';
$inputName = $inputName ?? 'certificate_layout';
$layoutRaw = $layout ?? '{}';
$templateUrl = $templateUrl ?? null;
$sample = $sample ?? ['title' => 'Sertifikat Penghargaan', 'name' => 'Ahmad Fauzi', 'body' => 'Diberikan dengan bangga kepada Ahmad Fauzi atas partisipasi pada lomba Olimpiade IPAS (Akademik)', 'meta' => 'AKS-2026-00001'];
$defaults = ['title' => ['x' => 50, 'y' => 20, 'size' => 38, 'align' => 'center', 'color' => '#14253D', 'visible' => true], 'name' => ['x' => 50, 'y' => 46, 'size' => 30, 'align' => 'center', 'color' => '#5B2BE0', 'visible' => true], 'body' => ['x' => 50, 'y' => 60, 'size' => 13, 'align' => 'center', 'color' => '#4B5563', 'visible' => true], 'meta' => ['x' => 50, 'y' => 88, 'size' => 10, 'align' => 'center', 'color' => '#9CA3AF', 'visible' => true]];
@endphp
<div class="cert-editor border border-gray-200 rounded-xl overflow-hidden" id="cert-editor-{{ $editorId }}"
     data-layout='{!! e($layoutRaw ?: "{}") !!}' data-defaults='{!! e(json_encode($defaults)) !!}' data-sample='{!! e(json_encode($sample)) !!}'>
    <div class="cert-canvas relative w-full select-none bg-gray-100" style="aspect-ratio: 297/210; touch-action: none; background-size: cover; background-position: center; {{ $templateUrl ? "background-image: url(\"{$templateUrl}\");" : '' }}">
        @if(! $templateUrl)
            <div class="cert-nobg absolute inset-0 flex items-center justify-center text-xs text-gray-400 pointer-events-none">Upload background untuk melihat template</div>
        @endif
    </div>
    <input type="hidden" name="{{ $inputName }}" value="{{ $layoutRaw }}">
    <div class="p-4 bg-gray-50 border-t border-gray-200 space-y-3">
        <div class="cert-fields flex flex-wrap gap-2"></div>
        <div class="cert-controls grid grid-cols-2 sm:grid-cols-4 gap-3 items-end">
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Ukuran</label>
                <input type="number" class="cert-size w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm" min="6" max="80">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Warna</label>
                <input type="color" class="cert-color w-10 h-9 rounded border border-gray-300 cursor-pointer">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Rata</label>
                <select class="cert-align w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm">
                    <option value="left">Kiri</option>
                    <option value="center">Tengah</option>
                    <option value="right">Kanan</option>
                </select>
            </div>
            <div class="flex items-center gap-2">
                <label class="text-xs font-medium text-gray-600 inline-flex items-center gap-1"><input type="checkbox" class="cert-visible rounded"> Tampil</label>
                <button type="button" class="cert-reset text-xs text-primary font-semibold hover:underline ml-auto">Reset</button>
            </div>
        </div>
        <p class="text-[11px] text-gray-400">Geser teks langsung di atas background untuk mengatur posisi. Klik teks untuk memilih.</p>
    </div>
</div>
@if(empty($GLOBALS['__cert_editor_script']))
@php $GLOBALS['__cert_editor_script'] = true; @endphp
@push('scripts')
<script>
(function () {
    function alignShift(a) { return a === 'center' ? '-50%,-50%' : (a === 'right' ? '-100%,-50%' : '0,-50%'); }
    document.querySelectorAll('.cert-editor').forEach(function (root) {
        var canvas = root.querySelector('.cert-canvas');
        var hidden = root.querySelector('input[type=hidden]');
        var fieldsBar = root.querySelector('.cert-fields');
        var sizeIn = root.querySelector('.cert-size'), colorIn = root.querySelector('.cert-color'),
            alignIn = root.querySelector('.cert-align'), visIn = root.querySelector('.cert-visible');
        var sample = JSON.parse(root.dataset.sample || '{}');
        var layout = {};
        try { layout = JSON.parse(hidden.value || root.dataset.layout || '{}'); } catch (e) { layout = {}; }
        var defs = JSON.parse(root.dataset.defaults || '{}');
        Object.keys(defs).forEach(function (k) { if (!layout[k]) layout[k] = Object.assign({}, defs[k]); });
        var selected = 'name';
        var labels = { title: 'Judul', name: 'Nama', body: 'Isi', meta: 'Nomor' };
        function textFor(k) { return sample[k] || k; }
        function save() { hidden.value = JSON.stringify(layout); }
        function render() {
            canvas.querySelectorAll('.cert-box').forEach(function (b) { b.remove(); });
            Object.keys(layout).forEach(function (k) {
                var f = layout[k];
                var el = document.createElement('div');
                el.className = 'cert-box';
                el.dataset.key = k;
                el.textContent = textFor(k);
                el.style.cssText = 'position:absolute;left:' + f.x + '%;top:' + f.y + '%;transform:translate(' + alignShift(f.align) + ');font-size:' + (f.size * canvas.clientWidth / 900) + 'px;font-weight:' + (k === 'name' || k === 'title' ? 'bold' : 'normal') + ';color:' + f.color + ';text-align:' + f.align + ';max-width:90%;cursor:move;padding:2px 6px;border-radius:6px;' + (f.visible === false ? 'opacity:.25;' : '') + (k === selected ? 'outline:2px dashed #5B2BE0;background:rgba(91,43,224,.08);' : '');
                canvas.appendChild(el);
                bindDrag(el, k);
            });
            renderBar(); syncControls(); save();
        }
        function renderBar() {
            fieldsBar.innerHTML = '';
            Object.keys(layout).forEach(function (k) {
                var b = document.createElement('button');
                b.type = 'button';
                b.textContent = (layout[k].visible === false ? '🚫 ' : '') + (labels[k] || k);
                b.className = 'px-3 py-1.5 rounded-lg text-xs font-semibold ' + (k === selected ? 'bg-primary text-white' : 'bg-white border border-gray-300 text-gray-600');
                b.onclick = function () { selected = k; render(); };
                fieldsBar.appendChild(b);
            });
        }
        function syncControls() {
            var f = layout[selected];
            if (!f) return;
            sizeIn.value = f.size; colorIn.value = /^#[0-9a-fA-F]{6}$/.test(f.color || '') ? f.color : '#14253D';
            alignIn.value = f.align || 'center'; visIn.checked = f.visible !== false;
        }
        function bindDrag(el, k) {
            el.addEventListener('pointerdown', function (e) {
                selected = k; render();
                var box = canvas.querySelector('.cert-box[data-key="' + k + '"]');
                var r = canvas.getBoundingClientRect();
                function move(ev) {
                    var x = Math.min(100, Math.max(0, (ev.clientX - r.left) / r.width * 100));
                    var y = Math.min(100, Math.max(0, (ev.clientY - r.top) / r.height * 100));
                    layout[k].x = Math.round(x * 10) / 10; layout[k].y = Math.round(y * 10) / 10;
                    box.style.left = layout[k].x + '%'; box.style.top = layout[k].y + '%';
                }
                function up() { document.removeEventListener('pointermove', move); document.removeEventListener('pointerup', up); save(); }
                document.addEventListener('pointermove', move); document.addEventListener('pointerup', up);
                e.preventDefault();
            });
        }
        sizeIn.addEventListener('input', function () { layout[selected].size = Math.max(6, Math.min(80, +sizeIn.value || 13)); render(); });
        colorIn.addEventListener('input', function () { layout[selected].color = colorIn.value; render(); });
        alignIn.addEventListener('change', function () { layout[selected].align = alignIn.value; render(); });
        visIn.addEventListener('change', function () { layout[selected].visible = visIn.checked; render(); });
        root.querySelector('.cert-reset').addEventListener('click', function () { layout = JSON.parse(JSON.stringify(defs)); selected = 'name'; render(); });
        window.addEventListener('resize', function () { render(); });
        render();
    });
    document.querySelectorAll('input[data-cert-preview]').forEach(function (inp) {
        inp.addEventListener('change', function () {
            var ed = document.getElementById('cert-editor-' + inp.dataset.certPreview);
            if (ed && inp.files && inp.files[0]) {
                var cv = ed.querySelector('.cert-canvas');
                cv.style.backgroundImage = 'url(' + URL.createObjectURL(inp.files[0]) + ')';
                var nb = cv.querySelector('.cert-nobg'); if (nb) nb.remove();
            }
        });
    });
})();
</script>
@endpush
@endif

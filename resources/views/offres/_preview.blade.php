{{-- Aperçu en direct de la carte d'offre, alimenté par les champs data-preview du formulaire --}}
<aside class="ir-side">
    <div class="ir-side-card">
        <h3>Aperçu pour les candidats</h3>
        <div class="ir-prev">
            <div class="ir-prev-top">
                <span class="ir-prev-logo" data-out="initiale">?</span>
                <span class="ir-prev-chip" data-out="type">Contrat</span>
            </div>
            <strong data-out="titre">Titre du poste</strong>
            <p data-out="description">La présentation du poste apparaîtra ici.</p>
            <div class="ir-prev-meta">
                <span><i class="bi bi-geo-alt"></i> <span data-out="lieu">Lieu</span></span>
                <span><i class="bi bi-calendar-event"></i> <span data-out="limite">Date limite</span></span>
            </div>
        </div>
    </div>
    <div class="ir-side-card ir-side-dark">
        <h3>Conseils</h3>
        <ul>
            <li>Un titre précis (« Développeur Laravel ») attire mieux qu'un titre vague (« Informaticien »).</li>
            <li>Listez les technologies dans « Compétences » : les candidats les cherchent en priorité.</li>
            <li>Laissez au moins deux semaines avant la date limite.</li>
        </ul>
    </div>
</aside>

@push('styles')
<style>
    .ir-prev { border: 1px solid var(--ir-line); border-radius: 16px; padding: 1.2rem; display: grid; gap: .5rem; }
    .ir-prev-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: .4rem; }
    .ir-prev-logo { width: 42px; height: 42px; border-radius: 11px; display: grid; place-items: center; color: #fff; font-weight: 800; background: linear-gradient(135deg, var(--ir-sky), var(--ir-blue)); }
    .ir-prev-chip { font-size: .75rem; font-weight: 600; padding: .3rem .7rem; border-radius: 999px; background: #e3f8ee; color: #15803d; }
    .ir-prev strong { color: var(--ir-ink); font-size: 1.02rem; word-break: break-word; }
    .ir-prev p { color: var(--ir-muted); font-size: .86rem; margin: 0; word-break: break-word; }
    .ir-prev-meta { display: flex; gap: .9rem; flex-wrap: wrap; font-size: .8rem; color: var(--ir-muted); padding-top: .7rem; margin-top: .3rem; border-top: 1px dashed var(--ir-line); }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const out = k => document.querySelector(`[data-out="${k}"]`);
    const defaults = { titre: 'Titre du poste', description: 'La présentation du poste apparaîtra ici.', lieu: 'Lieu', limite: 'Date limite', type: 'Contrat' };
    function render() {
        const titre = document.querySelector('[data-preview="titre"]').value.trim();
        const desc = document.querySelector('[data-preview="description"]').value.trim();
        const lieu = document.querySelector('[data-preview="lieu"]').value.trim();
        const limite = document.querySelector('[data-preview="limite"]').value;
        const type = document.querySelector('[data-preview="type"]:checked');
        out('titre').textContent = titre || defaults.titre;
        out('initiale').textContent = titre ? titre.charAt(0).toUpperCase() : '?';
        out('description').textContent = desc ? (desc.length > 95 ? desc.slice(0, 95) + '…' : desc) : defaults.description;
        out('lieu').textContent = lieu || defaults.lieu;
        out('limite').textContent = limite ? limite.split('-').reverse().join('/') : defaults.limite;
        out('type').textContent = type ? type.value : defaults.type;
    }
    document.querySelectorAll('[data-preview]').forEach(el => el.addEventListener('input', render));
    document.querySelectorAll('[data-preview="type"]').forEach(el => el.addEventListener('change', render));
    render();
});
</script>
@endpush

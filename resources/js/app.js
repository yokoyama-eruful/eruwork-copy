import "./bootstrap";
import flatpickr from 'flatpickr';
import { Japanese } from "flatpickr/dist/l10n/ja.js";

// グローバルに設定（必要に応じて）
window.Japanese = Japanese;

/* =========================
   flatpickr 初期化関数
   すでに対象となっている要素を二重に初期化しないよう
   :not(.flatpickr-input) セレクタを追加しています
========================= */
function initializeFlatpickr() {
    // 通常のデイトピッカー
    document.querySelectorAll('.js-datepicker:not(.flatpickr-input)').forEach(el => {
        flatpickr(el, {
            locale: { ...Japanese, firstDayOfWeek: 1 },
            dateFormat: 'Y-m-d',
            disableMobile: true,
        });
    });

    // 複数選択デイトピッカー
    document.querySelectorAll('.js-multiple-datepicker:not(.flatpickr-input)').forEach(el => {
        flatpickr(el, {
            locale: { ...Japanese, firstDayOfWeek: 1 },
            mode: "multiple",
            dateFormat: 'Y-m-d',
            disableMobile: true,
        });
    });

    // 範囲選択デイトピッカー
    document.querySelectorAll('.js-range-datepicker:not(.flatpickr-input)').forEach(el => {
        flatpickr(el, {
            locale: { ...Japanese, firstDayOfWeek: 1 },
            mode: "range",
            dateFormat: 'Y-m-d',
            disableMobile: true,
        });
    });
}

/* =========================
   Livewire 連携 (v3 対応)
========================= */
document.addEventListener('livewire:init', () => {
    // ページロード時の初回実行
    initializeFlatpickr();

    // Livewireのコンポーネントが更新（バリデーションエラー等）されるたびに再実行
    Livewire.hook('morph.updated', ({ el, component }) => {
        initializeFlatpickr();
    });

    // カスタムイベント経由での実行用（既存の互換性維持）
    Livewire.on('refreshFlatpickr', () => {
        initializeFlatpickr();
    });
});

/* =========================
   iOS対策 vh fix
========================= */
function setVh() {
    const vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty('--vh', `${vh}px`);
}

window.addEventListener('resize', setVh);
setVh();
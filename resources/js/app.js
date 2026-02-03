import "./bootstrap";
import flatpickr from 'flatpickr';
import { Japanese } from "flatpickr/dist/l10n/ja.js";

// グローバルに設定（必要に応じて）
window.Japanese = Japanese;

/* =========================
   flatpickr 初期化関数
   すでに対象となっている要素を二重に初期化しないよう
   :not(.flatpickr-input) セレクタを追加
========================= */
function initializeFlatpickr() {

    // 共通：modal 誤爆防止
    const stopPropagationOnCalendar = (instance) => {
        if (!instance?.calendarContainer) return;

        // Alpine / modal は mousedown で外クリック判定することが多い
        instance.calendarContainer.addEventListener('mousedown', (e) => {
            e.stopPropagation();
        });

        // 念のため click も止める（環境差対策）
        instance.calendarContainer.addEventListener('click', (e) => {
            e.stopPropagation();
        });
    };

    // 通常のデイトピッカー
    document.querySelectorAll('.js-datepicker:not(.flatpickr-input)').forEach(el => {
        flatpickr(el, {
            locale: { ...Japanese, firstDayOfWeek: 1 },
            dateFormat: 'Y-m-d',
            disableMobile: true,
            onReady: function (_, __, instance) {
                stopPropagationOnCalendar(instance);
            },
        });
    });

    // 複数選択デイトピッカー
    document.querySelectorAll('.js-multiple-datepicker:not(.flatpickr-input)').forEach(el => {
        flatpickr(el, {
            locale: { ...Japanese, firstDayOfWeek: 1 },
            mode: "multiple",
            dateFormat: 'Y-m-d',
            disableMobile: true,
            onReady: function (_, __, instance) {
                stopPropagationOnCalendar(instance);
            },
        });
    });

    // 範囲選択デイトピッカー
    document.querySelectorAll('.js-range-datepicker:not(.flatpickr-input)').forEach(el => {
        flatpickr(el, {
            locale: { ...Japanese, firstDayOfWeek: 1 },
            mode: "range",
            dateFormat: 'Y-m-d',
            disableMobile: true,
            onReady: function (_, __, instance) {
                stopPropagationOnCalendar(instance);
            },
        });
    });
}

/* =========================
   Livewire 連携 (v3 対応)
========================= */
document.addEventListener('livewire:init', () => {

    // 初回ロード
    initializeFlatpickr();

    // Livewire の DOM 差し替え後（バリデーション・更新時）
    Livewire.hook('morph.updated', () => {
        initializeFlatpickr();
    });

    // 明示的に再初期化したい場合用
    Livewire.on('refreshFlatpickr', () => {
        initializeFlatpickr();
    });
});

/* =========================
   iOS 対策 vh fix
========================= */
function setVh() {
    const vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty('--vh', `${vh}px`);
}

window.addEventListener('resize', setVh);
setVh();

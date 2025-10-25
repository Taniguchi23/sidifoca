import 'preline/dist/preline.js';
document.addEventListener('DOMContentLoaded', () => {
    if (window.HSStaticMethods && typeof window.HSStaticMethods.autoInit === 'function') {
        window.HSStaticMethods.autoInit();
    }
});

// Re-inicialización global: útil si usas AJAX o Livewire
window.reinitPreline = function (element = document) {
    if (window.HSStaticMethods && typeof window.HSStaticMethods.autoInit === 'function') {
        window.HSStaticMethods.autoInit(element);
        console.log('🔁 Preline re-inicializado en', element);
    }
};

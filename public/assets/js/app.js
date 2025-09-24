document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-confirm]').forEach(el => {
    el.addEventListener('click', evt => {
      if (!confirm(el.getAttribute('data-confirm'))) {
        evt.preventDefault();
      }
    });
  });
});

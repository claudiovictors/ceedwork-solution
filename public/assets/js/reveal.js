/* ==========================================================================
   public/js/reveal.js
   Anima elementos com [data-reveal] quando entram no ecrã.
   ========================================================================== */
(() => {
  const items = document.querySelectorAll('[data-reveal]');

  if (!('IntersectionObserver' in window)) {
    items.forEach(el => el.classList.add('is-visible'));
    return;
  }

  const io = new IntersectionObserver((entries, obs) => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      entry.target.classList.add('is-visible');
      obs.unobserve(entry.target); // anima só uma vez
    });
  }, { threshold: 0.15, rootMargin: '0px 0px -60px 0px' });

  items.forEach(el => io.observe(el));
})();
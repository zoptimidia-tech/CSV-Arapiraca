(() => {
  const form = document.querySelector('#lead-form');
  const csrfToken = document.querySelector('#csrf-token');
  const year = document.querySelector('#current-year');
  if (year) year.textContent = new Date().getFullYear();
  const loadCsrfToken = async () => {
    if (!csrfToken) return;
    try {
      const response = await fetch('csrf-token.php', { headers: { Accept: 'application/json' } });
      if (response.ok) csrfToken.value = (await response.json()).csrf_token || '';
    } catch (error) {
      csrfToken.value = '';
    }
  };
  loadCsrfToken();
  const phone = document.querySelector('#phone');
  const status = document.querySelector('.form-status');
  const courseLinks = document.querySelectorAll('[data-course]');
  const formatPhone = value => value.replace(/\D/g, '').slice(0, 11).replace(/^\(?([0-9]{2})\)?/, '($1) ').replace(/([0-9]{5})([0-9]{1,4})$/, '$1-$2').trim();
  phone?.addEventListener('input', e => { e.target.value = formatPhone(e.target.value); });
  courseLinks.forEach(link => link.addEventListener('click', () => { const select = document.querySelector('#course'); select.value = link.dataset.course; }));
  const setError = (field, message) => { const wrap = field.closest('.field'); wrap.classList.toggle('invalid', Boolean(message)); wrap.querySelector('.error-message').textContent = message || ''; };
  form?.addEventListener('submit', async event => {
    event.preventDefault(); status.textContent = ''; status.className = 'form-status';
    const name = form.elements.name, tel = form.elements.phone, course = form.elements.course;
    setError(name, name.value.trim().length < 3 ? 'Informe seu nome completo.' : '');
    setError(tel, tel.value.replace(/\D/g, '').length < 10 ? 'Informe um WhatsApp válido com DDD.' : '');
    setError(course, !course.value ? 'Selecione uma área de interesse.' : '');
    if (form.querySelector('.invalid')) return;
    const button = form.querySelector('button'); button.disabled = true; button.innerHTML = 'Enviando…';
    try {
      const response = await fetch(form.action, { method: 'POST', body: new FormData(form), headers: { Accept: 'application/json' } });
      const data = await response.json();
      if (!response.ok) throw new Error(data.message || 'Não foi possível enviar agora.');
      status.className = 'form-status success'; status.textContent = data.message;
      form.reset();
      if (data.whatsapp) setTimeout(() => window.open(data.whatsapp, '_blank', 'noopener'), 900);
    } catch (error) { status.className = 'form-status error'; status.textContent = error.message; }
    finally { button.disabled = false; button.innerHTML = 'Consultar cursos e condições <span>→</span>'; }
  });
})();

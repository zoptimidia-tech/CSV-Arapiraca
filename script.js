(() => {
  const formulario = document.querySelector('#lead-form');
const statusFormulario = document.querySelector('#form-status');

if (formulario) {
  formulario.addEventListener('submit', async function (event) {
    event.preventDefault();

    const botao = formulario.querySelector('button[type="submit"]');
    const dados = new FormData(formulario);
    const payload = Object.fromEntries(dados.entries());

    botao.disabled = true;
    botao.textContent = 'Enviando...';

    statusFormulario.textContent = '';
    statusFormulario.className = '';

    try {
      const resposta = await fetch('/api/lead', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(payload)
      });

      const resultado = await resposta.json();

      if (!resposta.ok || !resultado.sucesso) {
        throw new Error(resultado.mensagem || 'Erro ao enviar.');
      }

      statusFormulario.textContent =
        'Recebemos seus dados. Em breve, entraremos em contato pelo WhatsApp.';
      statusFormulario.className = 'sucesso';

      formulario.reset();

      // Opcional: registrar conversão no Google Analytics
      if (typeof gtag === 'function') {
        gtag('event', 'lead_form_submit', {
          form_name: 'landing_page_arapiraca'
        });
      }
    } catch (erro) {
      statusFormulario.textContent =
        'Não foi possível enviar agora. Tente novamente ou fale conosco pelo WhatsApp.';
      statusFormulario.className = 'erro';
    } finally {
      botao.disabled = false;
      botao.textContent = 'Consultar cursos e condições';
    }
  });
}
})();

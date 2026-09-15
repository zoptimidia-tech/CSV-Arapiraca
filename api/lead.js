export default async function handler(req, res) {
  if (req.method !== 'POST') {
    return res.status(405).json({
      sucesso: false,
      mensagem: 'Método não permitido.'
    });
  }

  try {
    const {
      nome,
      whatsapp,
      email,
      curso,
      origem,
      honeypot
    } = req.body || {};

    // Campo invisível usado para bloquear robôs simples
    if (honeypot) {
      return res.status(200).json({
        sucesso: true,
        mensagem: 'Cadastro recebido.'
      });
    }

    if (!nome || !whatsapp || !curso) {
      return res.status(400).json({
        sucesso: false,
        mensagem: 'Preencha os campos obrigatórios.'
      });
    }

    const nomeLimpo = String(nome).trim().substring(0, 100);
    const whatsappLimpo = String(whatsapp).trim().substring(0, 30);
    const emailLimpo = String(email || '').trim().substring(0, 150);
    const cursoLimpo = String(curso).trim().substring(0, 150);

    const respostaGoogle = await fetch(process.env.APPS_SCRIPT_URL, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        secret: process.env.FORM_SHARED_SECRET,
        nome: nomeLimpo,
        whatsapp: whatsappLimpo,
        email: emailLimpo,
        curso: cursoLimpo,
        origem: origem || 'Landing Page'
      })
    });

    const resultado = await respostaGoogle.json();

    if (!respostaGoogle.ok || !resultado.sucesso) {
      throw new Error('Falha ao salvar o lead.');
    }

    return res.status(200).json({
      sucesso: true,
      mensagem: 'Cadastro enviado com sucesso.'
    });
  } catch (erro) {
    console.error(erro);

    return res.status(500).json({
      sucesso: false,
      mensagem: 'Não foi possível enviar o cadastro agora.'
    });
  }
}
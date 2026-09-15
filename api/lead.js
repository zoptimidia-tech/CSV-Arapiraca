const json = (res, status, body) => {
  res.status(status).setHeader('Content-Type', 'application/json; charset=utf-8');
  return res.end(JSON.stringify(body));
};

const text = value => String(value ?? '').trim();

export default async function handler(req, res) {
  if (req.method !== 'POST') {
    return json(res, 405, { success: false, message: 'Método não permitido.' });
  }

  try {
    const body = req.body || {};
    const name = text(body.name);
    const phone = text(body.phone);
    const course = text(body.course);

    if (name.length < 3 || name.length > 120) {
      return json(res, 422, { success: false, message: 'Informe um nome válido.' });
    }

    const digits = phone.replace(/\D+/g, '');
    if (digits.length < 10 || digits.length > 13) {
      return json(res, 422, { success: false, message: 'Informe um WhatsApp válido com DDD.' });
    }

    const allowedCourses = [
      'Pedagogia',
      'Análise e Desenvolvimento de Sistemas',
      'Administração',
      'Nutrição',
      'Ainda não decidi'
    ];

    if (!allowedCourses.includes(course)) {
      return json(res, 422, { success: false, message: 'Selecione uma área de interesse.' });
    }

    const appsScriptUrl = process.env.APPS_SCRIPT_URL;
    const sharedSecret = process.env.FORM_SHARED_SECRET;

    if (!appsScriptUrl || !sharedSecret) {
      console.error('Variáveis APPS_SCRIPT_URL ou FORM_SHARED_SECRET ausentes.');
      return json(res, 500, { success: false, message: 'O formulário ainda não está configurado no servidor.' });
    }

    const googleResponse = await fetch(appsScriptUrl, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        secret: sharedSecret,
        nome: name,
        whatsapp: digits,
        curso: course,
        marketing: body.marketing === '1' || body.marketing === 'on' ? 'sim' : 'não',
        origem: 'Landing Page Polo Arapiraca'
      })
    });

    const googleBody = await googleResponse.text();
    let googleData = {};
    if (googleBody.trim()) {
      try {
        googleData = JSON.parse(googleBody);
      } catch {
        console.error('Resposta inválida do Google Apps Script:', googleBody.slice(0, 300));
      }
    }

    if (!googleResponse.ok || googleData.sucesso === false || googleData.success === false) {
      console.error('Falha ao salvar no Google Sheets:', googleResponse.status, googleBody.slice(0, 300));
      return json(res, 502, { success: false, message: 'Não foi possível registrar o cadastro agora.' });
    }

    const whatsappNumber = process.env.POLO_WHATSAPP || '5582999999999';
    const whatsappMessage = encodeURIComponent(`Olá! Meu nome é ${name}. Quero saber mais sobre ${course}.`);

    return json(res, 200, {
      success: true,
      message: 'Cadastro recebido! Abrindo o WhatsApp do polo para você continuar o atendimento.',
      whatsapp: `https://wa.me/${whatsappNumber}?text=${whatsappMessage}`
    });
  } catch (error) {
    console.error('Erro no endpoint /api/lead:', error);
    return json(res, 500, { success: false, message: 'Não foi possível enviar agora. Tente novamente.' });
  }
}

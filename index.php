<?php
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrfToken = $_SESSION['csrf_token'];
$whatsappNumber = '55829999577602'; // Substitua pelo WhatsApp oficial do polo.
$whatsappMessage = rawurlencode('Olá! Quero conhecer os cursos e condições do Polo Arapiraca.');
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Comece sua graduação EAD com flexibilidade e suporte de verdade no Polo Arapiraca. Consulte cursos, formas de ingresso e condições disponíveis.">
  <meta name="theme-color" content="#071c35">
  <title>Graduação EAD em Arapiraca | Polo Cruzeiro do Sul Virtual</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header class="site-header">
    <div class="container nav-wrap">
      <a class="brand" href="#top" aria-label="Cruzeiro do Sul Virtual Polo Arapiraca">
        <span class="brand-mark">CS</span>
        <span><strong>Cruzeiro do Sul</strong><small>VIRTUAL · POLO ARAPIRACA</small></span>
      </a>
      <nav class="desktop-nav" aria-label="Navegação principal">
        <a href="#cursos">Cursos</a><a href="#como-funciona">Como funciona</a><a href="#duvidas">Dúvidas</a>
      </nav>
      <a class="button button-small button-outline" href="#formulario">Falar com consultor</a>
    </div>
  </header>

  <main id="top">
    <section class="hero">
      <div class="container hero-grid">
        <div class="hero-copy">
          <div class="eyebrow"><span class="pulse"></span> Polo local em Arapiraca</div>
          <h1>Sua graduação pode começar <em>agora.</em></h1>
          <p class="hero-subtitle">A flexibilidade do EAD com o suporte humano que faz diferença na sua jornada.</p>
          <div class="hero-points">
            <span>✓ Estude de onde estiver</span><span>✓ Suporte próximo e humanizado</span><span>✓ Consulte bolsas e condições</span>
          </div>
          <div class="trust-line"><div class="avatars"><span>J</span><span>M</span><span>A</span></div><span><b>+ de 30 anos</b> transformando futuros</span></div>
        </div>
        <div class="form-card" id="formulario">
          <div class="form-top"><span class="step-label">ATENDIMENTO GRATUITO</span><span class="form-time">◷ 1 min</span></div>
          <h2>Encontre o curso ideal para você</h2>
          <p>Receba orientação sobre cursos, ingresso e condições disponíveis.</p>
          <form id="lead-form" action="process-lead.php" method="post" novalidate>
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">
            <div class="field"><label for="name">Seu nome completo</label><input id="name" name="name" type="text" autocomplete="name" placeholder="Como podemos chamar você?" required><small class="error-message"></small></div>
            <div class="field"><label for="phone">Seu WhatsApp com DDD</label><input id="phone" name="phone" type="tel" inputmode="tel" autocomplete="tel" placeholder="(82) 99999-9999" required><small class="error-message"></small></div>
            <div class="field"><label for="course">Qual área você quer conhecer?</label><select id="course" name="course" required><option value="">Selecione uma opção</option><option>Pedagogia</option><option>Análise e Desenvolvimento de Sistemas</option><option>Administração</option><option>Nutrição</option><option>Ainda não decidi</option></select><small class="error-message"></small></div>
            <label class="consent"><input type="checkbox" name="marketing" value="1"><span>Aceito receber novidades e condições por WhatsApp e e-mail. Posso cancelar quando quiser.</span></label>
            <button class="button button-primary button-full" type="submit">Consultar cursos e condições <span>→</span></button>
            <p class="privacy-note">Seus dados serão usados para responder ao seu pedido. <a href="#privacidade">Leia nossa política de privacidade.</a></p>
            <div class="form-status" role="status" aria-live="polite"></div>
          </form>
        </div>
      </div>
    </section>

    <section class="proof-strip"><div class="container proof-grid"><div><b>01</b><span>Escolha seu objetivo</span></div><div><b>02</b><span>Receba orientação personalizada</span></div><div><b>03</b><span>Comece no seu ritmo</span></div></div></section>

    <section class="section" id="cursos"><div class="container"><div class="section-heading"><div><span class="kicker">ESCOLHA SEU PRÓXIMO PASSO</span><h2>Uma formação para cada plano.</h2></div><p>Conheça algumas das áreas mais procuradas e descubra a opção que combina com os seus objetivos.</p></div>
      <div class="course-grid">
        <?php foreach ([['Educação','Pedagogia','Transforme vidas através da educação.','01','pedagogia'],['Tecnologia','Análise e Desenvolvimento de Sistemas','Crie soluções para o mundo digital.','02','tecnologia'],['Negócios','Administração','Prepare-se para tomar decisões e liderar.','03','administracao'],['Saúde','Nutrição','Cuidado, ciência e qualidade de vida.','04','nutricao']] as $item): ?>
          <article class="course-card <?= $item[4] ?>"><span class="course-number"><?= $item[3] ?></span><span class="course-area"><?= $item[0] ?></span><h3><?= $item[1] ?></h3><p><?= $item[2] ?></p><a href="#formulario" class="course-link" data-course="<?= htmlspecialchars($item[1], ENT_QUOTES, 'UTF-8') ?>">Quero conhecer <span>↗</span></a></article>
        <?php endforeach; ?>
      </div>
    </div></section>

    <section class="section dark-section" id="como-funciona"><div class="container how-grid"><div><span class="kicker light">SIMPLES, HUMANO E PERTO DE VOCÊ</span><h2>Você não precisa decidir tudo sozinho.</h2><p class="dark-lead">Nosso time está pronto para ouvir seus planos, tirar suas dúvidas e mostrar os caminhos possíveis para você começar.</p><a class="button button-light" href="#formulario">Quero conversar com um consultor <span>→</span></a></div><div class="steps"><div class="step"><b>01</b><div><h3>Conte o que você procura</h3><p>Preencha seus dados e indique uma área de interesse.</p></div></div><div class="step"><b>02</b><div><h3>Receba as opções</h3><p>Um consultor apresenta cursos, formas de ingresso e condições vigentes.</p></div></div><div class="step"><b>03</b><div><h3>Escolha com segurança</h3><p>Tire todas as dúvidas antes de dar o próximo passo.</p></div></div></div></div></section>

    <section class="section testimonial-section"><div class="container testimonial-grid"><div class="quote-mark">“</div><blockquote>Eu precisava estudar sem abandonar o trabalho. O atendimento do polo me ajudou a entender todas as etapas e escolher com tranquilidade.</blockquote><div class="student"><div class="student-avatar">MC</div><div><b>Maria Clara S.</b><span>Estudante de Pedagogia · Arapiraca</span></div></div></div></section>

    <section class="section faq-section" id="duvidas"><div class="container faq-grid"><div class="section-heading"><span class="kicker">AINDA TEM DÚVIDAS?</span><h2>Respostas para começar tranquilo.</h2><p>Se a sua pergunta não estiver aqui, fale com o polo. Vamos ajudar você.</p><a class="text-link" href="#formulario">Falar com o polo →</a></div><div class="faq-list"><details open><summary>Como funciona a graduação EAD?</summary><p>Você estuda com flexibilidade usando a plataforma digital e conta com o apoio do polo para orientação e atividades previstas pela instituição.</p></details><details><summary>Posso estudar trabalhando?</summary><p>Sim. A flexibilidade da modalidade permite organizar os estudos de acordo com a sua rotina. Consulte o consultor sobre a dinâmica do curso escolhido.</p></details><details><summary>Quais cursos e condições estão disponíveis?</summary><p>A oferta, valores e descontos podem variar conforme o curso e a forma de ingresso. Preencha o formulário para receber as informações atualizadas.</p></details><details><summary>O que acontece depois do cadastro?</summary><p>Um consultor do Polo Arapiraca entra em contato pelo WhatsApp para entender seu momento e apresentar as opções disponíveis, sem compromisso.</p></details></div></div></section>

    <section class="final-cta"><div class="container final-inner"><div><span class="kicker light">SEU FUTURO MERECE UM PLANO</span><h2>Pronto para dar o próximo passo?</h2><p>Consulte cursos, ingresso e condições para começar sua graduação.</p></div><a class="button button-accent" href="#formulario">Receber orientação gratuita <span>→</span></a></div></section>
  </main>

  <footer class="footer" id="privacidade"><div class="container footer-grid"><div class="brand footer-brand"><span class="brand-mark">CS</span><span><strong>Cruzeiro do Sul</strong><small>VIRTUAL · POLO ARAPIRACA</small></span></div><div><b>Atendimento</b><p>Arapiraca · Alagoas<br>Segunda a sexta, das 8h às 18h</p></div><div><b>Fale com a gente</b><p><a href="https://wa.me/<?= $whatsappNumber ?>?text=<?= $whatsappMessage ?>" target="_blank" rel="noopener">WhatsApp do polo ↗</a><br><a href="#formulario">Solicitar atendimento</a></p></div></div><div class="container footer-bottom"><span>© <?= date('Y') ?> Polo Arapiraca. Informações sujeitas à oferta vigente.</span><span>Política de Privacidade · Uso responsável de dados</span></div></footer>
  <a class="floating-whatsapp" href="https://wa.me/<?= $whatsappNumber ?>?text=<?= $whatsappMessage ?>" target="_blank" rel="noopener" aria-label="Falar com o Polo Arapiraca pelo WhatsApp">⌕ <span>Falar no WhatsApp</span></a>
  <script>window.POLO_WHATSAPP = '<?= $whatsappNumber ?>';</script>
  <script src="script.js" defer></script>
</body>
</html>

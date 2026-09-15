# Landing page — Polo Arapiraca

Landing page responsiva de captação para o Polo Arapiraca, com a página principal em HTML, estilos em CSS e interações em JavaScript. O PHP permanece somente nos endpoints necessários ao formulário.

## Como executar no Phoenix Code

1. Abra a pasta do projeto no Phoenix Code.
2. Edite `index.html`, `styles.css` e `script.js` normalmente.
3. Substitua `5582999999999` em `index.html` pelo WhatsApp oficial do polo.
4. Para visualizar apenas o layout, abra `index.html` no preview do Phoenix Code.
5. Para testar o formulário completo, publique a pasta em um servidor com PHP e acesse a página pelo endereço do servidor.

## Arquivos principais

- `index.html`: página estática pronta para edição e publicação.
- `styles.css`: identidade visual e responsividade.
- `script.js`: máscara, validação, seleção de curso e envio assíncrono.
- `csrf-token.php`: fornece o token de segurança ao formulário.
- `process-lead.php`: valida e registra os leads no servidor.

## Formulário na Vercel

A versão configurada para a Vercel usa:

`index.html` → `/api/lead` → Google Apps Script → Google Sheets

A função `api/lead.js` valida os dados, encaminha o lead ao Apps Script e devolve sempre uma resposta JSON. Isso evita o erro `Unexpected end of JSON input`, que ocorre quando o navegador tenta interpretar como JSON uma resposta vazia, HTML ou uma página de erro.

### Variáveis de ambiente na Vercel

Configure no projeto:

- `APPS_SCRIPT_URL`: URL publicada do Google Apps Script terminada em `/exec`.
- `FORM_SHARED_SECRET`: mesmo segredo configurado no Apps Script.
- `POLO_WHATSAPP`: número oficial no formato internacional, por exemplo `5582999999999`.

Depois de salvar as variáveis, faça um novo deploy.

### Google Apps Script

O Apps Script deve aceitar `POST` com JSON e retornar JSON, usando os campos `secret`, `nome`, `whatsapp`, `curso`, `marketing` e `origem`. A aba da planilha deve estar preparada para receber os leads. Publique o script como aplicativo da web, executando como o proprietário e com acesso para qualquer pessoa.

### Diagnóstico do erro

Se ainda aparecer a mensagem no navegador:

1. Abra o DevTools do navegador e consulte a aba Network.
2. Se `/api/lead` retornar `404`, confirme que `api/lead.js` foi enviado ao GitHub e que houve novo deploy.
3. Se retornar `500`, confira as três variáveis de ambiente e faça novo deploy.
4. Se retornar `502`, confira a URL `/exec`, o segredo e a implantação do Apps Script.
5. Se a resposta for HTML, provavelmente a URL está apontando para uma página de erro ou para um endpoint PHP que a Vercel não executa.

A interface agora lê a resposta como texto antes de convertê-la para JSON e mostra uma mensagem compreensível quando o servidor retorna vazio ou conteúdo inválido.

## Compatibilidade PHP

Os arquivos `process-lead.php` e `csrf-token.php` permanecem no projeto para hospedagens com PHP tradicional. Eles não são executados pela Vercel; na Vercel, mantenha o formulário apontando para `/api/lead`.

Antes de publicar, revise a Política de Privacidade, endereço, horário, depoimento, informações comerciais e número oficial do WhatsApp com o responsável do polo.

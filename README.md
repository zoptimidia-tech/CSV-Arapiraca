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

## Formulário

O formulário possui validação no navegador e no servidor, proteção CSRF e grava leads em `leads.csv`. Em produção, substitua essa persistência por uma integração segura com CRM ou banco de dados e configure permissões para proteger os dados captados.

Importante: o formulário não funcionará em hospedagem somente estática, porque depende dos endpoints PHP. Se o servidor não aceitar PHP, será necessário trocar o `action` por um serviço ou API de formulários.

Antes de publicar, revise a Política de Privacidade, endereço, horário, depoimento, informações comerciais e número oficial do WhatsApp com o responsável do polo.

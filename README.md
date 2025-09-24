# PSARJ Online

Interface estática demonstrando um painel de serviços digitais para servidores do Estado do Rio de Janeiro.
A solução foi construída com arquivos exclusivamente textuais (HTML, CSS, JavaScript e SVG) para facilitar a revisão do código e evitar o alerta de incompatibilidade com arquivos binários.

## Visão geral

A página reúne:

- **Hero** com indicadores sintéticos e atalhos rápidos.
- **Catálogo de serviços** com filtro por categoria e busca textual.
- **Agenda** com prazos institucionais e contagem regressiva dinâmica.
- **Central de suporte** com formulário e mensagens de confirmação instantânea.
- **FAQ interativo** com expansão/colapso acessível.

Todo o conteúdo está em português e pensado para ilustrar um portal governamental moderno.

## Como executar

Nenhuma dependência adicional é necessária. Basta abrir o arquivo `index.html` em um navegador moderno.

Caso deseje servir o projeto localmente com o Python instalado, execute:

```bash
python -m http.server 8000
```

e acesse `http://localhost:8000`.

## Organização dos arquivos

```
/
├── assets/logo.svg          # Logotipo em SVG (formato textual)
├── index.html               # Estrutura principal da página
├── scripts/app.js           # Dados estáticos e interações
├── styles/main.css          # Estilos e layout responsivo
└── README.md
```

## Melhorias futuras

- Conectar os formulários e consultas a uma API real de serviços do Estado.
- Persistir preferências de filtros utilizando armazenamento local.
- Internacionalizar a interface para outros idiomas.

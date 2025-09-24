const services = [
  {
    id: 'portaria-digitada',
    name: 'Publicação de Portaria Digital',
    category: 'documentos',
    description:
      'Envie documentos oficiais para assinatura eletrônica, escolha perfis de assinatura e acompanhe as etapas em tempo real.',
    status: 'Fluxo revisado',
    updatedAt: '2025-02-10',
    actions: ['Gerar minuta', 'Acompanhar protocolo'],
  },
  {
    id: 'folha-supletiva',
    name: 'Folha suplementar',
    category: 'financeiro',
    description:
      'Solicite inclusão de rubricas extraordinárias com validação automática das regras de concessão.',
    status: 'Integração SEFAZ',
    updatedAt: '2025-01-26',
    actions: ['Abrir solicitação', 'Ver histórico'],
  },
  {
    id: 'licenca-saude',
    name: 'Licença para tratamento de saúde',
    category: 'saude',
    description:
      'Cadastre laudos, agenda perícias médicas e acompanhe comunicação com o órgão de origem.',
    status: 'Fluxo unificado',
    updatedAt: '2025-03-02',
    actions: ['Registrar laudo', 'Ver regulamento'],
  },
  {
    id: 'ferias-programadas',
    name: 'Planejamento de férias',
    category: 'gestao',
    description:
      'Controle de férias com cálculo automático de períodos aquisitivos e alertas de aprovação pendente.',
    status: 'Painel ativo',
    updatedAt: '2025-02-21',
    actions: ['Abrir painel', 'Orientações'],
  },
  {
    id: 'ressarcimento',
    name: 'Ressarcimento de despesa',
    category: 'financeiro',
    description:
      'Checklist guiado para reembolso de despesas com validação de notas fiscais e limites orçamentários.',
    status: 'Novo formulário',
    updatedAt: '2025-02-18',
    actions: ['Iniciar reembolso', 'Regras de análise'],
  },
  {
    id: 'certidao-tempo',
    name: 'Certidão de tempo de serviço',
    category: 'documentos',
    description:
      'Centralize solicitações com integrações ao RH, previdência e módulo de cadastro funcional.',
    status: 'Processo unificado',
    updatedAt: '2025-01-31',
    actions: ['Solicitar certidão', 'Documentação necessária'],
  },
  {
    id: 'teletrabalho',
    name: 'Gestão de teletrabalho',
    category: 'gestao',
    description:
      'Acompanhe planos de trabalho, metas e relatórios mensais com indicadores de produtividade.',
    status: 'Em monitoramento',
    updatedAt: '2025-02-28',
    actions: ['Criar plano', 'Ver indicadores'],
  },
  {
    id: 'pericia-oficial',
    name: 'Perícia oficial',
    category: 'saude',
    description:
      'Agenda digital para perícias com integração às unidades médicas e relatórios padronizados.',
    status: 'Expansão 2025',
    updatedAt: '2025-03-04',
    actions: ['Agendar perícia', 'Protocolos vigentes'],
  },
];

const deadlines = [
  {
    id: 'relatorio-trimestral',
    title: 'Relatório trimestral de gestão',
    category: 'Gestão',
    deadline: '2025-04-05',
    description: 'Envio consolidado das metas pactuadas e indicadores de atendimento.',
  },
  {
    id: 'recadastramento',
    title: 'Recadastramento anual do servidor',
    category: 'Cadastro',
    deadline: '2025-05-01',
    description: 'Obrigatório para ativos, aposentados e pensionistas vinculados ao regime próprio.',
  },
  {
    id: 'folha-extra',
    title: 'Fechamento folha suplementar abril',
    category: 'Financeiro',
    deadline: '2025-03-26',
    description: 'Prazo final para inclusão de rubricas e autorização de pagamento.',
  },
  {
    id: 'auditoria-integrada',
    title: 'Auditoria integrada do TCE',
    category: 'Controle',
    deadline: '2025-04-20',
    description: 'Envio de documentos comprobatórios e registro de evidências do plano de ação.',
  },
];

const faqs = [
  {
    question: 'Como solicitar acesso para uma nova secretaria?',
    answer:
      'Envie ofício eletrônico com a lista de servidores responsáveis. A habilitação é concluída em até 48 horas com assinatura digital do gestor.',
  },
  {
    question: 'É possível acompanhar indicadores em tempo real?',
    answer:
      'Sim. O painel apresenta KPIs atualizados a cada 30 minutos, com filtros por órgão, tipo de serviço e SLA de atendimento.',
  },
  {
    question: 'Há integração com sistemas legados?',
    answer:
      'As integrações com SEFAZ, RH Digital e protocolo oficial estão disponíveis via API padronizada e conectores validados.',
  },
  {
    question: 'O suporte atende fora do horário comercial?',
    answer:
      'Chamados críticos contam com plantão 24h e monitoramento proativo. Para solicitações gerais o atendimento ocorre das 8h às 18h.',
  },
];

const categoryLabels = {
  gestao: 'Gestão de Pessoas',
  financeiro: 'Financeiro',
  documentos: 'Documentos',
  saude: 'Saúde',
};

function formatDate(date) {
  const formatter = new Intl.DateTimeFormat('pt-BR', {
    day: '2-digit',
    month: 'short',
  });
  return formatter.format(new Date(date));
}

function calculateCountdown(date) {
  const today = new Date();
  const target = new Date(date);
  const diff = target - today;
  if (Number.isNaN(diff)) return '';
  const days = Math.ceil(diff / (1000 * 60 * 60 * 24));
  if (days < 0) return 'Prazo encerrado';
  if (days === 0) return 'Encerra hoje';
  if (days === 1) return '1 dia restante';
  return `${days} dias restantes`;
}

function renderServices(filter, query) {
  const container = document.querySelector('#lista-servicos');
  container.replaceChildren();

  const normalizedQuery = query.trim().toLowerCase();
  const filtered = services.filter((service) => {
    const matchesCategory = filter === 'todos' || service.category === filter;
    const matchesQuery =
      !normalizedQuery ||
      service.name.toLowerCase().includes(normalizedQuery) ||
      service.description.toLowerCase().includes(normalizedQuery);
    return matchesCategory && matchesQuery;
  });

  if (!filtered.length) {
    const emptyState = document.createElement('div');
    emptyState.className = 'module-card';
    emptyState.innerHTML = `
      <span class="module-card__category">Sem resultados</span>
      <h3>Nenhum serviço encontrado</h3>
      <p class="module-card__description">
        Ajuste os filtros ou verifique outra palavra-chave. Nossa equipe pode habilitar novos fluxos conforme a demanda.
      </p>
      <div class="module-card__footer">
        <span class="module-card__status">Sugestão de melhoria?</span>
        <span class="module-card__actions">Fale com o suporte</span>
      </div>
    `;
    container.append(emptyState);
    return;
  }

  filtered.forEach((service) => {
    const card = document.createElement('article');
    card.className = 'module-card';
    card.setAttribute('role', 'listitem');
    card.innerHTML = `
      <span class="module-card__category">${categoryLabels[service.category]}</span>
      <h3>${service.name}</h3>
      <p class="module-card__description">${service.description}</p>
      <div class="module-card__footer">
        <span class="module-card__status">${service.status}</span>
        <span class="module-card__actions">${service.actions.join(' · ')}</span>
      </div>
    `;

    card.dataset.category = service.category;
    card.dataset.updatedAt = service.updatedAt;
    container.append(card);
  });
}

function renderAgenda() {
  const timeline = document.querySelector('#dashboard-agenda');
  const agendaList = document.querySelector('#agenda-detalhada');
  timeline.replaceChildren();
  agendaList.replaceChildren();

  const upcoming = [...deadlines].sort(
    (a, b) => new Date(a.deadline) - new Date(b.deadline),
  );

  upcoming.slice(0, 3).forEach((item) => {
    const entry = document.createElement('li');
    entry.textContent = `${formatDate(item.deadline)} · ${item.title}`;
    timeline.append(entry);
  });

  upcoming.forEach((item) => {
    const card = document.createElement('article');
    card.className = 'agenda-card';
    card.setAttribute('role', 'listitem');
    card.innerHTML = `
      <div class="agenda-card__meta">
        <span class="agenda-card__badge">${item.category}</span>
        <span class="agenda-card__deadline">${formatDate(item.deadline)}</span>
        <span class="agenda-card__countdown" data-deadline="${item.deadline}"></span>
      </div>
      <h3>${item.title}</h3>
      <p>${item.description}</p>
    `;
    agendaList.append(card);
  });

  updateCountdowns();
  window.clearInterval(renderAgenda.interval);
  renderAgenda.interval = window.setInterval(updateCountdowns, 60_000);
}

function updateCountdowns() {
  document.querySelectorAll('[data-deadline]').forEach((element) => {
    const deadline = element.dataset.deadline;
    element.textContent = calculateCountdown(deadline);
  });
}

function renderFaq() {
  const container = document.querySelector('#faq-list');
  container.replaceChildren();

  faqs.forEach((item, index) => {
    const faqItem = document.createElement('article');
    faqItem.className = 'faq-item';
    faqItem.setAttribute('role', 'listitem');

    const questionId = `faq-question-${index}`;
    const answerId = `faq-answer-${index}`;

    faqItem.innerHTML = `
      <div class="faq-item__question" id="${questionId}">
        <span>${item.question}</span>
        <button type="button" aria-expanded="false" aria-controls="${answerId}">+</button>
      </div>
      <p id="${answerId}" class="faq-item__answer" hidden>${item.answer}</p>
    `;

    const toggleButton = faqItem.querySelector('button');
    const answer = faqItem.querySelector('.faq-item__answer');

    toggleButton.addEventListener('click', () => {
      const expanded = toggleButton.getAttribute('aria-expanded') === 'true';
      toggleButton.setAttribute('aria-expanded', String(!expanded));
      toggleButton.textContent = expanded ? '+' : '−';
      answer.hidden = expanded;
    });

    container.append(faqItem);
  });
}

function handleNavigation() {
  const buttons = document.querySelectorAll('[data-scroll-to], .top-bar__actions [data-action]');
  buttons.forEach((button) => {
    button.addEventListener('click', (event) => {
      const action = event.currentTarget.dataset.scrollTo || event.currentTarget.dataset.action;
      if (!action) return;
      const sectionId = action === 'services' ? 'servicos' : action === 'calendar' ? 'agenda' : action;
      const section = document.getElementById(sectionId);
      if (section) {
        section.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });
}

function setupFilters() {
  const searchInput = document.querySelector('#busca-servicos');
  const filterButtons = document.querySelectorAll('.filter-button');
  let currentFilter = 'todos';
  let currentQuery = '';

  renderServices(currentFilter, currentQuery);

  searchInput.addEventListener('input', (event) => {
    currentQuery = event.target.value;
    renderServices(currentFilter, currentQuery);
  });

  filterButtons.forEach((button) => {
    button.addEventListener('click', () => {
      filterButtons.forEach((btn) => btn.classList.remove('is-active'));
      button.classList.add('is-active');
      currentFilter = button.dataset.filter ?? 'todos';
      renderServices(currentFilter, currentQuery);
    });
  });
}

function setupSupportForm() {
  const form = document.querySelector('.support-section__form');
  const disclaimer = form.querySelector('.support-section__disclaimer');

  form.addEventListener('submit', (event) => {
    event.preventDefault();
    const formData = new FormData(form);
    const name = formData.get('nome');
    disclaimer.textContent = `Chamado registrado! ${name ? `${name}, ` : ''}você receberá um protocolo por e-mail.`;
    form.reset();
  });
}

window.addEventListener('DOMContentLoaded', () => {
  renderAgenda();
  renderFaq();
  setupFilters();
  setupSupportForm();
  handleNavigation();
});

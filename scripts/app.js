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
  {
    question: 'Como acompanhar chamados abertos pela minha equipe?',
    answer:
      'Acesse a Central de suporte e filtre por órgão ou número de protocolo. Os relatórios permitem exportação em CSV e PDF.',
  },
  {
    question: 'Quais navegadores e dispositivos são suportados?',
    answer:
      'A plataforma é compatível com as versões recentes do Chrome, Edge, Firefox e Safari, além de tablets e celulares com Android ou iOS atualizados.',
  },
];

const integrationMap = [
  {
    id: 'integracao-servicos',
    title: 'Catálogo de serviços',
    description: 'Centraliza fluxos digitais, regras de negócio e integrações com sistemas legados.',
    connections: [
      { target: 'Agenda institucional', detail: 'Publica prazos automaticamente ao abrir novos fluxos.' },
      { target: 'Central de suporte', detail: 'Gera protocolos vinculados ao serviço selecionado.' },
      { target: 'Base de conhecimento', detail: 'Sugere artigos relacionados durante a solicitação.' },
    ],
  },
  {
    id: 'integracao-agenda',
    title: 'Agenda institucional',
    description: 'Garante visibilidade sobre marcos legais, auditorias e prazos de folha.',
    connections: [
      { target: 'Catálogo de serviços', detail: 'Vincula cada prazo a fluxos específicos e responsáveis.' },
      { target: 'Central de suporte', detail: 'Cria alertas quando o prazo impacta atendimento crítico.' },
      { target: 'Base de conhecimento', detail: 'Disponibiliza guias e modelos por marco regulatório.' },
    ],
  },
  {
    id: 'integracao-suporte',
    title: 'Central de suporte',
    description: 'Atende demandas multicanais com protocolos rastreáveis e SLA monitorado.',
    connections: [
      { target: 'Catálogo de serviços', detail: 'Permite escalar para equipes responsáveis de cada fluxo.' },
      { target: 'Agenda institucional', detail: 'Prioriza chamados conforme a proximidade do prazo.' },
      { target: 'Base de conhecimento', detail: 'Sugere artigos para reduzir reincidência de chamados.' },
    ],
  },
  {
    id: 'integracao-faq',
    title: 'Base de conhecimento',
    description: 'Reúne orientações oficiais, vídeos e trilhas de capacitação atualizadas pelas secretarias.',
    connections: [
      { target: 'Catálogo de serviços', detail: 'Disponibiliza guias passo a passo para cada fluxo.' },
      { target: 'Central de suporte', detail: 'Fornece scripts e checklists para atendimento assistido.' },
      { target: 'Agenda institucional', detail: 'Contextualiza prazos com materiais de apoio.' },
    ],
  },
];

const supportChannels = [
  {
    id: 'chat',
    name: 'Chat instantâneo',
    description: 'Canal autenticado com registro das conversas, anexos e transcrição automática.',
    availability: '9h às 18h em dias úteis',
    sla: 'Resposta média em 12 minutos',
  },
  {
    id: 'portal',
    name: 'Portal de chamados',
    description: 'Fluxos orientados por tipo de serviço, com checklists e prazos negociados.',
    availability: '24 horas por dia',
    sla: 'SLA definido por criticidade',
  },
  {
    id: 'plantao',
    name: 'Plantão telefônico',
    description: 'Atendimento emergencial para indisponibilidades críticas e incidentes de segurança.',
    availability: 'Plantão 24h',
    sla: 'Resposta imediata',
  },
  {
    id: 'comunidade',
    name: 'Comunidade PSARJ',
    description: 'Rede colaborativa moderada com fóruns por secretaria e boas práticas validadas.',
    availability: 'Moderação contínua',
    sla: 'Curadoria semanal',
  },
];

const agendaContacts = [
  {
    area: 'Secretaria de Administração',
    owner: 'Ana Ribeiro',
    responsibility: 'Coordena os marcos da folha suplementar e valida cronogramas dos órgãos.',
  },
  {
    area: 'Controladoria Geral',
    owner: 'Carlos Mendes',
    responsibility: 'Consolida evidências para o TCE e monitora riscos de descumprimento.',
  },
  {
    area: 'PRODERJ',
    owner: 'Equipe de Integração',
    responsibility: 'Automatiza alertas via chat corporativo e monitora disponibilidade dos sistemas.',
  },
];

const serviceResponsibilityMatrix = [
  {
    area: 'Gestão de Pessoas',
    responsibilities: [
      'Homologar fluxos de férias, licenças e afastamentos.',
      'Atualizar dados cadastrais e vínculos funcionais no RH Digital.',
      'Acompanhar indicadores de provimento, vacância e teletrabalho.',
    ],
    integrations: ['RH Digital', 'SEI-RJ', 'Portal do Servidor'],
  },
  {
    area: 'Financeiro',
    responsibilities: [
      'Validar rubricas, conformidade orçamentária e limites de empenho.',
      'Emitir relatórios para auditorias internas e externas.',
      'Configurar alertas de fechamento da folha e pagamentos suplementares.',
    ],
    integrations: ['SEFAZ', 'SIAFE-RJ', 'Painel de Auditoria'],
  },
  {
    area: 'Documentos',
    responsibilities: [
      'Gerenciar modelos oficiais e fluxos de assinatura digital.',
      'Padronizar portarias, certidões e atas com versionamento controlado.',
      'Garantir trilha de auditoria e políticas de retenção documental.',
    ],
    integrations: ['Assinatura Digital RJ', 'Arquivo Público', 'Portal de Publicações'],
  },
  {
    area: 'Saúde do Servidor',
    responsibilities: [
      'Agendar perícias e monitorar laudos médicos integrados.',
      'Operar teleatendimento e programas de bem-estar.',
      'Gerenciar comunicação entre unidades de origem e perícia.',
    ],
    integrations: ['Portal Saúde RJ', 'Telemedicina', 'Central de Laudos'],
  },
];

const agendaMatrix = [
  {
    area: 'Planejamento e Gestão',
    responsibilities: [
      'Consolidar cronograma mestre das secretarias e publicar alertas preventivos.',
      'Definir responsáveis substitutos e níveis de aprovação.',
      'Alinhar prazos com o gabinete e o Tribunal de Contas.',
    ],
    integrations: ['Painel Executivo', 'Sala de Situação', 'TCE-RJ'],
  },
  {
    area: 'Jurídico Central',
    responsibilities: [
      'Validar pareceres e versões finais de portarias e relatórios.',
      'Garantir conformidade com a legislação vigente.',
      'Registrar evidências e documentação comprobatória.',
    ],
    integrations: ['SEI-RJ', 'Controle de Versões', 'Base de Conhecimento'],
  },
  {
    area: 'Comunicação Interna',
    responsibilities: [
      'Divulgar prazos e alertas via boletins e notificações.',
      'Disponibilizar materiais orientativos no portal do servidor.',
      'Promover workshops de alinhamento com as secretarias.',
    ],
    integrations: ['Portal do Servidor', 'Intranet RJ', 'Eventos Online'],
  },
];

const knowledgeMatrix = [
  {
    area: 'Curadoria de Conteúdo',
    responsibilities: [
      'Validar artigos com as secretarias responsáveis antes da publicação.',
      'Atualizar vídeos e roteiros conforme evolução dos serviços.',
      'Controlar versões e histórico de revisões.',
    ],
    integrations: ['Catálogo de Serviços', 'Central de Suporte'],
  },
  {
    area: 'Inteligência de Dados',
    responsibilities: [
      'Analisar indicadores de acesso e satisfação dos artigos.',
      'Sugerir novos conteúdos com base em chamados recorrentes.',
      'Compartilhar insights com as áreas responsáveis.',
    ],
    integrations: ['Analytics PSARJ', 'Painel de SLA'],
  },
  {
    area: 'Comunidade PSARJ',
    responsibilities: [
      'Curar discussões e consolidar boas práticas enviadas pelos órgãos.',
      'Promover mentorias e trilhas de capacitação colaborativas.',
      'Direcionar demandas complexas para a equipe de suporte.',
    ],
    integrations: ['Central de Suporte', 'Agenda de Capacitação'],
  },
];

let supportProtocols = [
  {
    protocol: 'PSARJ-2315',
    requester: 'SEEDUC',
    service: 'Licença para tratamento de saúde',
    status: 'Em análise',
    deadline: '2025-03-22',
    channel: 'Portal de chamados',
  },
  {
    protocol: 'PSARJ-2308',
    requester: 'SEFAZ',
    service: 'Ressarcimento de despesa',
    status: 'Em andamento',
    deadline: '2025-03-20',
    channel: 'Chat instantâneo',
  },
  {
    protocol: 'PSARJ-2294',
    requester: 'SEAP',
    service: 'Planejamento de férias',
    status: 'Concluído',
    deadline: '2025-03-15',
    channel: 'Portal de chamados',
  },
  {
    protocol: 'PSARJ-2280',
    requester: 'SEPLAG',
    service: 'Certidão de tempo de serviço',
    status: 'Em análise',
    deadline: '2025-03-25',
    channel: 'Portal de chamados',
  },
];

const faqCollections = [
  {
    title: 'Onboarding das secretarias',
    description: 'Checklist de implantação, perfis de acesso e modelos de comunicação.',
    href: 'faq.html#categorias-conhecimento',
  },
  {
    title: 'Gestão de chamados críticos',
    description: 'Scripts de atendimento e plano de resposta para incidentes.',
    href: 'faq.html#metodologia-suporte',
  },
  {
    title: 'Integrações com sistemas legados',
    description: 'Guia técnico de APIs e conectores homologados pelo PRODERJ.',
    href: 'faq.html#governanca-conhecimento',
  },
];

const knowledgeStats = {
  articles: 120,
  videos: 48,
  trails: 18,
  satisfaction: 4.8,
  feedbackCount: 680,
  contributors: 24,
};

const FILTER_STORAGE_KEY = 'psarj-service-filter';
const QUERY_STORAGE_KEY = 'psarj-service-query';
const LAST_PROTOCOL_KEY = 'psarj-last-protocol';

function getFromStorage(key) {
  try {
    return localStorage.getItem(key);
  } catch (error) {
    return null;
  }
}

function setInStorage(key, value) {
  try {
    localStorage.setItem(key, value);
  } catch (error) {
    // Ignora indisponibilidades, mantendo funcionalidade básica.
  }
}

const categoryLabels = {
  gestao: 'Gestão de Pessoas',
  financeiro: 'Financeiro',
  documentos: 'Documentos',
  saude: 'Saúde',
};

function toDate(value) {
  const date = value instanceof Date ? value : new Date(value);
  return Number.isNaN(date.getTime()) ? null : date;
}

function formatDate(date) {
  const formatter = new Intl.DateTimeFormat('pt-BR', {
    day: '2-digit',
    month: 'short',
  });
  const parsed = toDate(date);
  return parsed ? formatter.format(parsed) : '';
}

function formatDateLong(date) {
  const formatter = new Intl.DateTimeFormat('pt-BR', {
    day: '2-digit',
    month: 'long',
  });
  const parsed = toDate(date);
  return parsed ? formatter.format(parsed) : '';
}

function calculateCountdown(date) {
  const today = new Date();
  const target = toDate(date);
  if (!target) return '';
  const diff = target - today;
  if (Number.isNaN(diff)) return '';
  const days = Math.ceil(diff / (1000 * 60 * 60 * 24));
  if (days < 0) return 'Prazo encerrado';
  if (days === 0) return 'Encerra hoje';
  if (days === 1) return '1 dia restante';
  return `${days} dias restantes`;
}

function addDays(base, amount) {
  const reference = toDate(base) ?? new Date();
  const result = new Date(reference);
  result.setDate(result.getDate() + amount);
  return result.toISOString().slice(0, 10);
}

function formatRelativeTime(value) {
  const target = toDate(value);
  if (!target) return '';
  const diffMs = target.getTime() - Date.now();
  const diffMinutes = Math.round(diffMs / 60000);
  const absMinutes = Math.abs(diffMinutes);
  if (absMinutes < 1) return 'agora';
  if (absMinutes < 60) {
    const suffix = diffMinutes < 0 ? 'há' : 'em';
    return `${suffix} ${absMinutes} min`;
  }
  const diffHours = Math.round(diffMinutes / 60);
  const absHours = Math.abs(diffHours);
  if (absHours < 24) {
    const suffix = diffHours < 0 ? 'há' : 'em';
    return `${suffix} ${absHours} h`;
  }
  const diffDays = Math.round(diffHours / 24);
  const absDays = Math.abs(diffDays);
  const suffix = diffDays < 0 ? 'há' : 'em';
  return `${suffix} ${absDays} dia${absDays === 1 ? '' : 's'}`;
}

const numberFormatter = new Intl.NumberFormat('pt-BR');

function formatNumber(value) {
  return numberFormatter.format(value);
}

function generateProtocolNumber() {
  const now = new Date();
  const sequence = Math.floor(Math.random() * 900 + 100);
  const year = now.getFullYear().toString().slice(-2);
  const month = String(now.getMonth() + 1).padStart(2, '0');
  const day = String(now.getDate()).padStart(2, '0');
  return `PSARJ-${year}${month}${day}-${sequence}`;
}

function getRecentServiceUpdates() {
  const today = new Date();
  return services.filter((service) => {
    const updated = toDate(service.updatedAt);
    return (
      updated &&
      updated.getFullYear() === today.getFullYear() &&
      updated.getMonth() === today.getMonth()
    );
  }).length;
}

function getPlatformMetrics() {
  const categories = new Set(services.map((service) => service.category)).size;
  const upcoming = [...deadlines]
    .map((deadline) => ({ ...deadline, date: toDate(deadline.deadline) }))
    .filter((deadline) => deadline.date)
    .sort((a, b) => a.date - b.date);
  const nextDeadline = upcoming[0];
  const openProtocols = supportProtocols.filter((protocol) => protocol.status !== 'Concluído').length;

  return [
    {
      id: 'overview-servicos',
      title: 'Serviços digitais',
      value: formatNumber(services.length),
      unit: 'fluxos',
      description: `${categories} categorias com fluxos padronizados e integrações automáticas.`,
      meta: `${getRecentServiceUpdates()} atualizados neste mês`,
      action: { href: 'servicos.html', label: 'Abrir catálogo' },
    },
    {
      id: 'overview-agenda',
      title: 'Agenda institucional',
      value: formatNumber(deadlines.length),
      unit: 'prazos',
      description: 'Alertas sincronizados com responsáveis, notificações e evidências digitais.',
      meta: nextDeadline ? `Próximo: ${formatDateLong(nextDeadline.deadline)}` : '',
      action: { href: 'agenda.html', label: 'Ver calendário' },
    },
    {
      id: 'overview-suporte',
      title: 'Central de suporte',
      value: formatNumber(supportProtocols.length),
      unit: 'protocolos',
      description: 'Monitoramento de SLA por criticidade e canal de atendimento.',
      meta: `${openProtocols} em andamento`,
      action: { href: 'suporte.html', label: 'Abrir central' },
    },
    {
      id: 'overview-faq',
      title: 'Base de conhecimento',
      value: formatNumber(knowledgeStats.articles),
      unit: 'artigos',
      description: 'Conteúdo colaborativo com vídeos, trilhas e fóruns moderados pelas secretarias.',
      meta: `${knowledgeStats.trails} trilhas de capacitação`,
      action: { href: 'faq.html', label: 'Consultar base' },
    },
  ];
}

function getServiceIndicators() {
  const categories = new Set(services.map((service) => service.category)).size;
  const automatedFlows = services.filter((service) => service.status.toLowerCase().includes('integra'));
  const withMonitoring = services.filter((service) => service.actions.some((action) => action.toLowerCase().includes('acompanh')));

  return [
    {
      id: 'servicos-total',
      title: 'Fluxos publicados',
      value: formatNumber(services.length),
      unit: 'serviços',
      description: `${categories} categorias com governança compartilhada.`,
      meta: `${getRecentServiceUpdates()} atualizados recentemente`,
    },
    {
      id: 'servicos-integrados',
      title: 'Integrações ativas',
      value: formatNumber(automatedFlows.length || 8),
      unit: 'conexões',
      description: 'Integrações com SEFAZ, RH Digital, assinatura eletrônica e analytics.',
      meta: 'Conectores homologados pelo PRODERJ',
    },
    {
      id: 'servicos-monitorados',
      title: 'Monitoramento em tempo real',
      value: formatNumber(withMonitoring.length || services.length),
      unit: 'fluxos',
      description: 'Painéis com SLA, satisfação e tempo médio de atendimento.',
      meta: 'Indicadores renovados a cada 30 min',
    },
  ];
}

function getServiceHighlights(limit = 4) {
  return [...services]
    .sort((a, b) => {
      const dateA = toDate(a.updatedAt) ?? new Date(0);
      const dateB = toDate(b.updatedAt) ?? new Date(0);
      return dateB - dateA;
    })
    .slice(0, limit)
    .map((service) => ({
      title: service.name,
      subtitle: `Atualizado em ${formatDate(service.updatedAt)}`,
      detail: service.status,
      href: `servicos.html#${service.id}`,
    }));
}

function getAgendaIndicators() {
  const today = new Date();
  const sorted = [...deadlines]
    .map((item) => ({ ...item, date: toDate(item.deadline) }))
    .filter((item) => item.date)
    .sort((a, b) => a.date - b.date);
  const next = sorted[0];
  const withinSeven = sorted.filter((item) => {
    const diff = Math.ceil((item.date - today) / (1000 * 60 * 60 * 24));
    return diff >= 0 && diff <= 7;
  }).length;

  return [
    {
      id: 'agenda-total',
      title: 'Prazos monitorados',
      value: formatNumber(deadlines.length),
      unit: 'marcos',
      description: 'Consolidados com notificações automáticas e trilha de auditoria.',
      meta: `${withinSeven} vencem em até 7 dias`,
    },
    {
      id: 'agenda-proximo',
      title: 'Próximo marco',
      value: next ? formatDate(next.deadline) : '--',
      unit: next ? next.title : '',
      description: next ? next.description : 'Nenhum prazo cadastrado.',
      meta: next ? calculateCountdown(next.deadline) : '',
    },
    {
      id: 'agenda-responsaveis',
      title: 'Responsáveis notificados',
      value: formatNumber(agendaContacts.length * 5),
      unit: 'contatos',
      description: 'Equipes cadastradas por secretaria com alertas em múltiplos canais.',
      meta: 'Atualização diária',
    },
  ];
}

function getSupportIndicators() {
  const open = supportProtocols.filter((protocol) => protocol.status !== 'Concluído').length;
  const closed = supportProtocols.length - open;
  return [
    {
      id: 'suporte-abertos',
      title: 'Chamados ativos',
      value: formatNumber(open),
      unit: 'protocolos',
      description: 'Atendimento priorizado por criticidade e órgão demandante.',
      meta: `${closed} concluídos esta semana`,
    },
    {
      id: 'suporte-sla',
      title: 'SLA médio',
      value: '12',
      unit: 'min',
      description: 'Tempo médio de primeira resposta no chat autenticado.',
      meta: 'Monitoramento contínuo 24/7',
    },
    {
      id: 'suporte-satisfacao',
      title: 'Satisfação',
      value: '4,9',
      unit: '/5',
      description: 'Avaliação dos atendimentos críticos e recorrentes.',
      meta: 'Baseado em pesquisas pós-chamado',
    },
  ];
}

function computeSupportSummary() {
  const open = supportProtocols.filter((protocol) => protocol.status !== 'Concluído');
  const upcoming = open
    .map((protocol) => ({ ...protocol, date: toDate(protocol.deadline) }))
    .filter((protocol) => protocol.date)
    .sort((a, b) => a.date - b.date)[0];

  let lastProtocol = null;
  try {
    const stored = localStorage.getItem(LAST_PROTOCOL_KEY);
    lastProtocol = stored ? JSON.parse(stored) : null;
  } catch (error) {
    lastProtocol = null;
  }

  const items = [
    {
      title: 'Chamados em andamento',
      subtitle: `${formatNumber(open.length)} ativos`,
      detail: upcoming ? `Próximo prazo ${formatDate(upcoming.deadline)}` : 'Sem prazos críticos',
    },
    {
      title: 'Tempo médio de resposta',
      subtitle: '12 minutos',
      detail: 'Chat autenticado com plantão dedicado',
    },
    {
      title: 'Artigos sugeridos',
      subtitle: `${formatNumber(faqs.length)} FAQs vinculadas`,
      detail: 'Automação reduz reincidência de chamados',
    },
  ];

  if (lastProtocol?.protocol && lastProtocol?.timestamp) {
    items.push({
      title: 'Último protocolo registrado',
      subtitle: lastProtocol.protocol,
      detail: formatRelativeTime(lastProtocol.timestamp),
    });
  }

  return items;
}

function getKnowledgeIndicators() {
  return [
    {
      id: 'faq-artigos',
      title: 'Artigos publicados',
      value: formatNumber(knowledgeStats.articles),
      unit: 'artigos',
      description: 'Conteúdo revisado em parceria com as secretarias estaduais.',
      meta: `${knowledgeStats.videos} vídeos complementares`,
    },
    {
      id: 'faq-perguntas',
      title: 'Perguntas frequentes',
      value: formatNumber(faqs.length),
      unit: 'FAQs',
      description: 'Organizadas por tema, serviço e secretaria responsável.',
      meta: 'Pesquisa rápida integrada ao portal',
    },
    {
      id: 'faq-satisfacao',
      title: 'Satisfação média',
      value: knowledgeStats.satisfaction.toFixed(1).replace('.', ','),
      unit: '/5',
      description: 'Avaliações coletadas após atendimentos e trilhas de capacitação.',
      meta: `${formatNumber(knowledgeStats.feedbackCount)} respostas analisadas`,
    },
    {
      id: 'faq-colaboradores',
      title: 'Secretarias colaboradoras',
      value: formatNumber(knowledgeStats.contributors),
      unit: 'órgãos',
      description: 'Equipes responsáveis por atualizar e validar conteúdos críticos.',
      meta: 'Curadoria coordenada pela SAD/RJ',
    },
  ];
}

function renderInsightGrid(selector, metrics) {
  const container = typeof selector === 'string' ? document.querySelector(selector) : selector;
  if (!container) return;
  container.replaceChildren();
  metrics.forEach((metric) => {
    const card = document.createElement('article');
    card.className = 'insight-card';
    card.setAttribute('role', 'listitem');
    card.innerHTML = `
      <div class="insight-card__value">
        <span>${metric.value}</span>
        ${metric.unit ? `<small>${metric.unit}</small>` : ''}
      </div>
      <h3 class="insight-card__title">${metric.title}</h3>
      <p class="insight-card__description">${metric.description}</p>
      ${metric.meta ? `<p class="insight-card__meta">${metric.meta}</p>` : ''}
      ${metric.action ? `<a class="insight-card__action" href="${metric.action.href}">${metric.action.label}</a>` : ''}
    `;
    container.append(card);
  });
}

function renderPlatformOverview() {
  renderInsightGrid('#resumo-plataforma', getPlatformMetrics());
}

function renderServiceInsights() {
  renderInsightGrid('#indicadores-servicos', getServiceIndicators());
}

function renderAgendaInsights() {
  renderInsightGrid('#indicadores-agenda', getAgendaIndicators());
}

function renderSupportInsights() {
  renderInsightGrid('#indicadores-suporte', getSupportIndicators());
}

function renderKnowledgeInsights() {
  renderInsightGrid('#indicadores-faq', getKnowledgeIndicators());
}

function renderIntegrationMap() {
  const container = document.querySelector('#mapa-integracoes');
  if (!container) return;
  container.replaceChildren();
  integrationMap.forEach((entry) => {
    const card = document.createElement('article');
    card.className = 'integration-card';
    card.setAttribute('role', 'listitem');
    card.innerHTML = `
      <h3>${entry.title}</h3>
      <p>${entry.description}</p>
    `;
    const list = document.createElement('ul');
    list.className = 'integration-card__list';
    entry.connections.forEach((connection) => {
      const item = document.createElement('li');
      item.innerHTML = `<strong>${connection.target}</strong><span>${connection.detail}</span>`;
      list.append(item);
    });
    card.append(list);
    container.append(card);
  });
}

function renderAsideList(selector, items) {
  const container = document.querySelector(selector);
  if (!container) return;
  container.replaceChildren();
  items.forEach((item) => {
    const li = document.createElement('li');
    li.className = 'module-aside__item';
    if (item.href) {
      const link = document.createElement('a');
      link.href = item.href;
      link.className = 'module-aside__link';
      link.innerHTML = `
        <strong>${item.title}</strong>
        ${item.subtitle ? `<span class="module-aside__meta">${item.subtitle}</span>` : ''}
        ${item.detail ? `<span class="module-aside__meta">${item.detail}</span>` : ''}
        ${item.description ? `<span class="module-aside__meta">${item.description}</span>` : ''}
      `;
      li.append(link);
    } else {
      const strong = document.createElement('strong');
      strong.textContent = item.title;
      li.append(strong);
      if (item.subtitle) {
        const subtitle = document.createElement('span');
        subtitle.className = 'module-aside__meta';
        subtitle.textContent = item.subtitle;
        li.append(subtitle);
      }
      if (item.detail) {
        const detail = document.createElement('span');
        detail.className = 'module-aside__meta';
        detail.textContent = item.detail;
        li.append(detail);
      }
    }
    container.append(li);
  });
}

function renderAgendaContactsList(selector = '#agenda-responsaveis') {
  const container = document.querySelector(selector);
  if (!container) return;
  container.replaceChildren();
  agendaContacts.forEach((contact) => {
    const term = document.createElement('dt');
    term.textContent = contact.area;
    const description = document.createElement('dd');
    description.innerHTML = `<strong>${contact.owner}</strong><span>${contact.responsibility}</span>`;
    container.append(term, description);
  });
}

function renderMatrix(containerSelector, data, headers = ['Área', 'Responsabilidades', 'Integrações']) {
  const container = document.querySelector(containerSelector);
  if (!container) return;
  container.replaceChildren();
  container.classList.add('data-table');
  container.setAttribute('role', 'table');

  const headerGroup = document.createElement('div');
  headerGroup.className = 'data-table__header';
  headerGroup.setAttribute('role', 'rowgroup');
  const headerRow = document.createElement('div');
  headerRow.className = 'data-table__row data-table__row--header';
  headerRow.setAttribute('role', 'row');

  headers.forEach((header) => {
    const cell = document.createElement('div');
    cell.className = 'data-table__cell data-table__cell--header';
    cell.setAttribute('role', 'columnheader');
    cell.textContent = header;
    headerRow.append(cell);
  });

  headerGroup.append(headerRow);
  container.append(headerGroup);

  const bodyGroup = document.createElement('div');
  bodyGroup.className = 'data-table__body';
  bodyGroup.setAttribute('role', 'rowgroup');

  data.forEach((item) => {
    const row = document.createElement('div');
    row.className = 'data-table__row';
    row.setAttribute('role', 'row');

    const areaCell = document.createElement('div');
    areaCell.className = 'data-table__cell';
    areaCell.setAttribute('role', 'cell');
    areaCell.innerHTML = `<strong>${item.area}</strong>${item.lead ? `<span class="data-table__note">${item.lead}</span>` : ''}`;

    const responsibilitiesCell = document.createElement('div');
    responsibilitiesCell.className = 'data-table__cell';
    responsibilitiesCell.setAttribute('role', 'cell');
    const responsibilitiesList = document.createElement('ul');
    responsibilitiesList.className = 'data-table__list';
    item.responsibilities.forEach((responsibility) => {
      const listItem = document.createElement('li');
      listItem.textContent = responsibility;
      responsibilitiesList.append(listItem);
    });
    responsibilitiesCell.append(responsibilitiesList);

    const integrationsCell = document.createElement('div');
    integrationsCell.className = 'data-table__cell';
    integrationsCell.setAttribute('role', 'cell');
    const integrations = Array.isArray(item.integrations) ? item.integrations : [item.integrations];
    const integrationsList = document.createElement('ul');
    integrationsList.className = 'data-table__list data-table__list--inline';
    integrations.filter(Boolean).forEach((integration) => {
      const listItem = document.createElement('li');
      listItem.textContent = integration;
      integrationsList.append(listItem);
    });
    integrationsCell.append(integrationsList);

    row.append(areaCell, responsibilitiesCell, integrationsCell);
    bodyGroup.append(row);
  });

  container.append(bodyGroup);
}

function renderSupportChannels(selector, { limit } = {}) {
  const container = document.querySelector(selector);
  if (!container) return;
  container.replaceChildren();
  const items = typeof limit === 'number' ? supportChannels.slice(0, limit) : supportChannels;
  items.forEach((channel) => {
    const li = document.createElement('li');
    li.innerHTML = `
      <strong>${channel.name}:</strong>
      ${channel.description}
      <span class="support-section__channel-meta">${channel.availability} · ${channel.sla}</span>
    `;
    container.append(li);
  });
}

function renderSupportIndicatorsList() {
  renderAsideList('#suporte-indicadores', computeSupportSummary());
}

function renderCollections() {
  renderAsideList('#faq-colecoes', faqCollections);
}

function renderServiceHighlightsList() {
  renderAsideList('#servicos-destaques', getServiceHighlights());
}

function renderSupportHighlights() {
  renderSupportChannels('#canais-suporte-destaque', { limit: 3 });
  renderSupportChannels('#canais-suporte');
}

function renderAgendaMatrix() {
  renderMatrix('#matriz-agenda', agendaMatrix);
}

function renderServiceMatrix() {
  renderMatrix('#matriz-responsabilidades-grid', serviceResponsibilityMatrix);
}

function renderKnowledgeMatrix() {
  renderMatrix('#matriz-conhecimento', knowledgeMatrix, ['Eixo', 'Processos colaborativos', 'Integrações']);
}

function renderSupportProtocols() {
  const container = document.querySelector('#tabela-protocolos');
  if (!container) return;
  const headers = ['Protocolo', 'Serviço', 'Status', 'Prazo', 'Canal'];
  const rows = [...supportProtocols]
    .map((protocol) => ({
      ...protocol,
      date: toDate(protocol.deadline),
    }))
    .sort((a, b) => (b.date ?? 0) - (a.date ?? 0))
    .map((protocol) => [
      { type: 'stacked', primary: protocol.protocol, secondary: protocol.requester },
      { type: 'text', text: protocol.service },
      { type: 'badge', text: protocol.status },
      { type: 'text', text: formatDate(protocol.deadline) },
      { type: 'text', text: protocol.channel },
    ]);

  renderTable(container, { headers, rows });
}

function renderTable(container, { headers, rows }) {
  const target = typeof container === 'string' ? document.querySelector(container) : container;
  if (!target) return;
  target.replaceChildren();
  target.classList.add('data-table');
  target.setAttribute('role', 'table');

  const headerGroup = document.createElement('div');
  headerGroup.className = 'data-table__header';
  headerGroup.setAttribute('role', 'rowgroup');
  const headerRow = document.createElement('div');
  headerRow.className = 'data-table__row data-table__row--header';
  headerRow.setAttribute('role', 'row');
  headers.forEach((header) => {
    const cell = document.createElement('div');
    cell.className = 'data-table__cell data-table__cell--header';
    cell.setAttribute('role', 'columnheader');
    cell.textContent = header;
    headerRow.append(cell);
  });
  headerGroup.append(headerRow);
  target.append(headerGroup);

  const bodyGroup = document.createElement('div');
  bodyGroup.className = 'data-table__body';
  bodyGroup.setAttribute('role', 'rowgroup');

  rows.forEach((cells) => {
    const row = document.createElement('div');
    row.className = 'data-table__row';
    row.setAttribute('role', 'row');
    cells.forEach((cellData) => {
      const cell = document.createElement('div');
      cell.className = 'data-table__cell';
      cell.setAttribute('role', 'cell');
      renderCellContent(cell, cellData);
      row.append(cell);
    });
    bodyGroup.append(row);
  });

  target.append(bodyGroup);
}

function renderCellContent(element, value) {
  const cell = normalizeCell(value);
  switch (cell.type) {
    case 'stacked': {
      const wrapper = document.createElement('div');
      wrapper.className = 'data-table__stacked';
      const primary = document.createElement('strong');
      primary.textContent = cell.primary ?? '';
      const secondary = document.createElement('span');
      secondary.className = 'data-table__note';
      secondary.textContent = cell.secondary ?? '';
      wrapper.append(primary, secondary);
      element.append(wrapper);
      break;
    }
    case 'badge': {
      const badge = document.createElement('span');
      badge.className = 'data-table__badge';
      badge.textContent = cell.text ?? '';
      element.append(badge);
      break;
    }
    case 'list': {
      const list = document.createElement('ul');
      list.className = 'data-table__list';
      cell.items.forEach((item) => {
        const li = document.createElement('li');
        li.textContent = item;
        list.append(li);
      });
      element.append(list);
      break;
    }
    default: {
      element.textContent = cell.text ?? '';
    }
  }
}

function normalizeCell(value) {
  if (value && typeof value === 'object' && 'type' in value) {
    return value;
  }
  if (Array.isArray(value)) {
    return { type: 'list', items: value };
  }
  return { type: 'text', text: value ?? '' };
}

function renderServices(filter, query) {
  const container = document.querySelector('#lista-servicos');
  if (!container) return;
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
  if (!timeline && !agendaList) return;

  if (timeline) {
    timeline.replaceChildren();
  }

  if (agendaList) {
    agendaList.replaceChildren();
  }

  const upcoming = [...deadlines].sort(
    (a, b) => new Date(a.deadline) - new Date(b.deadline),
  );

  if (timeline) {
    upcoming.slice(0, 3).forEach((item) => {
      const entry = document.createElement('li');
      entry.textContent = `${formatDate(item.deadline)} · ${item.title}`;
      timeline.append(entry);
    });
  }

  if (agendaList) {
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
}

function updateCountdowns() {
  document.querySelectorAll('[data-deadline]').forEach((element) => {
    const deadline = element.dataset.deadline;
    element.textContent = calculateCountdown(deadline);
  });
}

function renderFaq() {
  const container = document.querySelector('#faq-list');
  if (!container) return;
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
  const triggers = document.querySelectorAll('[data-scroll-to]');
  const prefersReducedMotion = window.matchMedia?.('(prefers-reduced-motion: reduce)')?.matches ?? false;
  triggers.forEach((trigger) => {
    trigger.addEventListener('click', (event) => {
      const targetId = trigger.dataset.scrollTo;
      if (!targetId) return;
      const section = document.getElementById(targetId);
      if (!section) return;
      event.preventDefault();
      section.scrollIntoView(
        prefersReducedMotion ? { block: 'start' } : { behavior: 'smooth', block: 'start' },
      );
    });
  });
}

function setupFilters() {
  const searchInput = document.querySelector('#busca-servicos');
  const filterButtons = document.querySelectorAll('.filter-button');
  const container = document.querySelector('#lista-servicos');
  if (!searchInput || !filterButtons.length || !container) return;
  const storedFilter = getFromStorage(FILTER_STORAGE_KEY) ?? 'todos';
  const storedQuery = getFromStorage(QUERY_STORAGE_KEY) ?? '';
  let currentFilter = storedFilter;
  let currentQuery = storedQuery;

  searchInput.value = currentQuery;
  let hasActiveFilter = false;
  filterButtons.forEach((btn) => {
    const matches = (btn.dataset.filter ?? 'todos') === currentFilter;
    btn.classList.toggle('is-active', matches);
    if (matches) hasActiveFilter = true;
  });

  if (!hasActiveFilter) {
    currentFilter = 'todos';
    filterButtons.forEach((btn, index) => {
      btn.classList.toggle('is-active', index === 0);
    });
  }

  renderServices(currentFilter, currentQuery);

  searchInput.addEventListener('input', (event) => {
    currentQuery = event.target.value;
    setInStorage(QUERY_STORAGE_KEY, currentQuery);
    renderServices(currentFilter, currentQuery);
  });

  filterButtons.forEach((button) => {
    button.addEventListener('click', () => {
      filterButtons.forEach((btn) => btn.classList.remove('is-active'));
      button.classList.add('is-active');
      currentFilter = button.dataset.filter ?? 'todos';
      setInStorage(FILTER_STORAGE_KEY, currentFilter);
      renderServices(currentFilter, currentQuery);
    });
  });
}

function setupSupportForm() {
  const form = document.querySelector('.support-section__form');
  if (!form) return;
  const disclaimer = form.querySelector('.support-section__disclaimer');

  form.addEventListener('submit', (event) => {
    event.preventDefault();
    const formData = new FormData(form);
    const name = String(formData.get('nome') ?? '').trim();
    const orgao = String(formData.get('orgao') ?? '').trim() || 'Órgão não informado';
    const protocol = generateProtocolNumber();
    const deadline = addDays(new Date(), 2);

    supportProtocols = [
      {
        protocol,
        requester: orgao,
        service: 'Atendimento personalizado',
        status: 'Novo',
        deadline,
        channel: 'Portal de chamados',
      },
      ...supportProtocols,
    ].slice(0, 8);

    setInStorage(
      LAST_PROTOCOL_KEY,
      JSON.stringify({ protocol, timestamp: new Date().toISOString() }),
    );

    disclaimer.textContent = `Chamado registrado! ${name ? `${name}, ` : ''}você receberá o protocolo ${protocol} por e-mail.`;
    form.reset();

    renderSupportProtocols();
    renderSupportIndicatorsList();
    renderSupportInsights();
  });
}

function highlightCurrentNavigation() {
  const links = document.querySelectorAll('.top-bar__link');
  if (!links.length) return;
  const rawPath = window.location.pathname.split('/').pop();
  const currentPath = rawPath && rawPath !== '/' ? rawPath : 'index.html';
  links.forEach((link) => {
    const href = link.getAttribute('href');
    if (!href) return;
    const target = href.split('#')[0] || 'index.html';
    if (target === currentPath) {
      link.classList.add('is-active');
    }
  });
}

window.addEventListener('DOMContentLoaded', () => {
  highlightCurrentNavigation();
  renderPlatformOverview();
  renderIntegrationMap();
  renderServiceInsights();
  renderServiceHighlightsList();
  renderAgenda();
  renderAgendaInsights();
  renderAgendaContactsList();
  renderAgendaMatrix();
  renderFaq();
  renderCollections();
  renderKnowledgeInsights();
  renderKnowledgeMatrix();
  renderSupportHighlights();
  renderSupportInsights();
  renderSupportIndicatorsList();
  renderSupportProtocols();
  setupFilters();
  setupSupportForm();
  handleNavigation();
});

INSERT INTO usuarios (nome, email, senha_hash, perfil, ativo)
VALUES ('Administrador', 'admin@paroquia.local', '$2y$10$H5FeoJEB6Digw1k3D6Z0suQX1iG.yUpBAkLTlaX2UjsFvdcGaVbLW', 'Administrador', 1);

INSERT INTO parametros (chave, valor) VALUES
('paroquia_nome', 'Paróquia Santo Agostinho e Santa Rita de Cássia'),
('smtp_host', 'smtp.example.com'),
('sacramento_batismo_livro', '1'),
('sacramento_batismo_folha', '1'),
('sacramento_batismo_termo', '1');

INSERT INTO pessoas (nome, cpf, email, cidade, uf)
VALUES ('Maria dos Santos', '12345678901', 'maria@example.com', 'Rio de Janeiro', 'RJ'),
       ('João Silva', '22233344455', 'joao@example.com', 'Niterói', 'RJ');

INSERT INTO sacramentos (pessoa_id, tipo, data, livro, folha, termo, celebrante, local, codigo_verificacao)
VALUES (1, 'batismo', '2020-01-10', '1', '2', '15', 'Pe. Antônio', 'Matriz', 'ABC123');

INSERT INTO intencoes_missa (data, horario, ofertante_nome, status)
VALUES ('2024-05-01', '09:00:00', 'Família Souza', 'pendente');

INSERT INTO agenda (tipo, titulo, data_inicio, data_fim, local, responsavel, publicado)
VALUES ('missa', 'Missa Dominical', '2024-05-05 09:00:00', '2024-05-05 10:00:00', 'Igreja Matriz', 'Pe. Carlos', 1);

INSERT INTO catequese_turmas (nome, etapa, ano, dia_semana, horario, responsavel)
VALUES ('Turma Crisma A', 'crisma', 2024, 'Sábado', '15:00', 'Ir. Ana');

INSERT INTO catequese_alunos (pessoa_id, turma_id, status)
VALUES (2, 1, 'ativo');

INSERT INTO financeiro_lanc (data, tipo, categoria, descricao, valor)
VALUES ('2024-05-01', 'entrada', 'dízimo', 'Ofertas da missa', 850.00);

INSERT INTO cms_paginas (slug, titulo, conteudo_html, publicado)
VALUES ('bem-vindo', 'Bem-vindo à Paróquia', '<p>Seja bem-vindo!</p>', 1);

INSERT INTO permissoes (perfil, modulo, acao, permitido) VALUES
('Secretaria','pessoas','index',1),
('Secretaria','pessoas','create',1),
('Secretaria','pessoas','edit',1),
('Secretaria','pessoas','destroy',1),
('Secretaria','sacramentos','index',1),
('Secretaria','intencoes','index',1),
('Financeiro','financeiro','index',1),
('Catequese','catequese','turmas',1),
('Secretaria','pessoas','merge',1),
('Secretaria','pessoas','export',1),
('Secretaria','pessoas','import',1),
('Secretaria','pessoas','email',1),
('Secretaria','pessoas','history',1),
('Secretaria','sacramentos','create',1),
('Secretaria','sacramentos','edit',1),
('Secretaria','sacramentos','destroy',1),
('Secretaria','sacramentos','export',1),
('Secretaria','sacramentos','certidao',1),
('Secretaria','sacramentos','ata',1),
('Secretaria','intencoes','approve',1),
('Secretaria','intencoes','celebrate',1),
('Secretaria','intencoes','recibo',1),
('Secretaria','intencoes','comprovante',1),
('Secretaria','intencoes','bulk',1),
('Secretaria','intencoes','export',1),
('Secretaria','agenda','index',1),
('Secretaria','agenda','create',1),
('Secretaria','agenda','edit',1),
('Secretaria','agenda','destroy',1),
('Secretaria','agenda','ics',1),
('Secretaria','agenda','export',1),
('Secretaria','agenda','publicar',1),
('Secretaria','agenda','calendar',1),
('Secretaria','agenda','relatorio',1),
('Financeiro','financeiro','create',1),
('Financeiro','financeiro','edit',1),
('Financeiro','financeiro','destroy',1),
('Financeiro','financeiro','resumo',1),
('Financeiro','financeiro','relatorio',1),
('Financeiro','financeiro','export',1),
('Catequese','catequese','alunos',1),
('Catequese','catequese','presenca',1),
('Catequese','catequese','relatorio',1),
('Catequese','catequese','export',1),
('Comunicacao','cms','paginas',1),
('Comunicacao','cms','create',1),
('Comunicacao','cms','edit',1),
('Comunicacao','cms','destroy',1),
('Comunicacao','cms','preview',1);

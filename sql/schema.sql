CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha_hash VARCHAR(255) NOT NULL,
    perfil ENUM('Administrador','Secretaria','Catequese','Financeiro','Pastoral','Comunicacao') NOT NULL,
    ativo TINYINT(1) DEFAULT 1,
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE pessoas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(180) NOT NULL,
    cpf VARCHAR(14) UNIQUE,
    rg VARCHAR(30),
    dt_nasc DATE,
    email VARCHAR(150),
    tel VARCHAR(30),
    endereco VARCHAR(255),
    bairro VARCHAR(120),
    cidade VARCHAR(120),
    uf CHAR(2),
    cep VARCHAR(9),
    obs TEXT,
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE sacramentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pessoa_id INT NOT NULL,
    tipo ENUM('batismo','eucaristia','crisma','matrimonio') NOT NULL,
    data DATE,
    livro VARCHAR(20),
    folha VARCHAR(20),
    termo VARCHAR(20),
    celebrante VARCHAR(150),
    local VARCHAR(150),
    codigo_verificacao VARCHAR(20) UNIQUE,
    obs TEXT,
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pessoa_id) REFERENCES pessoas(id)
);

CREATE TABLE intencoes_missa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data DATE,
    horario TIME,
    ofertante_nome VARCHAR(150) NOT NULL,
    ofertante_contato VARCHAR(150),
    intencao_texto TEXT,
    valor DECIMAL(10,2),
    status ENUM('pendente','confirmada','celebrada','cancelada') DEFAULT 'pendente',
    comprovante_path VARCHAR(255),
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE agenda (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo ENUM('missa','encontro','reuniao','catequese') NOT NULL,
    titulo VARCHAR(180) NOT NULL,
    descricao TEXT,
    data_inicio DATETIME NOT NULL,
    data_fim DATETIME,
    local VARCHAR(150),
    responsavel VARCHAR(150),
    publicado TINYINT(1) DEFAULT 0,
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE catequese_turmas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    etapa ENUM('batismo','primeira eucaristia','crisma') NOT NULL,
    ano INT,
    dia_semana VARCHAR(40),
    horario VARCHAR(20),
    responsavel VARCHAR(150)
);

CREATE TABLE catequese_alunos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pessoa_id INT NOT NULL,
    turma_id INT NOT NULL,
    status ENUM('ativo','concluido','desligado') DEFAULT 'ativo',
    obs TEXT,
    FOREIGN KEY (pessoa_id) REFERENCES pessoas(id),
    FOREIGN KEY (turma_id) REFERENCES catequese_turmas(id)
);

CREATE TABLE presencas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    turma_id INT NOT NULL,
    pessoa_id INT NOT NULL,
    data DATE NOT NULL,
    presente TINYINT(1) DEFAULT 0,
    obs TEXT,
    UNIQUE KEY uniq_presenca (turma_id, pessoa_id, data),
    FOREIGN KEY (turma_id) REFERENCES catequese_turmas(id),
    FOREIGN KEY (pessoa_id) REFERENCES pessoas(id)
);

CREATE TABLE financeiro_lanc (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data DATE NOT NULL,
    tipo ENUM('entrada','saida') NOT NULL,
    categoria VARCHAR(120) NOT NULL,
    descricao TEXT,
    valor DECIMAL(12,2) NOT NULL,
    pessoa_id INT NULL,
    referencia VARCHAR(120),
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pessoa_id) REFERENCES pessoas(id)
);

CREATE TABLE cms_paginas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(120) UNIQUE NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    conteudo_html TEXT,
    publicado TINYINT(1) DEFAULT 0,
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    atualizado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE auditoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    acao VARCHAR(80),
    tabela VARCHAR(80),
    registro_id INT,
    ip VARCHAR(45),
    detalhes TEXT,
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE parametros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    chave VARCHAR(120) UNIQUE NOT NULL,
    valor TEXT
);

CREATE TABLE permissoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    perfil ENUM('Administrador','Secretaria','Catequese','Financeiro','Pastoral','Comunicacao') NOT NULL,
    modulo VARCHAR(80) NOT NULL,
    acao VARCHAR(80) NOT NULL,
    permitido TINYINT(1) DEFAULT 0,
    UNIQUE KEY uniq_permissao (perfil, modulo, acao)
);

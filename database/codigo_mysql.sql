-- 1) Criação da database
CREATE DATABASE clinica_escolar;
USE clinica_escolar;

-- 2) Criação da tabela medicos

CREATE TABLE medicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
);


-- 3) Criação da tabela alunos

CREATE TABLE alunos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_aluno VARCHAR(6) NOT NULL UNIQUE,    
    nome VARCHAR(100) NOT NULL,
    turma VARCHAR(50),
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    email_verificado TINYINT(1) NOT NULL DEFAULT 0,
    token_verificacao VARCHAR(64) NULL          -- usado para email de verificação
);


-- 4) Tabela: horarios 

CREATE TABLE horarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    medico_id INT NOT NULL,
    data DATE NOT NULL,
    hora TIME NOT NULL,
    disponivel TINYINT(1) NOT NULL DEFAULT 1,
    FOREIGN KEY (medico_id) REFERENCES medicos(id)
);

-- 5) Tabela: consultas

CREATE TABLE consultas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT NOT NULL,
    medico_id INT NOT NULL,
    data DATE NOT NULL,
    hora TIME NOT NULL,

    -- O site usa estes 2 estados de consulta
    status ENUM('marcada','cancelada') NOT NULL DEFAULT 'marcada',


    FOREIGN KEY (aluno_id) REFERENCES alunos(id),
    FOREIGN KEY (medico_id) REFERENCES medicos(id)
);

-- Médicos 
INSERT INTO medicos (nome) VALUES
('Dr. Quévin Tavares'),
('Dr. João Salomão'),
('Dr. André Barroso');
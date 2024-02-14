-- Criar o banco de dados salario
CREATE DATABASE IF NOT EXISTS salario;

-- Usa o banco de dados salario
USE salario;

-- tabela usuario com os campos id, nome, email, senha e data_cadastro
CREATE TABLE usuario (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(20) NOT NULL,
  sobrenome VARCHAR(50) NOT NULL,
  email VARCHAR(50) UNIQUE NOT NULL,
  senha CHAR(64) NOT NULL, -- para armazenar o hash da senha criptografada.
  data_cadastro DATE NOT NULL,
  conta_verificada BOOLEAN
);

-- tabela ferias_dados com os campos valor_salario, data_inicio, data_final, inss, irrf e valor_liquido
CREATE TABLE ferias_dados (
  id INT PRIMARY KEY AUTO_INCREMENT,
  id_usuario INT NOT NULL,
  valor_salario DECIMAL(10,2) NOT NULL,
  quantidade_dias INT NOT NULL,
  salario_ferias DECIMAL(10,2) NOT NULL,
  terco DECIMAL(10,2) NOT NULL,
  valor_com_terco DECIMAL(10,2) NOT NULL,
  inss DECIMAL(10,2) NOT NULL,
  irrf DECIMAL(10,2) NOT NULL,
  valor_liquido DECIMAL(10,2) NOT NULL,
  data_busca DATETIME NOT NULL,
  FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE ferias_contando_dias_uteis (
  id INT PRIMARY KEY AUTO_INCREMENT,
  id_usuario INT NOT NULL,
  valor_salario DECIMAL(10,2) NOT NULL,
  salario_ferias DECIMAL(10,2) NOT NULL,
  terco DECIMAL(10,2) NOT NULL,
  valor_com_terco DECIMAL(10,2) NOT NULL,
  inss DECIMAL(10,2) NOT NULL,
  irrf DECIMAL(10,2) NOT NULL,
  valor_liquido DECIMAL(10,2) NOT NULL,
  data_inicio DATE NOT NULL,
  data_final DATE NOT NULL,
  quantidade_dias INT NOT NULL,
  data_busca_ferias DATETIME NOT NULL,
  FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- tabela ferias_proporcionais_dados com os campos valor_salario, meses_trabalhados, inss, irrf, valor_bruto_ferias e valor_liquido
CREATE TABLE ferias_proporcionais (
  id INT PRIMARY KEY AUTO_INCREMENT,
  id_usuario INT NOT NULL,
  valor_salario DECIMAL(10,2) NOT NULL,
  meses_trabalhados INT NOT NULL,
  ferias_proporcionais DECIMAL(10,2) NOT NULL,
  terco_ferias DECIMAL(10,2) NOT NULL,
  valor_bruto_ferias DECIMAL(10,2) NOT NULL,
  inss_ferias DECIMAL(10,2) NOT NULL,
  irrf_ferias DECIMAL(10,2) NOT NULL,
  ferias_liquida DECIMAL(10,2) NOT NULL,
  quantidade_dias INT NOT NULL,
  data_busca_proporcionais DATETIME NOT NULL,
  FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- tabela abono_pecuniario com os campos venda_ferias_liquida, abono_pecuniario, abono_com_terco
CREATE TABLE venda_ferias (
  id INT PRIMARY KEY AUTO_INCREMENT,
  id_usuario INT NOT NULL,
  valor_salario DECIMAL(10,2) NOT NULL,
  terco_ferias DECIMAL(10,2) NOT NULL,
  salario_ferias_inss DECIMAL(10,2) NOT NULL,
  abono_pecuniario DECIMAL(10,2) NOT NULL,
  terco_abono DECIMAL(10,2) NOT NULL,
  salario_com_tercos DECIMAL(10,2) NOT NULL,
  inss_abono DECIMAL(10,2) NOT NULL,
  irrf_abono DECIMAL(10,2) NOT NULL,
  venda_ferias_liquida DECIMAL(10,2) NOT NULL,
  data_busca_venda DATETIME NOT NULL,
  FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE ON UPDATE CASCADE
);



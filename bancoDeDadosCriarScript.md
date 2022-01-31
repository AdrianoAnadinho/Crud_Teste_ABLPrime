Criando o banco de dados:

CREATE DATABASE crudbd DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci


Criando a tabela clientes:

CREATE TABLE cliente (
	id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(60) NOT NULL,
    cpf VARCHAR(15) NOT NULL,
    dataNasc DATE NOT NULL,
    email VARCHAR(45) NOT NULL,
    logradouro VARCHAR(45) NOT NULL,
    numero INT NOT NULL,
    bairro VARCHAR(45) NOT NULL,
    cidade VARCHAR(45) NOT NULL,
    uf VARCHAR(2) NOT NULL,
    cep VARCHAR(9) NOT NULL,
    PRIMARY KEY(id)
);

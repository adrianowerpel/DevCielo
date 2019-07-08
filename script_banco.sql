create table cliente(
	codigo serial4 primary key,
	nome text not null,
	dt_nascimento date not null,
	usuario text not null,
	senha text not null
);

create table cartao(
	id_cartao serial4 primary key,
	numero text not null,
	validade text not null,
	cvc integer not null,
	/*true para credito, false para debito*/
	tipo_cartao boolean not null,
	codigo_cliente integer not null
);

create table endereco(
	id_endereco serial4 primary key,
	logradouro text not null,
	numero integer not null,
	bairro text not null,
	cidade text not null,
	UF text not null,
	codigo_cliente integer not null
);

alter table endereco add foreign key (codigo_cliente) references cliente (codigo);

create table produto(
	id_produto serial4 primary key,
	nome text not null,
	valor numeric(10,2) not null,
	name_image text
);

create table venda(
	id_venda serial4 primary key,
	id_produto integer not null,
	codigo_cliente integer not null,
	id_cartao integer,
	total_compra numeric(10,2),
	payment_id text,
	merchantOrderID text
);

alter table venda add foreign key (id_produto) references produto (id_produto);
alter table venda add foreign key (codigo_cliente) references cliente (codigo);
alter table venda add foreign key (id_cartao) references cartao (id_cartao);

insert into cliente (nome, dt_nascimento) values ('Antonio Fagundes','1986-05-28','antonio','123');
insert into cliente (nome, dt_nascimento) values ('Ana Carolina','1975-08-12','ana','123');
insert into cliente (nome, dt_nascimento) values ('Itamar Franco','1946-10-01','itamar','123');
insert into cliente (nome, dt_nascimento) values ('Maria do Rosário','1955-12-20','maria','123');

insert into cartao (numero, validade, cvc,tipo_cartao, codigo_cliente) values ('0000.0000.0000.0001','12/2020','123',true,1);
insert into cartao (numero, validade, cvc,tipo_cartao, codigo_cliente) values ('0000.0000.0000.0004','12/2018','123',true,2);
insert into cartao (numero, validade, cvc,tipo_cartao, codigo_cliente) values ('0000.0000.0000.0002','12/2021','123',true,3);
insert into cartao (numero, validade, cvc,tipo_cartao, codigo_cliente) values ('0000.0000.0000.0002','12/2021','123',false,4);

insert into endereco (logradouro, numero, bairro, cidade, uf, codigo_cliente) values ('Rua A', 123,'Progresso', 'Juiz de Fora', 'MG',1);
insert into endereco (logradouro, numero, bairro, cidade, uf, codigo_cliente) values ('Rua da Rosa', 1001,'Centro', 'Juiz de Fora', 'MG',2);
insert into endereco (logradouro, numero, bairro, cidade, uf, codigo_cliente) values ('Avenida Paulista', 2050,'Centro', 'São Paulo', 'SP',3);
insert into endereco (logradouro, numero, bairro, cidade, uf, codigo_cliente) values ('Avenida Ipanema', 1255,'Ipanema', 'Rio de Janeiro', 'RJ',4);

insert into produto (nome, valor, name_image) values ('Playstation 4',1600,'play');
insert into produto (nome, valor, name_image) values ('Xbox One',1200,'xbox');
insert into produto (nome, valor, name_image) values ('Xiaomi Redmi Note 5',999,'xiaomi');
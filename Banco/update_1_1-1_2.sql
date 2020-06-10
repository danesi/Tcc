create table nota_empregado ( id_nota_empregado int auto_increment primary key, id_empregado int not null, id_usuario int NOT null, nota int not null, constraint notaEmpregado_empregado foreign key (id_empregado) references empregado (id_usuario), constraint notaEmpregado_usuario foreign key (id_usuario) references usuario (id_usuario) )

create table nota_servico ( id_nota_servico int auto_increment primary key, id_servico int not null, id_usuario int NOT null, nota int not null, constraint notaSservico_servico foreign key (id_servico) references servico (id_servico), constraint notaSmpregado_usuario foreign key (id_usuario) references usuario (id_usuario) )

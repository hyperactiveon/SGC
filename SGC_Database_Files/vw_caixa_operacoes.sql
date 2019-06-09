CREATE VIEW `vw_caixa_operacoes` AS SELECT
c.id as caixa_id,
c.tb_usuarios_id_abertura as usuario_abertura,
(SELECT nome FROM vw_usuarios WHERE id=c.tb_usuarios_id_abertura) as c_nome_usuario_abertura,
DATE_FORMAT(c.dh_abertura,'%d-%m-%Y %H:%i:%s') as dh_abertura,
c.valor_abertura,
c.tb_usuarios_id_fechato as usuario_fechato,
(SELECT nome FROM vw_usuarios WHERE id=c.tb_usuarios_id_fechato) as c_nome_usuario_fechato,
DATE_FORMAT(c.dh_fechato,'%d-%m-%Y %H:%i:%s') as dh_fechato, 
c.valor_fechato,
c.status,
co.id as co_id,
co.tb_usuarios_id,
(SELECT nome FROM tb_usuarios WHERE id=co.tb_usuarios_id) as co_nome_usuario,
co.tipo as co_tipo,
co.operacao as co_operacao,
co.forma as co_formas,
co.valor as co_valor,
DATE_FORMAT(co.datahora,'%d-%m-%Y %H:%i:%s') as co_datahora
FROM
	tb_caixa c RIGHT JOIN 
    tb_caixa_operacao co ON c.id = co.tb_caixa_id
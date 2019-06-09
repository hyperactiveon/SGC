CREATE VIEW `vw_caixa` AS SELECT
c.id,
c.tb_usuarios_id_abertura as usuario_abertura,
(SELECT nome FROM vw_usuarios WHERE id=c.tb_usuarios_id_abertura) as c_nome_usuario_abertura,
DATE_FORMAT(c.dh_abertura,'%d-%m-%Y %H:%i:%s') as dh_abertura,
c.valor_abertura,
c.tb_usuarios_id_fechato as usuario_fechato,
(SELECT nome FROM vw_usuarios WHERE id=c.tb_usuarios_id_fechato) as c_nome_usuario_fechato,
DATE_FORMAT(c.dh_fechato,'%d-%m-%Y %H:%i:%s') as dh_fechato, 
c.valor_fechato,
c.status
FROM
	tb_caixa c
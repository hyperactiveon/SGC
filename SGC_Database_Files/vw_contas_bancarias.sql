CREATE VIEW `vw_contas_bancarias` AS SELECT 
fc.id as id_conta,
fc.titulo,
fc.tbu_titular,
fc.tbfb_banco,
fc.agencia,
fc.numero,
fc.tipo_conta,
fc.custo_encargos,
fc.saldo,
fc.ativo,
(SELECT nome FROM vw_usuarios WHERE id=fc.tbu_titular) as titular,
(SELECT cod_instituicao FROM vw_bancos WHERE id=fc.tbfb_banco) as codigo_banco,
(SELECT nome FROM vw_bancos WHERE id=fc.tbfb_banco) as banco
FROM 
tb_financeiro_contas fc
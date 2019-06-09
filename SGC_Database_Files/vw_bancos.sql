CREATE VIEW `vw_bancos` AS SELECT
fb.id,
fb.cod_instituicao,
fb.nome
FROM
tb_financeiro_bancos fb
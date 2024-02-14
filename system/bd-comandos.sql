/*Essa trigger será ativada sempre que um registro na tabela usuario for atualizado. 
essa trigger um registro na tabela log_usuario com os valores antigos do registro atualizado e a data e hora da modificação. */
DELIMITER //
CREATE TRIGGER usuario_after_update
AFTER UPDATE ON usuario
FOR EACH ROW
BEGIN
  INSERT INTO log_usuario(id_usuario, nome_anterior, sobrenome_anterior, email_anterior, senha_anterior, data_cadastro_anterior, conta_verificada_anterior, data_modificacao)
  VALUES (OLD.id, OLD.nome, OLD.sobrenome, OLD.email, OLD.senha, OLD.data_cadastro, OLD.conta_verificada, NOW());
END; //
DELIMITER ;
---------------------------------
Descrição do projeto:

Construir um "crawler" simples de e-mails, com uma interface web que acompanha o status do processamento.
----------------------------------

Backend:

Desenvolver uma aplicação em PHP que rode em modo console, que:

- leia do banco de dados uma URL para consulta,
- faça o download do conteúdo desta URL (apenas o texto),
- encontre dentro do conteúdo desta página página todos os links para outras páginas e adicione no banco de dados
- encontre todos os emails existentes no texto desta página e adicione no banco de dados
- marque a URL corrente como visitada
- repita o processo até que não existam mais URLs não visitadas no banco de dados


Notas:
 utilize a expressão regular abaixo para encontrar os links
 preg_match_all('/<a href=["\']?((?:.(?!["\']?\s+(?:\S+)=|[>"\']))+.)["\']?>/i', $conteudo, $resultados);
 
 utilize a expressão abaixo para localizar todos os e-mails no texto
 preg_match_all('/\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i', $conteudo, $resultados);

 NÃO usar recursividade de função no design da aplicação

Regras:
 - antes de inserir um link, verificar se ele já não existe no banco
 - antes de inserir um e-mail verificar se ele já não existe no banco


---------------------------------------

Frontend:

Desenvolver uma página web que exibe a lista dos 10 últimos e-mails carregados pelo sistema.

 - a lista deve ser exibida por AJAX
 - utilizar a biblioteca jquery (http://api.jquery.com/jQuery.ajax/)
 - a lista deve ser atualizada a cada 1 segundo


Notas:
 pegar apenas os 10 últimos adicionados a lista (ex: SELECT email FROM emails ORDER BY id DESC LIMIT 10)

 não é necessário layout, apenas 1 div que seja atualizado com a lista de emails separados por <br />
 

-------------------------------------------


Pre-requisitos:
 - Utilize um frameworks neste projeto.
 - O código deve ser (dentro do possível) orientado a objetos.
 - O código html da interface web pode ser o mínimo necessário para exibição das informações solicitadas, não perder tempo com interface.
 - Focar em manter todo código limpo. (inclusive o html)
 - Banco de dados MySQL



Tabelas:
---------------------------------------------
CREATE DATABASE `banco`;
USE `banco`;

CREATE TABLE `banco`.`urls`(
 `id` INT NOT NULL AUTO_INCREMENT ,
 `url` VARCHAR(255) ,
 `visited` ENUM('yes','no') DEFAULT 'no' ,
 PRIMARY KEY (`id`) );

CREATE TABLE `banco`.`emails`(
 `id` INT NOT NULL AUTO_INCREMENT ,
 `email` VARCHAR(255) ,
 PRIMARY KEY (`id`)  );

-- exemplo de URL inicial
INSERT INTO `banco`.`urls`(url) VALUES('https://www.google.com.br/?gfe_rd=ctrl&ei=9xcNU6uRGYfJ8Qa-moHwAg&gws_rd=cr#q=webx&safe=off');

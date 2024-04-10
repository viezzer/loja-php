Trabalho para a disciplina Programação de Aplicações web II

O Projeto:
Será implementado um sistema de pedidos de uma loja, compondo uma aplicação
Web.

Deverão ser implementados:
Parte 1)
• Cadastro de usuários e mecanismo de login.
• Cadastros de fornecedores
• Cadastro de produtos (sem imagem), relacionando-os aos fornecedores.
• Manutenção do estoque de produtos

Para cada cadastro, devem ser implementadas as seguintes funcionalidades:
 Inclusão
 Alteração
 Exclusão
 Consulta ( por código e por nome )

Parte 2)
• Upload das imagens dos produtos (no cadastro de produtos)
• Inclusão de paginação nos cadastros de fornecedores, produtos e usuários.
• Tela de consulta de produtos (com pesquisa) e realização de pedidos. (Ator Cliente -
Carrinho de compras. Ao mandar encerrar o pedido deverá ser realizado o cadastro,
se o cliente for um novo cliente, ou login do cliente, se o cliente estiver voltando à
loja). 
• Só se pode vender itens que estão em estoque
• Itens com estoque ZERO devem ser mostrados como indisponíveis.
• A realização do pedido deve diminuir a quantidade do estoque. 
• Se o cliente quiser comprar mais do que há em estoque deve receber uma
mensagem de erro, oferecendo-lhe a quantidade máxima disponível.
• Deve ser calculado o valor total do pedido e exibido ao cliente. (Utilizando
AJAX)
• Tela de consulta de pedidos realizados por parte da administração da loja ( Ator
Interno) , onde será possível consultar e alterar o status do pedido, gravando para
isso as datas de envio e / ou cancelamento.
• Deve ser possível consultar pedidos pelo número do pedido ou pelo nome do
cliente
• Os pedidos devem ser exibidos utilizando páginas em mestre-detalhe, com o
cabeçalho (mestre) mostrando os dados do pedido (data, cliente, nro, valor
total, etc..) e o corpo (detalhe) mostrando a foto, descrição, quantidade, valor
unitário e valor total de cada item do pedido. Essa página deverá possuir
paginação de dados, e seus itens deverão ser carregados através de AJAX.
Tanto usuários internos como o cliente que fez o pedido podem acessar esses
dados.
• Deverá ser construída API REST que permita a consulta dos pedidos, também pelo
número do pedido ou pelo nome do cliente. Essa API deverá ser acessada através de
um plugin REST do navegador.

A aplicação deverá ser implementada utilizando layout responsivo e deverá
ser possível utilizá-la em um aparelho celeular sem problemas de usabilidade. O
layout também será avaliado, portanto caprichem no CSS.
A aplicação deverá implementar todos os requisitos previstos neste
documento. 

O padrão de interface utilizado será o mesmo adotado pelo site AliExpress
(http://aliexpress.com), que servirá como modelo. O sistema será utilizado por dois
atores: Internos e Clientes. Os usuários de sistema deverão acessar as
funcionalidades do sistema através de links, porém o ator Cliente só pode acessar a
consulta de produtos e realização de pedidos. Já os usuários Internos podem
cadastrar os fornecedores e produtos, além de poder consultar os pedidos realizados.
Cabe aos programadores definir modos de exibir somente as opções que um ator
pode acessar, de acordo com o usuário logado.

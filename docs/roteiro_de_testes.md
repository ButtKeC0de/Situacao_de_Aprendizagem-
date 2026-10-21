# Roteiro de Testes — Rail View (Ferrorama)

Roteiro para a equipe conferir, antes da apresentação, se tudo o que o enunciado pede está funcionando.
Faça os testes **na ordem**: alguns usam dados criados nos testes anteriores.

Em cada teste, marque **✅ Passou** ou **❌ Falhou** na última coluna. Se falhar, anote o que aconteceu, crie um card no Kanban e tire print (vale como evidência).

---

## 0. Preparação

| Passo | O que fazer |
|---|---|
| 1 | Ligue o **Apache** e o **MySQL** no painel do XAMPP. |
| 2 | Confira a porta do MySQL no painel do XAMPP (normalmente **3306**). Ela precisa ser a mesma de `$porta` em `infra/conexao.php`. Se for diferente, o site não conecta no banco. |
| 3 | No phpMyAdmin, importe `database/SA_ferrorama.sql`. Ele cria o banco `rail_view_db`, os perfis e o administrador inicial. |
| 4 | Abra `http://localhost/Situacao_de_Aprendizagem-/` no navegador. |
| 5 | Use uma **janela anônima** para o segundo usuário. Assim dá para ficar logado como admin e como usuário comum ao mesmo tempo. |

### Dados de teste

Os usuários abaixo são criados durante os testes. Só o `caio123` já vem no banco.

| Usuário | Login | Senha | Perfil |
|---|---|---|---|
| caio123 | `caio123` | `caio123` | Administrador (já vem no SQL) |
| Ana Admin | `ana@railview.com` | `senha12345` | Administrador |
| Bruno Funcionário | `bruno@railview.com` | `senha12345` | Funcionário |
| Carla Usuária | `carla@railview.com` | `senha12345` | Usuário |

| Trem | Modelo | Operadora | Tipo | Vagões |
|---|---|---|---|---|
| Expresso Sul | AC44 | Rumo | Carga | 40 |
| Litorânea | GT46 | MRS | Passageiros | 8 |

| Sensor | Localização | Operadora | Status | Trem |
|---|---|---|---|---|
| Temperatura | Km 12 - Joinville | Rumo | Ativo | Expresso Sul |
| Velocidade | Km 30 - Araquari | MRS | Manutenção | Litorânea |

| Rota | Operadora | Trem |
|---|---|---|
| Joinville → Curitiba | Rumo | Expresso Sul |
| São Francisco do Sul → Joinville | MRS | Litorânea |

---

## 1. Login e autenticação

| # | Passo a passo | Resultado esperado | Resultado |
|---|---|---|---|
| T01 | Na tela de login, digite `caio123` e a senha `caio123`. Clique em **Entrar**. | Entra no sistema e abre a **Home**. | |
| T02 | Faça logout. Entre de novo usando o email `caio123@railview.com` e a senha `caio123`. | Entra normalmente: o login aceita **email ou nome de usuário**. | |
| T03 | Faça logout. Digite `caio123` com a senha `errada123`. | Aparece o alerta **"Usuário ou senha incorretos."** e **não** entra. | |
| T04 | Digite um usuário que não existe (`fantasma@teste.com`) com qualquer senha. | Aparece a **mesma** mensagem do T03. O sistema não revela se o usuário existe. | |
| T05 | Clique em **Entrar** com os campos vazios. | O navegador pede para preencher os campos e não envia. | |
| T06 | Logado, abra `public/login.php` na barra de endereço. | Volta direto para a Home, sem pedir login de novo. | |

## 2. Senhas armazenadas com segurança

| # | Passo a passo | Resultado esperado | Resultado |
|---|---|---|---|
| T07 | No phpMyAdmin, rode `SELECT nome, email, senha FROM Usuario;` | Nenhuma senha aparece em texto puro. Todas começam com **`$2y$10$`** (hash bcrypt do `password_hash()`). **Print para a apresentação.** | |

## 3. Sessão do usuário

| # | Passo a passo | Resultado esperado | Resultado |
|---|---|---|---|
| T08 | Antes de logar, aperte **F12** e vá em **Aplicativo → Cookies** (Chrome) ou **Armazenamento → Cookies** (Firefox). Anote o valor de `PHPSESSID`. Faça login e olhe de novo. | O `PHPSESSID` **muda** depois do login (`session_regenerate_id`), o que protege contra roubo de sessão. | |
| T09 | Logado, abra **Trens**, **Sensores** e **Rotas**. | O **nome do usuário logado** aparece no canto superior direito. Ele vem da sessão (`$_SESSION['usuario_nome']`). | |
| T10 | Clique no nome do usuário (canto superior) para abrir o **Meu Perfil**. | Mostra nome, email e perfil (cargo) do usuário logado. A página busca esses dados pelo ID guardado na sessão (`$_SESSION['usuario_id']`). | |
| T11 | Feche a aba (sem logout), abra o site de novo no mesmo navegador e vá para `public/home.php`. | Continua logado: a sessão foi mantida. | |

## 4. Logout

| # | Passo a passo | Resultado esperado | Resultado |
|---|---|---|---|
| T12 | Clique no ícone de **Sair** na barra lateral. | Volta para a tela de login. | |
| T13 | Depois do logout, digite `public/trens_home.php` na barra de endereço. | Vai para o **login**: a sessão foi encerrada. | |
| T14 | Depois do logout, aperte **Voltar** no navegador e depois **F5**. | Ao recarregar, vai para o login. Sem o F5, o navegador pode mostrar a página antiga guardada em cache, mas ela não funciona mais. | |

## 5. Acesso sem login

Deslogado (ou numa janela anônima), abra cada endereço direto na barra:

| # | Endereço | Resultado esperado | Resultado |
|---|---|---|---|
| T15 | `public/home.php` | Vai para o login | |
| T16 | `public/trens_home.php` e `public/trens_lista.php` | Vai para o login | |
| T17 | `public/sensor_home.php` e `public/sensor_lista.php` | Vai para o login | |
| T18 | `public/criacao_rotas.php` | Vai para o login | |
| T19 | `public/Perfil.php` e `public/usuario_lista.php` | Vai para o login | |
| T20 | `index.html`, `public/login.php`, `public/usuario_cadastro.php` | **Abrem normalmente** (são as únicas páginas públicas) | |

## 6. CRUD de Usuários

| # | Passo a passo | Resultado esperado | Resultado |
|---|---|---|---|
| T21 | Deslogado, clique em **"Não possui conta? Cadastrar-se"**. Cadastre a **Carla** (`carla@railview.com` / `senha12345`), marcando os Termos de Uso. | Aparece **"Cadastro realizado! Agora é só entrar."** e volta para o login. | |
| T22 | Tente cadastrar outra conta com o **mesmo email** da Carla. | Alerta **"Este email já está cadastrado."** | |
| T23 | Tente cadastrar com **senha e confirmação diferentes**. | Alerta **"As senhas não coincidem."** | |
| T24 | Cadastre-se sozinho com um email `teste@admin.com`. Depois entre como `caio123` e veja **Meu Perfil → Gerenciar usuários**. | A conta aparece com perfil **Usuário**: quem se cadastra sozinho **nunca** vira administrador. Depois exclua essa conta. | |
| T25 | Como `caio123` (por enquanto o **único** administrador), vá em **Meu Perfil → Editar meus dados**, mude o próprio perfil para **Usuário** e salve. | Erro **"Este é o único administrador…"** e o perfil continua Administrador. O sistema nunca fica sem admin. | |
| T26 | Ainda como `caio123`, clique em **Meu Perfil → Excluir minha conta**. | Erro **"Não é possível excluir o único administrador do sistema…"** e a conta continua existindo. | |
| T27 | Vá em **Meu Perfil → Gerenciar usuários → + Cadastrar usuário**. Cadastre a **Ana** com perfil **Administrador** e o **Bruno** com perfil **Funcionário**. | Mensagem **"Usuário '…' cadastrado com sucesso!"**. Os dois aparecem na lista com o perfil certo. | |
| T28 | Na lista de usuários, clique em **editar** (lápis) no Bruno, mude o nome para "Bruno Silva" e salve. | Mensagem **"atualizado com sucesso"**. O nome muda na lista. | |
| T29 | Edite o Bruno colocando o email da Carla (`carla@railview.com`). | Erro **"Este email já está sendo usado por outro usuário."** | |
| T30 | Edite o Bruno com nova senha `123`. | Erro **"A nova senha deve ter no mínimo 8 caracteres."** | |
| T31 | Entre como **Carla**, vá em **Meu Perfil → Editar meus dados** e mude o nome dela. | Funciona. O campo **Perfil não aparece** para ela, porque só o admin muda perfil. | |
| T32 | Crie uma conta de teste, entre com ela e clique em **Meu Perfil → Excluir minha conta**. | Pede confirmação, exclui e volta para o login. Essa conta não entra mais. | |

## 7. CRUD de Trens

Entre como **caio123** (admin).

| # | Passo a passo | Resultado esperado | Resultado |
|---|---|---|---|
| T33 | **Trens → Cadastrar**. Cadastre os 2 trens dos dados de teste. | Mensagem **"Trem '…' cadastrado com sucesso!"**. Os trens aparecem na lista e na tela de Trens. | |
| T34 | Tente cadastrar um trem deixando **Modelo** vazio. | O formulário não envia (campo obrigatório). | |
| T35 | Na tela **Trens**, digite o ID de um trem na busca. Depois clique no card do trem. | A busca filtra os cards. O clique abre a lista mostrando **só aquele trem**. | |
| T36 | Na lista, clique em **editar** no "Litorânea" e mude os vagões para 10. | Mensagem **"atualizado com sucesso"**. O valor muda na lista. | |
| T37 | Cadastre um trem extra "Trem Descarte" e **exclua** ele. | Pede confirmação e depois mostra **"…excluído com sucesso!"**. | |

## 8. CRUD de Sensores (relacionamento Sensor → Trem)

Como **caio123**:

| # | Passo a passo | Resultado esperado | Resultado |
|---|---|---|---|
| T38 | **Sensores → Cadastrar**. Cadastre os 2 sensores dos dados de teste, escolhendo o trem no campo de seleção. | Mensagem **"Sensor '…' cadastrado com sucesso!"**. | |
| T39 | Abra a **lista de sensores**. | Cada card mostra **"TREM VINCULADO"** com o apelido e o modelo do trem certo. É o relacionamento funcionando. | |
| T40 | Edite o sensor "Velocidade": mude o status para **Ativo** e o trem para **Expresso Sul**. | Mensagem **"Sensor atualizado com sucesso!"**. O card mostra o novo status e o novo trem. | |
| T41 | Use a busca da lista e digite "Joinville". | Mostra só os sensores daquela localização. | |
| T42 | Cadastre um sensor extra e exclua. | Pede confirmação e depois mostra **"Sensor excluído com sucesso!"**. | |

## 9. CRUD de Rotas (relacionamento Rota → Trem)

Como **caio123**:

| # | Passo a passo | Resultado esperado | Resultado |
|---|---|---|---|
| T43 | **Rotas**: cadastre as 2 rotas dos dados de teste, escolhendo o trem. | Mensagem **"Rota salva com sucesso!"**. A rota aparece na lista com o **ID do trem** e o apelido dele. | |
| T44 | Tente cadastrar uma rota com **origem e destino iguais** (Joinville → Joinville). | Erro **"A origem e o destino precisam ser diferentes."** | |
| T45 | Clique em **editar** (lápis) numa rota, troque o trem e salve. | O formulário vira **"Editar Rota #…"**, e depois de salvar a lista mostra o trem novo. | |
| T46 | Digite "Curitiba" na pesquisa de rotas. | Filtra a lista e o contador mostra **"1 de 2 rotas encontradas"**. | |
| T47 | Cadastre uma rota extra e clique em **excluir** (lixeira). | Pergunta **"Deseja excluir a rota …?"** e depois mostra **"Rota excluída."** | |
| T48 | Exclua um trem que tem sensor e rota (crie um trem só para isso). | O trem some, os **sensores dele também somem** e a rota continua, mas com o trem **"—"**. As chaves estrangeiras usam `ON DELETE CASCADE`. | |

## 10. Controle de acesso por perfil

### 10.1 Administrador (caio123 ou Ana)

| # | Passo a passo | Resultado esperado | Resultado |
|---|---|---|---|
| T49 | Abra Trens, Sensores e Rotas. | Aparecem os botões **Cadastrar / Editar / Excluir** e o formulário de rotas. | |
| T50 | Abra **Meu Perfil**. | Aparece o botão **"Gerenciar usuários"**. | |

### 10.2 Usuário padrão (Carla) e Funcionário (Bruno)

Entre como **Carla** numa janela anônima. Repita depois com o **Bruno**, que hoje tem as mesmas permissões do Usuário.

| # | Passo a passo | Resultado esperado | Resultado |
|---|---|---|---|
| T51 | Abra **Trens**. | Vê os trens, mas no lugar dos botões aparece só **"Consultar trens → Ver lista"**. A lista **não tem** a coluna Ações. | |
| T52 | Abra **Sensores** e a lista de sensores. | Vê os sensores, mas **sem** os botões Editar/Excluir/Cadastrar. | |
| T53 | Abra **Rotas**. | Vê a lista de rotas e a mensagem **"Você pode consultar as rotas. Apenas administradores cadastram, editam e excluem."**. Não aparece formulário nem os botões de editar/excluir. | |
| T54 | Abra **Meu Perfil**. | **Não** aparece "Gerenciar usuários". | |

### 10.3 Bloqueio no backend (o mais importante para a avaliação)

Ainda como **Carla**, digite cada endereço **direto na barra** (troque `1` por um ID que exista):

| # | Endereço | Resultado esperado | Resultado |
|---|---|---|---|
| T55 | `public/trens_cadastro.php` | **"Acesso negado: seu perfil não tem permissão para esta página."** | |
| T56 | `public/trens_editar.php?id=1` | Acesso negado | |
| T57 | `public/trens_excluir.php?id=1` | Acesso negado, e o trem **continua** na lista | |
| T58 | `public/sensor_cadastro.php`, `sensor_editar.php?id=1`, `sensor_excluir.php?id=1` | Acesso negado nos três | |
| T59 | `public/criacao_rotas.php?editar=1` | Acesso negado | |
| T60 | `public/usuario_lista.php` | Acesso negado | |
| T61 | `public/usuario_editar.php?id=1` (ID de **outro** usuário) | Acesso negado: ela só edita os próprios dados | |

> **Por que isso importa:** o enunciado diz que só esconder botões não basta. Esses testes mostram que, mesmo sabendo o endereço, o usuário comum é barrado **pelo PHP no servidor** (`exigir_admin()` em `infra/auth.php`), que responde com o código HTTP **403**. Para provar na apresentação, aperte F12, vá na aba **Rede/Network** e mostre o status 403.

| # | Passo a passo | Resultado esperado | Resultado |
|---|---|---|---|
| T62 | Deixe a Carla logada na janela anônima. Na janela normal, como `caio123`, mude o perfil dela para **Administrador**. Na janela da Carla, recarregue a tela de Trens. | Os botões de admin aparecem **sem ela precisar sair e entrar**: o perfil é conferido no banco a cada página. Depois, volte o perfil dela para **Usuário**. | |
| T63 | Como `caio123`, exclua uma conta de teste que esteja logada em outra janela. Na outra janela, recarregue a página. | Vai para o login: a sessão de quem foi excluído deixa de valer. | |

---

## 11. Problemas conhecidos (registrar no Kanban)

Estes pontos **ainda não estão resolvidos**. Se forem aparecer na apresentação, informem a situação deles, como o enunciado pede.

| # | Problema | Como reproduzir |
|---|---|---|
| P01 | O trem ainda **não tem usuário responsável** (o enunciado pede). | O cadastro de trem não tem esse campo. |
| P02 | As mensagens de sucesso de Trem e Sensor não tratam HTML (**XSS**). | Cadastre um trem com apelido `<b>teste</b>`: a mensagem aparece em **negrito**. |
| P03 | Trens e sensores são excluídos por **link (GET)**, e não por formulário (POST) como Usuários e Rotas. | Só o admin consegue (T57), mas o ideal é POST. |
| P04 | O cadastro aceita **senha curta**, mas a edição exige 8 caracteres. | Cadastre-se com a senha `123`: o sistema aceita. |
| P05 | Clicar num sensor na tela **Sensores** abre a lista com **todos** os sensores, não só o clicado. | Clique num card de sensor. |
| P06 | A pesquisa sobre APIs (`pesquisas/apis.md`) ainda não existe. | — |

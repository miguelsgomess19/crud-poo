# CRUD de Séries (PHP + PDO + PostgreSQL)

Projeto baseado no modelo **Aula05-ClienteCRUD**, adaptado para a entidade **Série**.

## Estrutura
- `config/Database.php`: conexão PDO com PostgreSQL
- `interfaces/RepositoryInterface.php`: contrato das operações CRUD
- `models/Serie.php`: entidade de domínio (sem acesso ao banco)
- `repositories/SerieRepository.php`: implementação do CRUD com PDO
- `public/`: telas do sistema (`index.php`, `criar.php`, `editar.php`, `excluir.php`)
- `database.sql`: script de criação do banco e da tabela
- `RESPOSTAS.md`: respostas das questões de apropriação e desafio profissional

## Como executar
1. Inicie o PostgreSQL (nesta máquina está em `C:\Users\I1D35\pg17\pgsql`, porta `55432`, usuário `postgres`, sem senha):
   ```bash
   "C:\Users\I1D35\pg17\pgsql\bin\pg_ctl" -D "C:\Users\I1D35\pgdata" -l "C:\Users\I1D35\pgdata\server.log" start
   ```
2. Crie o banco e a tabela importando o arquivo `database.sql` (o banco `crud_series` já foi criado nesta máquina).
3. Ajuste as credenciais em `config/Database.php` se necessário.
4. Inicie o servidor PHP apontando para a pasta `public`:
   ```bash
   php -S localhost:8000 -t public
   ```
5. Acesse no navegador: `http://localhost:8000`

## Funcionalidades
- Listagem de séries
- Cadastro de série com validação de dados
- Edição de série com validação e tratamento de erros
- Exclusão de série com tela de confirmação
- Tratamento de IDs inválidos/inexistentes e mensagens de erro

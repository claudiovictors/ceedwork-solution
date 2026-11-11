# Ceedwork Solution

Website institucional e painel de administração da Ceedwork Solution, construído com Laravel.

## Requisitos

- Docker Engine 24+
- Docker Compose v2+
- Um domínio apontado para o servidor (recomendado)
- Proxy reverso com HTTPS (Nginx, Caddy ou Traefik) em produção

## Deploy numa VPS

1. Clone o repositório e entre na pasta:

```bash
git clone https://github.com/claudiovictors/ceedwork-solution.git
cd ceedwork-solution
```

2. Crie o ficheiro de ambiente:

```bash
cp .env.example .env
```

3. Gere uma chave de aplicação:

```bash
openssl rand -base64 32
```

Copie o resultado para `APP_KEY`, com o prefixo `base64:`. Exemplo:

```env
APP_KEY=base64:resultado-do-comando
```

4. Configure pelo menos estas variáveis no `.env`:

```env
APP_URL=https://seudominio.com
APP_TIMEZONE=Africa/Luanda

DB_DATABASE=ceedwork
DB_USERNAME=ceedwork
DB_PASSWORD=uma-password-forte
DB_ROOT_PASSWORD=outra-password-forte

ADMIN_NAME="Administrador Ceedwork"
ADMIN_EMAIL=admin@seudominio.com
ADMIN_PASSWORD=uma-password-forte

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=info@seudominio.com
MAIL_PASSWORD=password-de-aplicacao
MAIL_FROM_ADDRESS=info@seudominio.com
```

5. Valide a configuração do Compose:

```bash
docker compose config --quiet
```

6. Construa e arranque os contentores:

```bash
docker compose up -d --build
```

No primeiro arranque, o container da aplicação:

- cria as pastas de storage e o link `public/storage`;
- executa as migrações;
- cria o administrador se `ADMIN_EMAIL` e `ADMIN_PASSWORD` estiverem definidos;
- otimiza configuração, rotas e views.

7. Verifique o estado:

```bash
docker compose ps
docker compose logs -f app
```

A aplicação fica disponível em `http://IP-DA-VPS:8080` por padrão. Para expor apenas via proxy reverso, defina `APP_BIND=127.0.0.1` e configure o proxy para `http://127.0.0.1:8080`.

## Proxy reverso

Configure o Nginx/Caddy/Traefik para encaminhar o domínio para `127.0.0.1:8080` e terminar o HTTPS. O `APP_URL` deve usar `https://` e `SESSION_SECURE_COOKIE` deve ficar `true`. Para testes por HTTP antes de configurar o proxy, use `SESSION_SECURE_COOKIE=false` temporariamente.

## Administração

O painel fica em `/ceed-admin`. Use o email e a password definidos em `ADMIN_EMAIL` e `ADMIN_PASSWORD`.

Não existem serviços, notícias ou projetos de demonstração no arranque. O conteúdo é criado no painel de administração.

## Dados persistentes

Os volumes `app_storage` e `mysql_data` guardam uploads e a base de dados. Faça backups regulares:

```bash
docker compose exec db mysqldump -uroot -p"$DB_ROOT_PASSWORD" "$DB_DATABASE" > backup.sql
docker run --rm -v ceedwork_app_storage:/data -v "$PWD":/backup alpine tar czf /backup/storage.tar.gz -C /data .
```

## Atualizar

```bash
git pull origin main
docker compose up -d --build
```

As migrações são executadas automaticamente no arranque.

## Desenvolvimento local

Para desenvolvimento sem Docker, configure o `.env` com a base de dados local, instale as dependências e execute:

```bash
composer install
npm install
npm run build
php artisan migrate
php artisan serve
```

Testes:

```bash
php artisan test --compact
```

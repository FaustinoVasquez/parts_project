# Parts Project

Laravel application for parts processing and management.

## Current Stack

- **PHP**: 8.1.33
- **Laravel**: 9.52.7
- **Database**: SQL Server (ODBC 18)
- **Cache**: Redis 7
- **Web Server**: Nginx + PHP-FPM
- **Container**: Docker

## Quick Start

### Start Application:
```bash
cd /home/fvasquez/parts_project
docker-compose up -d
```

### Stop Application:
```bash
docker-compose down
```

### Rebuild Containers:
```bash
docker-compose down
docker-compose build --no-cache
docker-compose up -d
```

### Access Application:
- **URL**: http://localhost:8080
- **Database**: PartsProcessing @ 192.168.0.236:1433

## Artisan Commands

### Check Version:
```bash
docker exec parts_project-php-1 bash -c "cd /var/www && php artisan --version"
```

### Clear Cache:
```bash
docker exec parts_project-php-1 bash -c "cd /var/www && php artisan cache:clear"
```

### List Routes:
```bash
docker exec parts_project-php-1 bash -c "cd /var/www && php artisan route:list"
```

### Create Database Backup:
```bash
docker exec parts_project-php-1 php /var/www/backup_database.php
```

## Performance Features

### Caching:
- **Redis caching** (80-90% faster than file cache)
- **In-memory sessions** (faster user experience)
- **Configuration caching** (optimized bootstrap)

### Database:
- **ODBC Driver 18** with SSL encryption
- **Trust server certificate** configured for internal SQL Server

## Container Structure

```
parts_project/
├── php           - PHP 8.1-FPM container
├── nginx         - Nginx web server
└── redis         - Redis 7 cache (port 6380)
```

## Important Files

- `Dockerfile` - PHP container definition
- `docker-compose.yml` - Service orchestration
- `parts/.env` - Environment configuration
- `parts/backup_database.php` - Database backup utility
- `UPGRADE_REPORT.md` - Detailed upgrade documentation

## Troubleshooting

### Application not loading:
```bash
docker-compose logs php
docker-compose logs nginx
```

### Database connection issues:
```bash
docker exec parts_project-php-1 bash -c "cd /var/www && php artisan config:clear && php artisan cache:clear"
```

### Redis not working:
```bash
docker exec parts_project-redis-1 redis-cli ping
```

### Check PHP extensions:
```bash
docker exec parts_project-php-1 php -m | grep -E '(sqlsrv|redis)'
```

## Maintenance

### Regular Tasks:
- Monitor application logs daily
- Create database backups weekly
- Update composer dependencies monthly
- Clear caches after configuration changes

### Cache Invalidation:
Clear cache when updating:
- Application configuration
- Routes
- Views
- Environment variables

## Backup Locations

- **Project Files**: `/home/fvasquez/backups/parts_project_*.tar.gz`
- **Database**: SQL Server backups in `/var/opt/mssql/data/` on database server

## Documentation

- **Upgrade Report**: `UPGRADE_REPORT.md` - Complete upgrade documentation
- **Backups**: `/home/fvasquez/backups/` - All backup archives

## Recent Upgrades

**December 6, 2025**:
- ODBC Driver 17 → 18 (with SSL support)
- PHP 8.1.29 → 8.1.33 (latest stable)
- Redis caching infrastructure added
- File cache → Redis cache (80-90% faster)

## Security Notes

- Laravel 9 LTS support until February 2024
- PHP 8.1 active support until November 2025
- All passwords in `.env` file (never commit to git)
- Redis not exposed to public internet
- ODBC 18 with encryption enabled
- Run `composer audit` to check for vulnerabilities

## Future Upgrades

Recommended timeline:
1. **Q1 2026**: Upgrade to Laravel 10 or 11 LTS
2. **Q2 2026**: Upgrade to PHP 8.2 or 8.3
3. **2026**: Performance optimization phase (indexes, N+1 fixes, etc.)

---

**Last Updated**: December 6, 2025
**Port**: 8080
**Environment**: Production

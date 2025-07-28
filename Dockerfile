FROM php:8.2-cli

# Instala extensiones necesarias para PostgreSQL
RUN apt-get update && \
    apt-get install -y libpq-dev unzip && \
    docker-php-ext-install pdo pdo_pgsql

# Copia el contenido del proyecto al contenedor
COPY . /app
WORKDIR /app

# Exponer el puerto donde se ejecutará PHP
EXPOSE 10000

# Comando para iniciar el servidor web integrado
CMD ["php", "-S", "0.0.0.0:10000", "-t", "."]

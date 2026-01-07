FROM php:8.2-cli

# -------------------------------
# 1. Install system packages
# -------------------------------
RUN apt-get update && apt-get install -y \
    bash \
    git \
    unzip \
    zip \
    libzip-dev \
    bash-completion \
    locales \
    && rm -rf /var/lib/apt/lists/*

# -------------------------------
# 2. Generate locale
# -------------------------------
ENV LANG=en_US.UTF-8 \
    LANGUAGE=en_US:en \
    LC_ALL=en_US.UTF-8

RUN apt-get update && apt-get install -y locales \
    && echo "en_US.UTF-8 UTF-8" > /etc/locale.gen \
    && locale-gen en_US.UTF-8 \
    && update-locale LANG=en_US.UTF-8

# -------------------------------
# 3. Install PHP extensions
# -------------------------------
RUN docker-php-ext-install zip mysqli pdo pdo_mysql

# -------------------------------
# 4. Install Composer
# -------------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# -------------------------------
# 5. Create non-root user for VS Code
# -------------------------------
ARG USERNAME=vscode
ARG USER_UID=1000
ARG USER_GID=1000
RUN groupadd --gid $USER_GID $USERNAME \
    && useradd --uid $USER_UID --gid $USER_GID -m -s /bin/bash $USERNAME

# -------------------------------
# 6. Set working directory & user
# -------------------------------
WORKDIR /workspace
USER $USERNAME

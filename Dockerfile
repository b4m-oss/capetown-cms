# Laravel Sailの公式イメージをベースにする
FROM laravel/sail:1.x

# 環境変数を設定
ARG WWWGROUP=1000
ENV WWWGROUP=$WWWGROUP

# ユーザーとグループを作成
RUN groupadd --force -g $WWWGROUP sail \
    && useradd -ms /bin/bash --no-user-group -g $WWWGROUP -u 1337 sail

# アプリケーションの作業ディレクトリを設定
WORKDIR /var/www/html

# Supervisorやphp.iniファイルをコピーする場合
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY php.ini /etc/php/8.2/cli/conf.d/99-sail.ini

# エントリーポイントを設定
CMD ["start-container"]

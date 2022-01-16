FROM ubuntu:20.04

RUN apt-get update && DEBIAN_FRONTEND="noninteractive" apt-get -y install \
    golang-go \
    sendmail \
    git \
    ca-certificates \
    apt-transport-https \
    software-properties-common

RUN add-apt-repository ppa:ondrej/php && apt-get install -y php7.4-cli php7.4-curl php7.4-xml php7.4-mbstring php7.4-zip

RUN go get github.com/mailhog/MailHog

COPY --from=composer /usr/bin/composer /usr/bin/composer

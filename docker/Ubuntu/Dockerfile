FROM ubuntu:20.04

RUN apt-get update && DEBIAN_FRONTEND="noninteractive" apt-get -y install golang-go sendmail git php8.0-cli

RUN go get github.com/mailhog/MailHog
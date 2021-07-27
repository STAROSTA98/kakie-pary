FROM ubuntu

ENV DEBIAN_FRONTEND noninteractive

RUN apt update -y
RUN apt-get upgrade -y
RUN apt-get install -y software-properties-common
RUN add-apt-repository -y ppa:ondrej/php
RUN apt update -y
RUN apt install -y php8.0 libapache2-mod-php8.0
RUN apt-get upgrade -y

VOLUME ["/var/www"]
EXPOSE 80

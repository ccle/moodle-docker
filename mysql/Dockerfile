FROM mariadb:10

MAINTAINER williamjlee1@gmail.com

# Add max_allowed_packet
RUN echo "[mysqld]" >> /etc/mysql/my.cnf
RUN echo "max_allowed_packet=512M" >> /etc/mysql/my.cnf

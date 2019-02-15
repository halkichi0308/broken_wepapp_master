FROM nginx:1.15.8-alpine
RUN apk add php7-fpm php7-mbstring php7-session php7-pdo_mysql

#php-fpm config
RUN sed -iE 's/^\(user = \)nobody/\1nginx/g' /etc/php7/php-fpm.d/www.conf && \
    sed -iE 's/^\(group = \)nobody/\1nginx/g' /etc/php7/php-fpm.d/www.conf

COPY conf.d/nginx/default.conf  /etc/nginx/conf.d/default.conf

#php.ini config
RUN sed -iE 's/^\(session.name = \)PHPSESSID/\1_session/' /etc/php7/php.ini

#init service config
RUN echo '#!/bin/sh ' > init.sh && \
    echo 'php-fpm7' >> init.sh && \
    echo 'nginx -g "daemon off;"' >> init.sh && \
    chmod 755 init.sh

#RUN apk add vim curl
EXPOSE 80 9000

STOPSIGNAL SIGTERM

#CMD ["nginx", "-g", "daemon off;"]
CMD ["/init.sh"]

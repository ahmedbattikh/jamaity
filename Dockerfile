FROM httpd:2.4-alpine

# Install Apache modules
RUN apk add --no-cache apache2-proxy

# Set working directory
WORKDIR /usr/local/apache2/htdocs

# Copy application public directory
COPY public/ /usr/local/apache2/htdocs/

# Copy Apache configuration
COPY docker/apache/httpd.conf /usr/local/apache2/conf/httpd.conf

# Expose port 80
EXPOSE 80

CMD ["httpd-foreground"]
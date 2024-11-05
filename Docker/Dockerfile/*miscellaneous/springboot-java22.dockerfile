FROM openjdk:22 AS builder

WORKDIR /app

COPY . .

#building the app
RUN chmod +x mvnw && ./mvnw clean package -DskipTests


# #FROM ghcr.io/graalvm/jdk-community:22
FROM openjdk:22

WORKDIR /app

#setting time for logging time accuracy
RUN rm /etc/localtime && \
    ln -s /usr/share/zoneinfo/Asia/Dhaka /etc/localtime

COPY --from=builder /app/target/*.jar app.jar

#if needed any dependency
RUN microdnf install nodejs && \
    npm install dictionary-en nspell && \
    microdnf clean all && \
    rm -rf /var/cache

#creating non root user
RUN groupadd -g 1001 appgroup && \
    useradd -u 1001 -g appgroup -m appuser && \
    chown -R appuser:appgroup /app

#removing shell access
RUN rm -f /bin/sh

USER appuser

EXPOSE 8082

CMD ["java", "-jar", "app.jar"]
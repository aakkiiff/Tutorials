FROM openjdk:17 AS builder

WORKDIR /app

COPY ./src/main/resources/application.prod.properties ./src/main/resources/application.properties

COPY . .

RUN ./mvnw clean package -DskipTests

#using google distroless image
FROM gcr.io/distroless/java17-debian12

WORKDIR /app

COPY --from=builder /app/target/*.jar app.jar

EXPOSE 8082

CMD ["app.jar"]
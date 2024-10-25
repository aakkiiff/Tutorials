FROM node:20 AS build

WORKDIR /app

COPY . .

RUN npm install

RUN npm run build


FROM nginx:1.27.2-alpine-slim

COPY --from=build /app/dist /usr/share/nginx/html

COPY ./nginx.conf  /etc/nginx/conf.d/default.conf

EXPOSE 80

CMD [ "nginx","-g","daemon off;" ]


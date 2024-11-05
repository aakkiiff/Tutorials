FROM node:20-alpine AS builder

WORKDIR /app

COPY . .

RUN npm i

ENV VITE_BACKEND_URL="/set_ur_envs"

RUN npm run build-only


FROM nginx:1.27.0-alpine-slim

RUN ln -s /usr/share/zoneinfo/Asia/Dhaka /etc/localtime

COPY --from=builder /app/dist /usr/share/nginx/html

COPY ./nginx.conf /etc/nginx/conf.d/default.conf

RUN chown -R nginx:nginx /var/cache/nginx && \
        chown -R nginx:nginx /var/log/nginx && \
        chown -R nginx:nginx /etc/nginx/conf.d && \
        touch /var/run/nginx.pid && \
        chown -R nginx:nginx /var/run/nginx.pid


USER nginx
## port must be greater than 1024 here and nginx.conf file to be able to use nonroot nginx user
EXPOSE 8090

CMD ["nginx", "-g", "daemon off;"]

#############################################
# #non optimized version
# FROM node:20-alpine AS builder
# WORKDIR /app
# COPY package.json .
# RUN npm i
# COPY . .
# ENV VITE_BACKEND_URL="http://localhost:8082"
# RUN npm run build-only

# FROM nginx:1.27.0-alpine-slim
# COPY --from=builder /app/dist /usr/share/nginx/html
# COPY ./nginx.conf /etc/nginx/conf.d/default.conf
# EXPOSE 80
# CMD ["nginx", "-g", "daemon off;"]
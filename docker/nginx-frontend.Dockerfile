FROM node:lts AS vite_build

WORKDIR /usr/src/app

COPY package.json package-lock.json .

RUN npm i

COPY . .

RUN npm run build

FROM nginx
COPY --from=vite_build /usr/src/app/dist /usr/share/nginx/html

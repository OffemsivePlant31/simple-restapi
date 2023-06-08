FROM node:lts AS vite_build

WORKDIR /usr/src/app

COPY frontend/package.json frontend/package-lock.json .

RUN npm i

COPY . .

RUN npm run build

FROM nginx
COPY --from=build_stage /usr/src/app/dist /usr/share/nginx/html

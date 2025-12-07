FROM node:20.16

WORKDIR /var/www/html/frontend

COPY package*.json ./
RUN npm install

COPY . .

EXPOSE 3000

RUN echo '{"type": "module"}' > /var/www/html/frontend/package.json

CMD ["npm", "run", "build:all"]

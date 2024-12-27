# Убедитесь, что используете образ с поддержкой ES Modules
FROM node:20.16

WORKDIR /var/www/html/frontend

# Установка зависимостей
COPY package*.json ./
RUN npm install

# Копируем весь код проекта
COPY . .

# Указываем порт, который будет использоваться
EXPOSE 3000

# Добавляем тип модуля в package.json
RUN echo '{"type": "module"}' > /var/www/html/frontend/package.json

# Запуск сборки
CMD ["npm", "run", "build:all"]

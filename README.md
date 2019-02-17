# junk/composer-autoload
### 컴포저를 autload 만 쓸 목적으로 사영 하는 법


> 폴더 구선

이번 프로젝트엔 아래와 같은 3파일 만 쓰겠습니다.




- Apache: 2.4.25 (Debian)
- PHP: 7.2.15 
- Composer: 1.8.4
- mysql: 5.7.25 
(user:root password :root )

- - -

##### 도커 시작
```
docker-compose build
docker-compose up -d
```

##### 도카 컴포즈 파일 내용
```
version: '3'
services:
  app:
    build: ./docker/php
    volumes:
      - ./src:/var/www/html   <--- 더커하고 연결되있는 폴더 입니다. ./src에 index.php가 있음 
    ports:
      - 8888:80  <-- 환경에 맞춰서 수정 
  mysql:
    image: mysql:5.7
    environment:
      - MYSQL_ROOT_PASSWORD=root
    ports:
      - 3306:3306
    volumes:
      - dbdata:/var/lib/mysql
volumes:
  dbdata:
```

##### 이래와 같은 URL에 접석

```angular2
localhost:8866
```

phpinfo을 보실건니다.


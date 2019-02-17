# junk/composer-autoload
### 컴포저를 autload 만 쓸 목적으로 사영 하는 법


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
##### 이래와 같은 URL에 접석

```angular2
localhost:8866
```

phpinfo을 보실건니다.


##### 포인트

- 직적 파일을 require 하지말고 vemdor에서 autoload를 쓰고 instance 를 취득함
- 읽은 경로를 추가 하고싶을 때 dump-autoload하야 다시 auto_loder가 생선되고 파스가 늘다
- composer validate할때 오류를 안 나오게 composer.json에 name나 descripttion 속선을 추가함


[[PHP]Composerをautoloadだけの目的で使う](https://akamist.com/blog/archives/395)

--TEST--
swoole_coroutine: error handing bug by pdo
--SKIPIF--
<?php
require __DIR__ . '/../include/skipif.inc';
skip_if_pdo_not_support_mysql8();
?>
--FILE--
<?php
Swoole\Runtime::enableCoroutine();
require __DIR__ . '/../include/bootstrap.php';
go(function () {
    new PDO(
        "mysql:host=" . MYSQL_SERVER_HOST . ";dbname=" . MYSQL_SERVER_DB . ";charset=utf8",
        MYSQL_SERVER_USER, MYSQL_SERVER_PWD
    );
});
go(function () {
    fopen(__DIR__ . '/file_not_exist', 'r');
});
?>
--EXPECTF--
Warning: fopen(%s): failed to open stream: No such file or directory in %s on line %d

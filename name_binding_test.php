<?php 
/*class A {
    static $word = "hello";
    static function hello() {print self::$word;}
}

class B extends A {
    static $word = "bye";
}

B::hello();
*/

class A {
    static $word = "hello";
    static function hello() {print static::$word;}
}

class B extends A {
    static $word = "bye";
}

B::hello();
?>

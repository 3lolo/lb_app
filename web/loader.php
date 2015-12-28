<!-- Тип кодирования данных, enctype, ДОЛЖЕН БЫТЬ указан ИМЕННО так -->
<form enctype="multipart/form-data" action="/loader.php" method="POST">
    <!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
    <!-- Название элемента input определяет имя в массиве $_FILES -->
    Отправить этот файл: <input name="userfile" type="file" />
    <input type="submit" value="Send File" />
</form>


?>
<?php
$base=$_REQUEST['image'];
$name=$_REQUEST['name'];
$binary=base64_decode($base);
header('Content-Type: bitmap; charset=utf-8');
$pic = $name.'.jpg';
$file = fopen(getcwd().'/application/web/images/'.$pic, 'wb');
fwrite($file, $binary);
fclose($file);
echo 'Image upload complete!!, Please check your php file directory……';
header("Location: http://pixel.kh.ua/application/web/app_dev.php/upload/$name/$pic");
                  http://pixel.kh.ua/application/web/app_dev.php/upload/loop/A_pozniack.jpg
?>
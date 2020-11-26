<?php
    include_once "base.php";
    $id=$_GET['id'];

    /**刪除檔案
     * 1. 找出檔案的路徑
     * 2. 使用unlink刪除硬碟中的檔案
     * 3. 刪除檔案後再刪除資料表中的資料
     */

    $row=find('upload',$id);
    $path=$row['path'];
    unlink($path); //用來刪掉在硬碟的檔案


    del('upload',$id); //用來刪掉資料表的資料

    to('manage.php'); 
?>
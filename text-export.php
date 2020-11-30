<?php
/****
 * 1.建立資料庫及資料表
 * 2.建立上傳檔案機制
 * 3.取得檔案資源
 * 4.取得檔案內容
 * 5.建立SQL語法
 * 6.寫入資料庫
 * 7.結束檔案
 */

    include_once "base.php";
    
    if(!empty($_GET['do'] && $_GET['do']=='download')){
        $rows=all("students");
        $file=fopen('download.csv',"w+");   //在根目錄建立檔案：fopen是在有檔案的時候開啟，沒檔案的時候新增
        $utf8_with_bom = chr(239).chr(187).chr(191);//將資料寫入bom頭，chr是將16進位的序號轉成文字
        fwrite($file,$utf8_with_bom);       //轉出來的檔案，在一般文字編輯器內看不出檔頭，但是

        foreach($rows as $row){             //開始將資料寫入CSV檔，使用fwrite()
            $line=implode(',',[$row['id'],$row['name'],$row['age'],$row['birthday'],$row['addr']]);
            fwrite($file,$line);            //在$file檔案寫入$line內容
            // echo "<div class='text-light'>".$line."已寫入</div><br>";  //以前的版本fclose沒下的話檔案無法開，但還是要養成加fclose()的習慣
        }

        fclose($file);  
        $filename="download.csv";  //按了download才會產出這個filename
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>文字檔案匯入</title>
    <link rel="stylesheet" href="style.css">

    <style>

        body{
            background-image:url(https://images.unsplash.com/photo-1578070181910-f1e514afdd08?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=1404&q=80);
            background-repeat: no-repeat;
            background-size: cover;
            
        }

        table{
            width: 50%;
            border-collapse: collapse;
            text-align: center;
            margin: auto;
        }

        table td{
            padding: 5px 10px;
            border: 1px solid black;  
            background-color: #ccc; 
            
        }


        .download{
            display: block;
            width: 100px;
            padding: 5px 10px;
            border-radius: 20px;
            box-shadow: 0 0 5px #ccc;
            margin: 10px auto;
            text-align: center;

        }

    </style>
</head>
<body>
<h1 class="header mb-5 text-light">資料表內容匯出練習</h1>

<!----讀出匯入完成的資料----->
    
        <?php

            $rows=all('students');
                if(isset($filename)){
        ?>
    <a href="download.csv" download class="text-light text-center">~可以下載囉！~</a>

        <?php
        }
        ?>
    <table class="mb-5">
        <tr>
            <td class="alert-info" style="border-color:black; font-weight:700;">姓名</td>
            <td class="alert-info" style="border-color:black; font-weight:700;">年齡</td>
            <td class="alert-info" style="border-color:black; font-weight:700;">生日</td>
            <td class="alert-info" style="border-color:black; font-weight:700;">居住地</td>
        </tr>
    <?php
        foreach($rows as $row){
    ?>
        <tr>
            <td><?=$row['name'];?></td>
            <td><?=$row['age'];?></td>
            <td><?=$row['birthday'];?></td>
            <td><?=$row['addr'];?></td>
        </tr>
    <?php
        }
    ?>
    </table>
        <a href="?do=download" class="download bg-white">下載</a>

</body>
</html>
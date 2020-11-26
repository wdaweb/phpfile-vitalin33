<?php
/**
 * 1.建立資料庫及資料表來儲存檔案資訊
 * 2.建立上傳表單頁面
 * 3.取得檔案資訊並寫入資料表
 * 4.製作檔案管理功能頁面
 */


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>檔案管理功能</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table{
            border:10px double red;
            padding:20px;
            border-collapse:collapse;
            margin: auto;
        }

        td{
            border:1px solid #ccc;
            padding:5px;
        }
    </style>
</head>
<body>
<h1 class="header">檔案管理練習</h1>
<!----建立上傳檔案表單及相關的檔案資訊存入資料表機制----->
<!-------------- 建立一個連結來查看上傳後的圖檔  ------------------>

    <?php
    include_once "base.php";
        $rows=all('upload');
        echo "<table>";   //撈出所有資料，以表格呈現
        echo "<td>縮圖</td>";
        echo "<td>檔案名稱</td>";
        echo "<td>檔案類型</td>";
        echo "<td>檔案說明</td>";
        echo "<td>下載</td>";
        echo "<td>操作</td>";
        foreach($rows as $row){
            
            echo "<tr>";
                if($row['type']=='圖檔'){
                echo "<td><img src='{$row['path']}' style='width:100px'></td>";
                               
                }else{
                echo "<td><img src='./img/file_icon.png' style='width:20px'></td>";
                }
                echo "<td>{$row['name']}</td>";  //如果有很多欄位，可以再加一個foreach，如果只需要特定欄位，條列式即可
                echo "<td>{$row['type']}</td>";  
                echo "<td>{$row['note']}</td>";  
                echo "<td><a href='{$row['path']}' download>下載</a></td>";
                echo "<td><a href=''>編輯</a><a href=''>刪除</a></td>";  //有些人會在這裡夾上表單，用submit，範例在下方
            echo "</tr>";

                

        }
        echo "</table>";

            print_r($_POST);
     ?>

<!-- 
     <form action="?">
     <input type="submit" value="刪除">
     </form> 
-->





<!----透過資料表來顯示檔案的資訊，並可對檔案執行更新或刪除的工作----->




</body>
</html>
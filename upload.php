<?php
/**
 * 1.建立表單
 * 2.建立處理檔案程式
 * 3.搬移檔案
 * 4.顯示檔案列表
 */
    include_once "base.php";
    /*-----------------檢查檔案有沒有存在------------- */

    if(!empty($_FILES['img']['tmp_name'])){  //比對是否有tmp_name,有的話就是上傳成功，來源在表單的form->input

        //echo "檔案原始名稱：".$_FILES['img']['name']; 
        //echo "<br> 檔案上傳成功";
        //echo "<br> 原始上傳路徑：".$_FILES['img']['tmp_name'];    //把上傳的檔案移到目的地，目的地可以直接命名
    
    /*判斷副檔名的方法二：就沒有限定副檔名判斷，不會出錯*/
        $subname="";
        $subname=explode('.',$_FILES['img']['name']);
        $subname=array_pop($subname);

        /*判斷副檔名的方法一*/
        // switch($_FILES['img']['type']){
        //     case "image/jpeg":
        //         $subname=".jpg";
        //     break;
        //     case "image/png":
        //         $subname=".png";
        //     break;
        //     case "image/gif":
        //         $subname=".gif";
        //     break;
        // }

        $fileName=date("Ymdhis").".".$subname;//讓系統自動產出檔名
        move_uploaded_file($_FILES['img']['tmp_name'],"./images/".$fileName);    //要上傳的檔案名稱，再接上上傳目的地，檔案上傳成功後就以原始檔名來命名
        //move_uploaded_file($_FILES['img']['tmp_name'],"./images/".$_FILES['img']['name']);  

    /* 建立一個連結來查看上傳後的圖檔 */
             //echo "<img src='/images/$fileName' style='width:200px'>";    //僅上傳圖片可用，用來顯示剛上傳的圖片檔案
       
    /* 上傳檔案後，將檔案的資料(歷程)建入資料庫 */       
        $row=[
            "name"=>$_FILES['img']['name'],
            "path"=>"./images/".$fileName,
            "type"=>$_POST['type'],
            "note"=>$_POST['note']
        ];

        print_r($row);
        save("upload",$row);


        to('manage.php');
    }



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <link rel="stylesheet" href="style.css">
    <style>
        form{
            border:3px solid blue;
            margin:auto;
            padding: 20px;
            width: 500px;

        }

        form div{
            margin:5px 0;
        }

    </style>

</head>
<body>
 <h1 class="header">檔案上傳練習</h1>

 <!----建立你的表單及設定編碼----->
    <form action="?" method="POST" enctype="multipart/form-data"> <!-- POST可以上傳到比較大的內容，如果是GET的話頂多只能上傳ICON容量的檔案-->  <!--不同瀏覽器的上傳畫面不一樣-->

   


    <div>上傳的檔案：<input type="file" name="img"></div>              
    <div>檔案說明：<input type="text" name="note"></div>
    <div>檔案類型：<select name="type">   <!--建立選單讓使用者選擇，不建開放式填寫-->
        <option value="圖檔">圖檔</option> 
        <option value="文件">文件</option>
        <option value="其它">其它</option>
    </select></div> 
    <input type="submit" value="上傳">

    </form>


</body>
</html>
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
    if(!empty($_FILES['txt']['tmp_name'])){       //上傳檔案成功 = $_FILES['txt']['tmp_name'] 有值

        echo $_FILES['txt']['name'];   //如果 $_FILES['txt']['tmp_name'] 有值，則印出檔案名稱
        move_uploaded_file($_FILES['txt']['tmp_name'],"./upload/".$_FILES['txt']['name']);  //上傳路徑：
    
        //上傳後可以嘗試開啟檔案

        $file=fopen("./upload/".$_FILES['txt']['name'],'r');  //後面要加上開啟模式: 'r','r+','w','w+'.....
        $num=0;                                               //----------->用來判斷表頭不上傳
        while(!feof($file)){                                  //檢查檔案是否已經取完，使用while迴圈取出所有資料
            $line=fgets($file);                               //fget匯出的是純文字陣列
            if($num!=0){                                      //正常應該要有檢查步驟：
            $line=explode(",",$line);                         //取出陣列裡的資料後，再指定每一個欄位的key值才能存回資料庫
            $data=[                                           //不加id的原因：因為是新增資料，id會自動生成
                'name'=>$line[1],                             //$line[幾]的判斷：要對自己的資料夠瞭解，檔頭要注意不要寫進資料庫
                'age'=>$line[2],
                'birthday'=>$line[3],
                'addr'=>$line[4]
            ];
            save('students',$data);
            }
            $num++;
        }

        fclose($flie);


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
</head>
<body>
<h1 class="header">文字檔案匯入練習</h1>
<!---建立檔案上傳機制--->
    <form action="?" method="post" enctype="multipart/form-data" style="padding:30px;">
        <input type="file" name="txt">
        <input type="submit" value="上傳">
    </form>


<!----讀出匯入完成的資料----->
    


</body>
</html>
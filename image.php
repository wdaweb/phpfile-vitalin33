<?php
/****
 * 1.建立資料庫及資料表
 * 2.建立上傳圖案機制
 * 3.取得圖檔資源
 * 4.進行圖形處理
 *   ->圖形縮放
 *   ->圖形加邊框
 *   ->圖形驗證碼
 * 5.輸出檔案
 */
    if(!empty($_FILES['photo']['tmp_name'])){   //有上傳成功的話，就可以拿到檔案名稱

            echo "檔名：".$_FILES['photo']['name']."<br>";   
            echo "格式：".$_FILES['photo']['type']."<br>";   //判斷檔案格式
            echo "大小：".round(($_FILES['photo']['size'])/1024)."KB<br>";  //判斷檔案大小
            move_uploaded_file($_FILES['photo']['tmp_name'],'./images/'.$_FILES['photo']['name']);

        $filename="./images/".$_FILES['photo']['name'];
        $src_info=[
            'width'=>0,
            'height'=>0,
        ];
        $dst_info=[
            'width'=>0,
            'height'=>0,
        ];
        switch($_FILES['photo']['type']){

            case "image/jpeg":
                $src_img=imagecreatefromjpeg($filename);
            break;
            case "image/gif":
                $src_img=imagecreatefromgif($filename);
            break;
            case "image/png":
                $src_img=imagecreatefrompng($filename); 
            break;

            default:  //switch有個設定叫default, 是跟case都不符合的時候使用，要再加exit()以供跳出
            echo "限定上傳檔案類型：JPEG / GIF / PNG";
            exit();

        }
        $src_info['width']=imagesx($src_img);             //拿到寬度，拿到高度，就可以算出寬高比
        $src_info['height']=imagesy($src_img);
        $src_info['rate']=imagesy($src_img)/imagesx($src_img);
        if($src_info['rate']<=1){                        //算出長寬比後，可用判斷式算出是直向還是橫向
            $src_info['direction']='橫向(landscape)';                 
        }else{
            $src_info['direction']='直向(portrait)'; 
        }

        $dst_img=imagecreatetruecolor(200,200);
        $dst_info['width']=200;
        $dst_info['height']=200;

        $white=imagecolorallocate($dst_img,255,255,255);   //將底色變成白色
        imagefill($dst_img,0,0,$white);
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
        div{

            width: 500px;
            margin: 10px auto ;
            text-align: center;

        }

    </style>
</head>
<body>
<h1 class="header">圖形處理練習</h1>
<!---建立檔案上傳機制--->
    <form action="?" method="post" enctype="multipart/form-data">
    <input type="file" name="photo" id="">
    <input type="submit" value="上傳">

    </form>

    <h3>原始圖形</h3>
    <hr>
    <div>
    <img src="<?="./images/".$_FILES['photo']['name'];?>" style="width:250px">  

    </div>

<!----縮放圖形----->
    <h3>縮放圖形</h3>
    <hr>
    <?php
        if(isset($src_img) && isset($dst_img)){

            if($src_info['direction']=='橫向(landscape)'){          //計算目標(縮放)座標
                $dst_height=$dst_info['height']*$src_info['rate'];  //目標高度=來源高度*縮放長寬比例
                $dst_width=$dst_info['width'];                      //目標寬度=來源寬度*縮放長寬比例
                $dst_y=($dst_info['height']-$dst_height)/2;         //Y軸座標
                $dst_x=0;                                           //X軸座標

            }else{
                $dst_height=$dst_info['height'];      //目標高度=來源高度*縮放長寬比例
                $dst_width=$dst_info['width']*(1/$src_info['rate']);    //目標寬度=來源寬度*縮放長寬比例
                $dst_y=0;                                               //X軸座標
                $dst_x=($dst_info['width']-$dst_height)/2;              //Y軸座標



            }


            imagecopyresampled($dst_img,$src_img,$dst_x,$dst_y,0,0,$dst_width,$dst_height,$src_info['width'],$src_info['height']);  //這個指令的值只是布林值，我們看不到東西，而是要透過輸出才看得到
            $dst_path="./dst/".$_FILES['photo']['name'];
            imagejpeg($dst_img,$dst_path);

            echo "<div>";
            echo "<img src='$dst_path'>";
            echo "</div>";
        }

    ?>


<H3>圖形加邊框</H3>
<hr>
<!----圖形加邊框----->
<?php

        $border=5;   //決定border之後要產出一張圖，比例要跟上傳的圖一致
        $img_bor=imagecreatetruecolor()

?>

<!----產生圖形驗證碼----->



</body>
</html>
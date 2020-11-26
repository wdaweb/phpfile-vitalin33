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

        img{
            border: 2px solid #ccc;
            box-shadow: 0 0 5px #ccc;
        }
</style>

<?php
    include_once "base.php";
   

    /**刪除檔案
     * 1. 找出檔案的路徑
     * 2. 使用unlink刪除硬碟中的檔案
     * 3. 刪除檔案後再刪除資料表中的資料
     */

     
        if(!empty($_GET['id'])){                             //為什麼要從GET改成POST ：因為原有表單是POST格式，
            $row=find('upload',$_GET['id']);
        }


        if(!empty($_POST)){
            $row=find('upload',$_POST['id']);
            
            if(!empty($_FILES['img']['tmp_name'])){
                $row['name']=$_FILES['img']['name'];       //上傳成功才會有

                $subname="";
                $subname=explode('.',$_FILES['img']['name']);
                $subname=array_pop($subname);
                $fileName=date("Ymdhis").".".$subname;//讓系統自動產出檔名
                unlink($row['path']);   //先刪除舊資料的檔案

                $row['path']="./images/".$fileName; //在這裡更新新的path
                move_uploaded_file($_FILES['img']['tmp_name'],$row['path']);  //把更新的檔案入到我$row['path']路徑
            
            }

            $row['type']=$_POST['type'];
            $row['note']=$_POST['note'];
        

        save('upload',$row);
        to('manage.php');
    }
?>
    <form action="?" method="POST" enctype="multipart/form-data">
    <div><img src="<?=$row['path'];?>" style="width:200px"></div>
    <div>上傳的檔案：<input type="file" name="img"></div>              
        <div>檔案說明：<input type="text" name="note" value="<?=$row['note'];?>"></div>
        <div>檔案類型：<select name="type">   <!--建立選單讓使用者選擇，不建開放式填寫-->
            <option value="圖檔" <?=($row['type']=='圖檔')?'selected':'';?>>圖檔</option> 
            <option value="文件" <?=($row['type']=='文件')?'selected':'';?>>文件</option>
            <option value="其它" <?=($row['type']=='其它')?'selected':'';?>>其它</option>
        </select></div> 
        <input type="hidden" name="id" value="<?=$row['id'];?>">
        <input type="submit" value="更新">

        </form>
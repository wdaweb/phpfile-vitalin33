<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>檔案上傳</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" ></script> -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>

</head>


<?php

$dsn="mysql:host=localhost;dbname=file;charset=utf8";
$pdo=new PDO($dsn,'root','');

date_default_timezone_set("Asia/Taipei");
// session_start();

//請背一背QQ 
function find($table,$id){  //本語法預設只會取回一筆資料
    global $pdo;
    $sql="select * from $table where";
    if(is_array($id)){  //可以用is_numertic判斷是否是數字，或是用is_array判斷是否為陣列

        foreach($id as $key => $value){
            // echo $key."='".$value."'&&";    這樣做的話會在最後又跑出"&&"，也不能用，所以優化如下          
            //↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
            //$tmp[]=$key."='".$value."'";        //利用一個暫時的陣列來存放語句的片段
            $tmp[]=sprintf("`%s`='%s'",$key,$value);        //寫法二：sprintf：可以先決定字串的函式，%s是字串，%d是數字
        }
        $sql=$sql.implode('&&',$tmp);  //如果輸入的不是數字/是陣列的話就用這一段       
    }else{
        $sql=$sql." id = '$id' "; //如果是數字/不是陣列的話就用這一段
    }
    $row=$pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    return $row;
}

        function all($table, ...$arg){      
            global $pdo;
        //echo gettype($arg); //gettype()函式可以讓你知道這個陣列的資料型態
            $sql="select * from $table ";
            if(isset($arg[0])){
            if(is_array($arg[0])){
                    foreach($arg[0] as $key => $value){

                        $tmp[]=sprintf("`%s`='%s'",$key,$value);        //寫法二：sprintf：可以先決定字串的函式，%s是字串，%d是數字
                    }
                $sql=$sql."where".implode(' && ',$tmp);
            }else{
                //製作非陣列的語句接在SQL後面
                // echo "arg[0]不存在或arg[0]不是陣列";
                $sql=$sql.$arg[0];
            }
        }
            if(isset($arg[1])){
                //製作接在最後面的句子字串
                // $sql=$sql."order by date desc";
                $sql=$sql.$arg[1];
            }

            // echo $sql."<br>";
            return $pdo->query($sql)->fetchAll();
        }  
        function del($table,$id){
            global $pdo;
            $sql="delete from $table where";
            if(is_array($id)){ 
                foreach($id as $key => $value){
                    $tmp[]=sprintf("`%s`='%s'",$key,$value);    
                }
                $sql=$sql.implode('&&',$tmp);  
            }else{
                $sql=$sql." id = '$id' "; 
            }
            $row=$pdo->exec($sql);  //因為不需要回傳值，EXEC就可以
            return $row;
        }


        function update($table, $array){  /*update的set後面是要接key值，格式像是：set  `key1`='v1',     */
            global $pdo;                                                        /*   `key2`='v2',     */
            $sql="update $table set";                                           /*   `key3`='v3',     */
            foreach($array as $key => $value){                                 /*形式類式又要做很多遍的事，要直接聯想到迴圈*/
                if($key!='id'){
                $tmp[]=sprintf("`%s`='%s'",$key,$value);           //$tmp[]="`".$key."`='".$value."'";  最原始的寫法，但較複雜
                }          
            }
            $sql=$sql.implode(",",$tmp) . " where `id`='{$array['id']}'";
            echo $sql; 
             $pdo->exec($sql);     //執行(將資料寫入資料庫)    
        }
        function insert($table, $array){  /*insert 是key跟name分開來看*/
            global $pdo;
            $sql="insert into $table(`".implode("`,`",array_keys($array))."`) values('".implode("','",$array)."')";  /*key值相對於是欄位*/

            $pdo->exec($sql);
        }

        function save($table,$array) {   //同時做新增又可以更新

            if(isset($array['id'])){      //is_array($array)[可省略]判斷是不是陣列，再判斷裡面有沒有id(id存不存在)則使用 isset
                //update
                update($table,$array);    //有id則進行UPDATE
            }else{
                //insert
                insert($table,$array);    //沒有id則新增資料 (因為ID是在新增資料之後才生成)
            }
        }


        function to($url){

            header("location:".$url);
        }


        function q($sql){
            global $pdo;
            return $pdo->query($sql)->fetchAll();
        }











?>

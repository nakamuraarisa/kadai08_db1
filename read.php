<?php
//1.  DB接続します
try {
    $db_name =  '***';            //データベース名
    $db_host =  '***';  //DBホスト
    $db_id =    '***';                //アカウント名(登録しているドメイン)
    $db_pw =    '***';           //さくらサーバのパスワード
    $server_info ='mysql:dbname='.$db_name.';charset=utf8;host='.$db_host;
    $pdo = new PDO($server_info, $db_id, $db_pw);
} catch (PDOException $e) {
  exit('DB_CONNECT'.$e->getMessage());
}

//２．データ登録SQL作成
$sql = "SELECT * FROM kadai08_db1";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//３．データ表示
if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("SQL_ERROR:".$error[2]);
}

//全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
//JSONに値を渡す場合に使う
$json = json_encode($values,JSON_UNESCAPED_UNICODE);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>看護記録</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.time.min.js"></script>
</head>
<!-- Head[End] -->


<!-- Main[Start] -->
<div>
    <div class="container">
      <table>
        <table border='1' style='border-collapse: collapse; width: 50%; text-align: left;'>
            <thead>
                <tr>
                    <th>名前</th>
                    <th>日付</th>
                    <th>時間</th>
                    <th>熱</th>
                    <th>喉痛</th>
                    <th>嘔吐</th>
                    <th>下痢</th>
                    <th>頭痛</th>
                    <th>薬　</th>
                    <th>食事</th>
                    <th>備考</th>
                </tr>
            </thead>
        <?php foreach($values as $value){ ?>
            
            <tbody>
                <tr>
                    <th><?=$value["name"]?></th>
                    <th><?=$value["date"]?></th>
                    <th><?=$value["time"]?></th>
                    <th><?=$value["temp"]?></th>
                    <th><?=$value["nodo"]?></th>
                    <th><?=$value["outo"]?></th>
                    <th><?=$value["geri"]?></th>
                    <th><?=$value["zutu"]?></th>
                    <th><?=$value["kusuri"]?></th>
                    <th><?=$value["shokuji"]?></th>
                    <th><?=$value["memo"]?></th>
                </tr>
            </tbody>
        <?php } ?>
      </table>
    </div>
</div>
<br><br><br>
<!-- Main[End] -->

<div id="placeholder" style="width:600px;height:300px;"></div>

<script>
  //JSON受け取り
  $a = '<?=$json?>';
  const obj = JSON.parse($a);
  console.log(obj);

  // グラフに使用するデータを準備
  const plotData = obj.map(function(item) {
      // date と time を結合して Date オブジェクトに変換
      const datetime = `${item.date} ${item.time}`;
      return [new Date(datetime).getTime(), parseFloat(item.temp)]; // Dateオブジェクトを生成
  });

  console.log(plotData);

  // 日本時間へのオフセット（UTC+9）
  const jstOffset = 9 * 60 * 60 * 1000; // 9時間（ミリ秒）

  // 現在の日付と2日前の日付を計算
  const now = new Date(); // 現在の日時（UTC）
  const twoDaysAgo = new Date(); // 2日前の日時（UTC）
  twoDaysAgo.setDate(now.getDate() - 2); // 2日前に設定

  // JSTタイムスタンプに変換
  const nowTimestampJST = now.getTime() + jstOffset; // 現在の日本時間
  const twoDaysAgoTimestampJST = twoDaysAgo.getTime() + jstOffset; // 2日前の日本時間

  // Flotに渡すデータ形式
  var data = [
      { label: "Temperature", data: plotData }
  ];

  // グラフのオプション
  var options = { 
    xaxis: {
        mode: "time",        // x軸を時間軸に設定
        timeformat: "%Y-%m-%d %H:%M", // フォーマット
        min: twoDaysAgoTimestampJST,     // 2日前の日本時間をx軸の最小値に設定
        max: nowTimestampJST            // 現在の日本時間をx軸の最大値に設定
    },
    yaxis: { 
        min: 35,  // 温度の最小値
        max: 40   // 温度の最大値
    }
  };

  // グラフを描画
  $.plot($("#placeholder"), data, options);
</script>
</body>
</html>

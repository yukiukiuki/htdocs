<!-- アンケート結果表示・ファイルへの書き込み -->

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>アンケート結果</title>
  <link rel="stylesheet" href="css/write.css">
</head>
<body>
  <h1>アンケート結果</h1>

  <?php
    function h ($str) {
      return htmlspecialchars($str, ENT_QUOTES);
    }

    $username = $_POST['user-name']; //名前
    $mail = $_POST['user-mail']; //メールアドレス
    $age = $_POST['age']; //年齢
    if($age < 1 || $age > 8) {
      $error = 1; //入力エラーとして保持（値が1~8以外の時）
    }
    $gender = $_POST['gender']; //性別
    if($gender == 1 ) {
      $gender_name = '男性';
    } elseif($gender == 2) {
      $gender_name = '女性';
    } else {
      $error = 1; //入力エラーとして保持（値が1または2以外）
    }
    $reason = $_POST['reason']; //MCに興味を持って頂いたきっかけ
    $rinen = $_POST['rinen']; //三綱領の内、最も印象に残ったもの
    $impressions = $_POST['impressions']; //ご感想

    // エラーがない場合、アンケート結果を表示
    if ($error == 0) {
      // 「名前」の結果を出力
      echo '<p><span>名前：</span>' . h($username) . '</p>';
      // 「メールアドレス」の結果を出力
      echo '<p><span>Email：</span>' . h($mail) . '</p>';
      // 「年齢」の結果を出力
      if($age != 8) {
        echo '<p><span>年齢：</span>' . h($age) . '0代</p>';
      } else {
        echo '<p><span>年齢：</span>80代以上</p>';
      }
      // 「性別」の結果を出力
      echo '<p><span>性別：</span>' . h($gender_name) . '</p>';
      // 「MCに興味を持って頂いたきっかけ」の結果を出力
      echo '<p><span>MCに興味を持って頂いたきっかけ：</span></p>';
      echo '<div>';
      foreach($reason as $value) {
        switch($value) {
          case 0:
            echo '<li>証券会社からの紹介</li>';
            break;
          case 1:
            echo '<li>新聞報道</li>';
            break;
          case 2:
            echo '<li>MCのHP</li>';
            break;
          case 3:
            echo '<li>知人からの紹介</li>';
            break;
          case 4:
            echo '<li>事業内容に関心がある</li>';
            break;
          case 5:
            echo '<li>その他</li>';
            break;
        }
      }
      echo '</div>';
      // 「三綱領の内、最も印象に残ったもの」の結果を出力
      echo '<p><span>三綱領の内、最も印象に残ったもの：</span></p>';
      echo '<div>';
      foreach($rinen as $value) {
        switch($value) {
          case 0:
            echo '<li>所期奉公</li>';
            break;
          case 1:
            echo '<li>処事光明</li>';
            break;
          case 2:
            echo '<li>立業貿易</li>';
            break;
        }
      }
      echo '</div>';
      // 「ご意見」の結果を出力
      echo '<p><span>ご感想：</span><br>' . h($impressions) . '</p>';
      
      // アンケート結果を保存する処理
      /*
      $results[0]  ：男性が選択された回数
      $results[1]  ：女性が選択された回数
      $results[2]  ：10代が選択された回数
      $results[3]  ：20代が選択された回数
      $results[4]  ：30代が選択された回数
      $results[5]  ：40代が選択された回数
      $results[6]  ：50代が選択された回数
      $results[7]  ：60代が選択された回数
      $results[8]  ：70代が選択された回数
      $results[9]  ：80代以上が選択された回数
      $results[10] ：証券会社からの紹介が選択された回数
      $results[11] ：新聞報道が選択された回数
      $results[12] ：MCのHPが選択された回数
      $results[13] ：知人からの紹介が選択された回数
      $results[14] ：事業内容に関心があるが選択された回数
      $results[15] ：その他が選択された回数
      $results[16] ：所期奉公が選択された回数
      $results[17] ：処事光明が選択された回数
      $results[18] ：立業貿易が選択された回数
      $results[19] ：アンケート回答の総数
      */
      
      // アンケート結果を保存するテキストファイルを指定
      $textfile = './data/data.txt';
      
      // 読み込み/書き出し設定でテキストファイルをオープン
      $fp = fopen($textfile, 'r+b');
      // ファイルの存在有無チェック
      if(!$fp) {
        exit('ファイルが存在しないです');
      }
      // ファイルの最後の行(EOF)に達するまで、fgets()で各行を読み出す(end of file)
      while(!feof($fp)) {
        // trim()でスペースを除去して、配列に格納
        
        $results[] = trim(fgets($fp));
      }
      
      if($gender == 1) {
        $results[0] ++;
      } elseif ($gender == 2) {
        $results[1] ++;
      }
      
      // $ageに格納されたvalueに1を加算すると、年代に対応したresults配列の値になる。
      // 例)$age=1(10代)⇨results[2]という感じ。
      $results[$age + 1] ++;
      
      // $reasonに格納されたvalueに10を加算すると、コンサートを知ったきっかけに対応したresults配列の値になる。
      // 例)$reason=0(証券会社からの紹介)⇨results[10]という感じ。
      foreach($reason as $value) {
        $results[$value + 10] ++;
      }
      
      // $rinenに格納されたvalueに16を加算すると、印象に残った綱領に対応したresults配列の値になる。
      // 例)$rinen=0(所期奉公)⇨results[16]という感じ。
      foreach($rinen as $value) {
        $results[$value + 16] ++;
      }
      
      // アンケートの総数をカウントアップ
      $results[19] ++;
      
      // ファイルポインタの位置を先頭に戻す
      rewind($fp);
      
      foreach($results as $value) {
        fwrite($fp, $value . "\n");
      }
      
      fclose($fp);
      
      echo '<p class="message sucess">以上の内容を保存しました。<br>アンケートへのご協力、誠に有難う御座います。</p><a href="read.php">集計結果ページへ</a>';
    } else { //エラーがあった場合
      echo '<p class="message error">恐れ入りますが<a href="input.php">アンケート回答ページ</a>に戻り、アンケートの再回答をお願いします。</p>';
    }
      
  ?>
</body>
</html>
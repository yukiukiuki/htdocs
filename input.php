<!-- アンケート回答ページの表示 -->

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>株主アンケート</title>
  <link rel="stylesheet" href="css/input.css">
</head>
<body>
  <h1>MC株主様アンケート回答ページ</h1>

  <form action="write.php" method="post">
    <!-- 名前 -->
    <div class="question">
      <label for="name">氏名：</label>
      <input type="text" name="user-name">
    </div>

    <!-- メールアドレス -->
    <div class="question">
      <label for="mail">Email：</label>
      <input type="email" name="user-mail">
    </div>

    <!-- 年齢 -->
    <div class="question">
      <label for="age">年齢：</label>
      <select name="age" id="age">
      <!-- 最初と最後のoption要素はHTMLで記述し、その他はfor文を使って出力する -->
        <option value="0" selected>お選びください</option>
        <?php
          for($num = 1; $num <= 7; $num++) {
            echo '<option value="' . $num .  '">' . $num . '0代</option>';
          }
        ?>
        <option value="8">80代以上</option>
      </select>
    </div>

    <!-- 性別 -->
    <div class="question">
      <label for="gender-list">性別：</label>
      <input type="radio" name="gender" value="1"> 男性
      <input type="radio" name="gender" value="2"> 女性
    </div>

    <!-- MCに興味を持って頂いたきっかけ -->
    <p class="title">Q1.MCに興味を持って頂いたきっかけ：</p>
    <?php
      // foreach文でチェックボックスを生成するため、$reasonでkey用配列を作る
      $reason = array(
        0 => "証券会社からの紹介",
        1 => "新聞報道",
        2 => "MCのHP",
        3 => "知人からの紹介",
        4 => "事業内容に関心がある",
        5 => "その他");
      $ids = array('shoken', 'news', 'hp', 'friends', 'business', 'other');
      // チェックボックスをforeach文で生成する
      foreach($reason as $key => $value) {
        echo '<input
               type="checkbox"
               name="reason[]"
               value="' .$key . '" id="' . $ids[$key] .
              '">'. $value . "\n";
      }
    ?>

    <!-- 三綱領の内、最も印象に残ったもの -->
    <p class="title">Q2.三綱領の内、最も印象に残ったもの：</p>
    <?php
      $rinen = array(
        0 => "所期奉公",
        1 => "処事光明",
        2 => "立業貿易");
      $ids = array('shoki', 'shoji', 'ritsu');
      // チェックボックスをforeach文で生成する
      foreach($rinen as $key => $value) {
        echo '<input
               type="checkbox"
               name="rinen[]"
               value="' .$key . '" id="' . $ids[$key] .
              '">'. $value . "\n";
      }
    ?>

    <!-- ご感想 -->
    <p class="title">Q3.ご意見：</p>
    <textarea name="impressions" cols="40" rows="4"></textarea>
    <!-- 送信・リセットボタン -->
    <div>
      <input type="submit" class="btn btn-submit">
      <input type="reset" class="btn btn-reset">
    </div>
  </form>
</body>
</html>
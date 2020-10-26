<?php
  use PHPMailer\PHPMailer\PHPMailer;

  if($_SERVER['REQUEST_METHOD'] === 'GET') {

    session_cache_limiter('public');
    session_start();

    // 暗号学的に安全なランダムなバイナリを生成し、それを16進数に変換することでASCII文字列に変換します
     $toke_byte = openssl_random_pseudo_bytes(16);
     global $csrf_token;
     $csrf_token  = bin2hex($toke_byte);
     // 生成したトークンをセッションに保存します
     $_SESSION['csrf_token'] = $csrf_token;

    // クリックジャッギング対策
    header('X-FRAME-OPTIONS: DENY');

  }else if($_SERVER['REQUEST_METHOD'] === 'POST') {

    session_start();

    // require 'C:\xampp\lib\PHPMailer-master\src\Exception.php';
    require 'PHPMailer/Exception.php';
    // require 'C:\xampp\lib\PHPMailer-master\src\PHPMailer.php';
    require 'PHPMailer/PHPMailer.php';
    // require 'C:\xampp\lib\PHPMailer-master\src\SMTP.php';
    require 'PHPMailer/SMTP.php';
    require 'setting.php';

    if(isset($_POST['company-name'])){
      $company_name = '';
    }
    if(isset($_POST['department-name'])){
      $department_name = '';
    }
    if(isset($_POST['staff-name'])){
      $staff_name = '';
    }
    if(isset($_POST['mail-address-first'])){
      $mail_address_first = '';
    }
    if(isset($_POST['mail-address-second'])){
      $mail_address_second = '';
    }
    if(isset($_POST['TEL'])){
      $TEL = '';
    }
    if(isset($_POST['contact-main'])){
      $contact_main = '';
    }

    //メールヘッダインジェクション対策に改行を削除する
    //XSS対策にエスケープ処理を行う

    $company_name = str_replace( array("\r\n", "\r", "\n"), '' , htmlspecialchars($_POST['company-name']) );
    $department_name = str_replace( array("\r\n", "\r", "\n"), '' , htmlspecialchars($_POST['department-name']) );
    $staff_name = str_replace( array("\r\n", "\r", "\n"), '' , htmlspecialchars($_POST['staff-name']) );
    $mail_address_first = str_replace( array("\r\n", "\r", "\n"), '' , htmlspecialchars($_POST['mail-address-first']) );
    $mail_address_second = str_replace( array("\r\n", "\r", "\n"), '' , htmlspecialchars($_POST['mail-address-second']) );
    $TEL = str_replace( array("\r\n", "\r", "\n"), '' , htmlspecialchars($_POST['TEL']) );
    $contact_main = str_replace( array("\r\n", "\r", "\n"), '' , htmlspecialchars($_POST['contact-main']) );

    /** メールの送信テスト */

    /// メーラーインスタンス作成
    $mailer = new PHPMailer();

    /// 文字コード
    $mailer->CharSet = 'UTF-8';
    $mailer->Encoding = '7bit';

    /// SMTPサーバーを利用する
    $mailer->IsSMTP();
    $mailer->SMTPAuth = true;

    /// SMTPサーバー
    $mailer->Host = MAIL_HOST;
    /// 送信元のユーザー名
    $mailer->Username = MAIL_USERNAME;
    /// 送信元のパスワード
    $mailer->Password = MAIL_PASSWORD;
    /// TLS暗号化を有効にし、SSLも受け入れる
    $mailer->SMTPSecure = MAIL_ENCRPT;
    /// ポート番号
    $mailer->Port = SMTP_PORT;

    /// 送信元メルアド
    $mailer->From = MAIL_FROM;
    /// 送信者名
    $mailer->FromName = MAIL_FROM_NAME;

    /// 送信先と件名・本文を設定してテスト送信
    /// 送信先アドレス
    $mailer->addAddress( $mail_address_first );
    $mailer->addBCC(MAIL_SUBMIT_CHECK);
    /// メール件名
    $mailer->Subject = MAIL_SUBJECT_CLIENT;
    /// メール本文
    $body = '';
    $body .= $staff_name.'様'."\r\n\r\n";
    $body .= '*********************************'."\r\n";
    $body .= 'このメールはお問い合わせ完了を'."\r\n";
    $body .= 'お知らせする自動配信メールです。'."\r\n";
    $body .= '*********************************'."\r\n\r\n\r\n";
    $body .= "Creative Designer's Office Kです。"."\r\n";
    $body .= 'この度はお問い合わせいただき、ありがとうございました。'."\r\n\r\n";
    $body .= '以下の内容でお問い合わせを承りました。'."\r\n\r\n";
    $body .= '・会社名：'.$company_name."\r\n";
    $body .= '・部署名：'.$department_name."\r\n";
    $body .= '・ご担当者名：'.$staff_name."\r\n";
    $body .= '・電話番号：'.$TEL."\r\n";
    $body .= '・お問い合わせ内容：'.$contact_main."\r\n\r\n\r\n";
    $body .= 'お問い合わせ内容の件につきましては、追ってご連絡いたします。'."\r\n\r\n";
    $body .= '*ご質問等がある場合や2営業日以内に返信が無い場合は、'."\r\n";
    $body .= 'お手数をおかけしますが、こちらのメールアドレスよりお問い合わせください。'."\r\n";
    $body .= 'Email:Office-K@xxx.com'."\r\n\r\n";
    $body .= '*お問い合わせいただいていないのに、万が一こちらのメールが届いておりました場合は、'."\r\n";
    $body .= 'お手数をおかけしますが、早急にご連絡いただけますと幸いです。'."\r\n\r\n\r\n";
    $body .= '***********************************'."\r\n";
    $body .= 'ファンが通うホームページに'."\r\n";
    $body .= '企業に寄り添ったホームページ制作'."\r\n";
    $body .= "Creative Designer's Office K"."\r\n\r\n";
    $body .= 'URL:http://mentalk.wp.xdomain.jp/'."\r\n";
    $body .= 'Email:Office-K@xxx.com'."\r\n";
    $body .= '***********************************';

    $mailer->Body = $body;

    /// メール送信
    $result = $mailer->send();

    // メール送信完了後、リダイレクトでGETにする(二重送信防止)
    header('Location: index.php');
    exit();

      //CSRF対策
      // POSTでcsrf_tokenの項目名でパラメーターが送信されていること且つ、
      // セッションに保存された値と一致する場合は正常なリクエストとして処理を行います
      if (!isset($_POST["csrf_token"])
       || htmlspecialchars($_POST["csrf_token"]) !== htmlspecialchars($_SESSION['csrf_token'])) {

       echo "不正なリクエストです";
       exit();

       }

       // クリックジャッギング対策
       header('X-FRAME-OPTIONS: DENY');

  }
 ?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo('name'); ?></title>
    <!-- <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP&display=swap" rel="stylesheet"> -->
    <?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>
    <header>
      <a href = "#" class = "home-link">
        <!-- <img class = "logo" src = "https://www.bravo-web.com/bravocms/wp-content/themes/bravoweb/images/headerLogo.svg"> -->
        Creative Designer's Office K
      </a>
      <div class = "header-menu-list-wrapper">
        <ul class = "header-menu-list">
          <li class = "header-menu-list-contents">
            <a href = "#works" class = "header-menu-link">WORKS</a>
          </li>
          <li class = "header-menu-list-contents">
            <a href = "#service" class = "header-menu-link">SERVICE</a>
          </li>
          <!-- <li class = "header-menu-list-contents">
            <a href = "#" class = "header-menu-link">NEWS&COLUMNS</a>
          </li> -->
          <li class = "header-menu-list-contents">
            <a href = "#company" class = "header-menu-link">COMPANY</a>
          </li>
        </ul>
      </div>
      <!-- <div class = "sidebar">
        <div class = "sidebar-wrapper">
          <ul class = "sidebar-list">
            <li class = "sidebar-list-contents">
              <a href = "#" class = "sidebar-link">FACEBOOK</a>
            </li>
            <li class = "sidebar-list-contents">
              <a href = "#" class = "sidebar-link">TWITTER</a>
            </li>
            <li class = "sidebar-list-contents">
              <a href = "#" class = "sidebar-link">MAIL MAGAZINE</a>
            </li>
          </ul>
          <a href = "#" class = "contact-link">CONTACT</a>
        </div>
      </div> -->
      <div class = "hamburger-menu">
        <span class = "hamburger-line-first"></span>
        <span class = "hamburger-line-second"></span>
        <span class = "hamburger-line-third"></span>
      </div>
    </header>

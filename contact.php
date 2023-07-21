<?php
$hata = false;
$gonder = false;
//Gönderme işleminin mevcut olup olmadığını kontrol ediyoruz.
if( isset($_POST["islem"]) && $_POST["islem"]=="gonder" ) {
	
	//Formdan gelen verilerin eksiksiz olup olmadığını kontrol ediyoruz.
	if( !empty($_POST["adsoyad"]) && !empty($_POST["email"]) && !empty($_POST["konu"]) && !empty($_POST["mesaj"]) ) {
		
		//PHPMailer
		include_once('phpmailer/class.phpmailer.php');
		
		//Ayarlar (Bu ayarlar için gerekli bilgiler kullandığınız sunucuya göre değişebilir.)
		$mail = new PHPMailer();
		$mail->isSMTP();  //SMTP Aktif
		//$mail->SMTPDebug = 1; //Hata Gösterimi Aktif
		//$mail->SMTPSecure = 'tls';  //TLS Aktif
		$mail->SMTPAuth   = true;  //SMTP Kimlik Doğrulaması Aktif
		$mail->Host       = 'host@example.com';  //SMTP Host
		$mail->Username   = 'mail@example.com';  //SMTP Kullanıcı Adınız
		$mail->Password   = 'password';	 //SMTP Şifreniz
		$mail->Port       = 587;  //SMTP Portu
		$mail->setFrom('mail@example.com', 'Gönderen Adı');  //Mailin Kimden Gönderildiği
		$mail->addAddress('contact@example.com', 'Alıcı Adı');	//Mailin Gönderileceği Adres (Buraya formdan gelen mesajın gönderileceği mail adresini giriniz.)
		
		//HTML Aktif
		$mail->isHTML(true);
		$mail->CharSet ="utf-8";
		//Mail Başlığı
		$mail->Subject = 'İletişim Formu Mesajı';
		//Mail İçeriği
		$mail->Body    = '<p><strong>Gönderen:</strong> ' . $_POST["adsoyad"] . ' - ' . $_POST["email"] . '</p>'.
		'<p><strong>Konu:</strong> ' . $_POST["konu"] . '</p>'.
		'<p><strong>Mesaj:</strong> ' . $_POST["mesaj"] . '</p>';

		//Gönder
		if ( $mail->send() ) {
			$gonder = true;
		} else {
			$hata = true;
			$hata_mesaj = "Mesaj gönderilirken bir hata oluştu: ".$mail->ErrorInfo;
		}
	} else {
		$hata = true;
		$hata_mesaj = "Lütfen tüm alanları doldurun.";
	}
	
}
?>

<!DOCTYPE html>
<html lang="TR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Vion Blog</title>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-lg-6 mt-4">
        <a href="./" class="logo"><strong>Blog Tasarımı</strong></a>
      </div>
      <div class="col-lg-6 mt-4 text-end">
        <a href="index.php" class="menu">Ana Sayfa</a>
        <a href="contact.php" class="menu">İletişim</a>
        <a href="index.php" class="menu">Blog</a>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center mt-5 mb-5">
        <h1><strong>İletişim</strong></h1>
        <p>Buradan bize ulaşabilirsiniz.</p>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <?php if ($gonder) { ?>
        <div class="alert alert-success">Mesajınız başarıyla gönderildi.</div>
        <?php } ?>

        <?php if ($hata) { ?>
        <div class="alert alert-warning"><?php echo $hata_mesaj; ?></div>
        <?php } ?>
        <form action="" method="POST">
            <strong>Ad Soyad</strong>
            <input type="text" name="adsoyad" id="" class="form-control" required>
            <strong>E-Posta</strong>
            <input type="text" name="email" id="" class="form-control" required>
            <strong>Konu</strong>
            <input type="text" name="konu" id="" class="form-control" required>
            <strong>Mesaj</strong>
            <textarea name="mesaj" id="" cols="30" rows="10" class="form-control" required></textarea>
            <br />
            <input type="hidden" name="islem" value="gonder" required>
            <button type="submit" class="btn btn-success">Gönder</button>
        </form>
      </div>
    </div>
  </div>
</body>

<!-- scripts -->
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="js/particles.js"></script>
<script src="js/app.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
</html>   
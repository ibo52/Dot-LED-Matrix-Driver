<?php
session_start();
ob_start();


function uyari($title, $status, $message)
{
  ?>
    <script>
	setTimeout(() => {
                            $(document).Toasts('create', {
                              title:"<?php echo $title; ?>",
                              body: "<?php echo $message; ?>",
                              subtitle:"<?php echo $status; ?>",
                              autohide: true,
                              delay: 3000
                            })

                            },500);
</script>
  <?php
}

$COMPONENTS_ROOT = "components/";
$API_ROOT = "api/";
$PAGE_BACKBONE = $COMPONENTS_ROOT."core/";

include_once($API_ROOT."db_config.php");

//header: html açılış etiketi ve header kapanış etiketine kadar olan kısım
include_once($PAGE_BACKBONE.'header.php');

//üst navigasyon menü çubuğu: body açılış etiketi
include_once($PAGE_BACKBONE."navbar.php");

//<!-- sol açılır menu -->
include_once($PAGE_BACKBONE.'sidebar.php');

/*
-------------------------------------------
sayfada gösterilecek bileşenler
*/
include_once($PAGE_BACKBONE.'forwarder.php');

//include_once($COMPONENTS_ROOT.'toast.php');

/*
sayfada gösterilecek bileşenler
-------------------------------------------
*/

//adminlte body
//include_once('components/body.php');

//footer: (body ve html) kapanış etiketine kadar olan kısım
include_once($PAGE_BACKBONE.'footer.php');
?>
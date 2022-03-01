<?php
//  See: http://docs.liveres.co.uk/

//  TODO: Does this implement cookies — if so, should it run before cookies have been accepted by the browser?
?>

<div class="LiveRes" id="liverescontainer">
  <script type="text/javascript">
    _fez_account = "02ae4f80-c4e7-42c3-946e-d444ae1d9279";
    _fez_brand = "1";
    _fez_rest = "";
    _fez_width = "100%";
    _fez_height = "100%";
    _fez_scrolling = "yes";
    _fez_anal = "";
    _fez_stylesheet = "<?= $kirby->url('assets'); ?>/css/LiveRes.css";
    _fez_mobile = "no"
    _fez_ascript = "0"
    _fez_head = "";
    _fez_desc = "";
    _fez_offer = "";
    _fez_offerpopup = "1";
    _fez_partner = "";
    _fez_restaurantpicker = "";
    _fez_daymarketingpopup = "1";
    _fez_offerpicker = "";
    _fez_offerpopupchoosefullprice = "1";
    _fez_choosefullprice = "1";

    //  Don’t set a cookie to remember the users details
    _fez_nocookie = "1";
  </script>

  <?php
  //  If on localhost, only get the script via HTTP, otherwise the CSS file won’t load
  $is_https = Server::https();
  ?>
  <script type="text/javascript" src="<?= $is_https ? 'https' : 'http'; ?>://bookings.liveres.co.uk/scripts/fez.js"></script>

  <?php
  //  Noscript fallback
  ?>
  <noscript>
    <div class="LiveRes-noscript">
      <p>ERROR: It looks like you’re not running JavaScript in your browser.</p>
      <p>To book, please contact <a href="<?= url('/locations'); ?>">your chosen location</a> directly.</p>
    </div>
  </noscript>
</div>

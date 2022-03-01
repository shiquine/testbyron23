<?php

//  $address is required
if (!isset($address) or $address->isEmpty()) return;

$line_one = $address->line_one();
$line_two = $address->line_two();
$city = $address->city();
$county = $address->county();
$postcode = $address->postcode();
$url = $address->url();

$phone = $phone ?? false;
$email = $email ?? false;

//  There has to be something here
if ($line_one->isEmpty() and $line_two->isEmpty()) return;
?>
<address class="Address">
  <?php
  //  Street Address
  if ($line_one->isNotEmpty()):
  ?>
    <a href="<?= $url; ?>" class="Address-physical">
      <?php
      //  Line One
      ?>
      <div class="Address-row"><?= $line_one->escape('html'); ?></div>

      <?php
      //  Line Two
      if ($line_two->isNotEmpty()):
      ?>
        <div class="Address-row"><?= $line_two->escape('html'); ?></div>
      <?php
      endif;

      //  City, County Postcode ?>
      <div class="Address-row"><?php
        //  City
        if ($city->isNotEmpty()):
          echo $city->escape('html');
        endif;

        //  Divider
        if ($city->isNotEmpty() and ($county->isNotEmpty() or $postcode->isNotEmpty())):
          echo ', ';
        endif;

        //  County
        if ($county->isNotEmpty()):
          echo $county->escape('html');
        endif;

        //  Divider
        if ($county->isNotEmpty() and $postcode->isNotEmpty()):
          echo ' ';
        endif;

        //  Postcode
        if ($postcode->isNotEmpty()):
          echo $postcode->escape('html');
        endif;
      ?></div>
    </a>
  <?php
  endif;

  //  Phone
  if ($phone and $phone->isNotEmpty()):
  ?>
    <a class="Address-phone" href="<?= Str::encode('tel:' . $phone); ?>"><?= Str::encode($phone->escape('html')); ?></a>
  <?php
  endif;

  //  Email
  if ($email and $email->isNotEmpty()):
  ?>
    <a class="Address-email" href="<?= Str::encode('mailto:' . $email); ?>"><?= Str::encode($email->escape('html')); ?></a>
  <?php
  endif;
  ?>
</address>

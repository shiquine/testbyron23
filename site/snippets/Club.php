<?php
//  See: https://airship.stoplight.io/docs/airship-rest-api/APIs/api-docs.json/paths/~1contact/post

//  See: https://developers.airship.co.uk/basics/contacts/write-a-contact

$club_page = $site->index()->template('club')->first();
$form_consent_message = $club_page->form_consent_message()->or('Tick here to join Byron Club and allow us to send you emails with offers and news');
$form_thank_you_message = $club_page->form_thank_you_message()->or('Thank you! We’re excited to have you as a member and can’t wait to spoil you with all the perks of the Byron Club!');

$form_response = $form_response ?? [];

$errors = $form_response['errors'] ?? [];
$error = $form_response['error'] ?? false;
$has_error = (!empty($errors) or $error);

$data = $form_response['data'] ?? [];
$success = $form_response['id'] ?? false;
?>

<div class="Club" data-club>
  <div class="Club-outer">
    <div class="Club-inner">
      <?php
      //  Join Byron Club
      ?>
      <h2 class="Club-heading">
        <span>Join Byron Club!</span>
        <?php
        snippet('../../assets/img/vector/join-byron-club.svg');
        ?>
      </h2>

      <?php
      //  Submitting
      //  TODO: Test with a screen reader
      ?>
      <div class="Club-submitting" role="alert">
        <h3>Submitting</h3>
        <p>This could take a few seconds...</p>
      </div>

      <?php
      //  Errors
      //  TODO: Test with a screen reader
      if ($has_error):
      ?>
        <div class="Club-errors" role="alert">
          <h3>Error!</h3>

          <?php
          //  Validation Errors
          if (!empty($errors)):
          ?>
            <p>Please correct the following errors to submit:</p>
            <ul>
              <?php
              foreach ($errors as $field => $error):
                //  If passed back from AirShip, errors will be multidimensional
                if (is_array($error)):
                  foreach ($error as $item):
                  ?>
                    <li><?= Escape::html($item); ?></li>
                  <?php
                  endforeach;
                else:
                ?>
                  <li><?= Escape::html($error); ?></li>
                <?php
                endif;
              endforeach;
              ?>
            </ul>
          <?php

          //  Connection Error
          elseif ($error):
          ?>
            <p><?= Escape::html($error); ?>
          <?php
          endif;
          ?>
        </div>
      <?php
      endif;

      //  Success
      //  TODO: Test with a screen reader
      if ($success):
      ?>
        <div class="Club-success" role="alert">
          <h3>Success!</h3>
          <?= $form_thank_you_message->text(); ?>
        </div>
      <?php
      endif;
      ?>

      <form
        class="Club-form<?= $success ? ' Club-form--hidden' : ''; ?>"
        method="POST"
        autocomplete="off"
        novalidate
        action="<?= url('/byron-club'); ?>"
        data-club-form
      >
        <?php
        //  Email
        ?>
        <div class="Club-field" data-club-field="1" data-active>
          <label for="Club-email">Email</label>
          <input
            id="Club-email"
            type="email"
            name="email"
            autocomplete="email"
            placeholder="Email"
            value="<?= $data['email'] ?? ''; ?>"
          >
        </div>

        <?php
        //  First Name / Last Name
        ?>
        <div class="Club-field Club-field--names" data-club-field="2">
          <div class="Club-fieldInner">
            <label for="Club-firstname">First name</label>
            <input
              id="Club-firstname"
              type="text"
              name="first_name"
              autocomplete="given-name"
              placeholder="First name"
              value="<?= $data['first_name'] ?? ''; ?>"
            >

            <span aria-hidden="true">/</span>

            <label for="Club-lastname">Last name</label>
            <input
              id="Club-lastname"
              type="text"
              name="last_name"
              autocomplete="family-name"
              placeholder="Last name"
              value="<?= $data['last_name'] ?? ''; ?>"
            >
          </div>
        </div>

        <?php
        //  Date of Birth
        //  See select fallback from: https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/date
        ?>
        <div class="Club-field Club-field--dob" data-club-field="3">
          <div class="Club-fieldInner">
            <?php
            //  Day
            ?>
            <label for="Club-dob-day">Date of birth — Day</label>
            <select
              id="Club-dob-day"
              name="dob_day"
            >
              <?php
              for ($i = 1; $i <= 31; $i += 1):
                $selected = ((isset($data['dob_day']) and ($data['dob_day'] == $i)) || (!isset($data['dob_day']) and $i === 1));
              ?>
                <option
                  value="<?= $i; ?>"
                  <?= $selected ? 'selected' : ''; ?>
                ><?= $i; ?></option>
              <?php
              endfor;
              ?>
            </select>

            <span aria-hidden="true">/</span>

            <?php
            //  Month
            $months = [
              '01' => 'January',
              '02' => 'February',
              '03' => 'March',
              '04' => 'April',
              '05' => 'May',
              '06' => 'June',
              '07' => 'July',
              '08' => 'August',
              '09' => 'September',
              '10' => 'October',
              '11' => 'November',
              '12' => 'December',
            ];
            ?>
            <label for="Club-dob-month">Date of birth — Month</label>
            <select
              id="Club-dob-month"
              name="dob_month"
            >
              <?php
              foreach ($months as $value => $month):
                $selected = ((isset($data['dob_month']) and ($data['dob_month'] == $value)) || (!isset($data['dob_month']) and $value === 1));
              ?>
                <option
                  value="<?= $value; ?>"
                  <?= $selected ? 'selected' : ''; ?>
                ><?= $month; ?></option>
              <?php
              endforeach;
              ?>
            </select>

            <span aria-hidden="true">/</span>

            <?php
            //  Year
            ?>
            <label for="Club-dob-year">Date of birth — Year</label>
            <select
              id="Club-dob-year"
              name="dob_year"
            >
              <?php
              for ($i = 1900; $i <= date('Y'); $i += 1):
                $selected = ((isset($data['dob_year']) and ($data['dob_year'] == $i)) || (!isset($data['dob_year']) and $i === 2000));
              ?>
                <option
                  value="<?= $i; ?>"
                  <?= $selected ? 'selected' : ''; ?>
                ><?= $i; ?></option>
              <?php
              endfor;
              ?>
            </select>
          </div>
        </div>

        <?php
        //  Mobile Number
        ?>
        <div class="Club-field" data-club-field="4">
          <label for="Club-mobile">Mobile number</label>
          <input
            id="Club-mobile"
            type="tel"
            name="mobile_number"
            autocomplete="tel"
            placeholder="Mobile number"
            value="<?= $data['mobile_number'] ?? ''; ?>"
          >
        </div>

        <?php
        //  Local Byron
        ?>
        <div class="Club-field Club-field--location" data-club-field="5">
          <div class="Club-fieldInner">
            <label for="Club-location">Your local Byron</label>
            <select
              id="Club-location"
              name="location"
            >
              <option value="">Your local Byron</option>
              <?php
              foreach ($locations as $location):
                $title = $location->title();
                $airship_id = $location->airship_id();
                if ($airship_id->isEmpty()) continue;

                $selected = (isset($data['location']) and ($data['location'] === $airship_id->value()));
              ?>
                <option
                  value="<?= $airship_id->value(); ?>"
                  <?= $selected ? 'selected' : ''; ?>
                ><?= $title->escape('html'); ?></option>
              <?php
              endforeach;
              ?>
            </select>
          </div>
        </div>

        <?php
        //  Next Step
        ?>
        <button
          class="Club-progress"
          type="button"
          data-club-progress
          aria-label="Go to next step"
        ><?php snippet('../../assets/img/vector/chevron-right.svg'); ?></button>

        <?php
        //  Consent
        ?>
        <div class="Club-field" data-club-field="6">
          <input
            type="checkbox"
            id="Club-consent"
            name="consent"
            required
            <?= (isset($data['consent']) and ($data['consent'] === 'on')) ? 'checked' : ''; ?>
          >
          <label
            class="Club-checkboxLabel"
            for="Club-consent"
          >
            <?= $form_consent_message->text(); ?>
            <?php snippet('../../assets/img/vector/cross.svg'); ?>
          </label>

          <?php
          //  Submit
          ?>
          <button class="Button Button--block" type="submit">Submit</button>
        </div>
      </form>
    </div>
  </div>

  
  <div class = "box_form">

            <div class = "checkboxtest">
                <form method = "POST" action = "default.php"  > 

                    <input id = "checktest" type = "checkbox" name = "checkbox1">
                    <label class = "tick">Tick here to allow us to send you emails with great offers</label>

                </form>

            </div>




            <div class = "form_test">
                
                <form method = "POST" class = "section_one" action = "default.php">
                    <label class = "firstname">first Name</label>
                    <input class = "input_test" type = "text" name = "first name">

                    <lable class = "emailtest">Email*</lable>
                    <input class = "input_test" type = "email" name = "email">

                </form>  

                

                <form method = "POST" class = "section_two" action = "default.php">
                    <lable class = "top" >Last Name</lable>
                    <input class = "input_test" type = "text" name = "Last Name">

                    <lable class = "top"> Date Of Birth*</lable>
                    <input class = "input_test" type = "date" name = "date">

                    <div class = "btc_holder">
                    <input class = "submit_button" type="submit" value="JOIN NOW">
                    </div>

                </form>


            </div>




        </div>
</div>

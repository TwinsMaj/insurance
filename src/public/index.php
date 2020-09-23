<?php 
   declare(strict_types=1);
   session_start();
   date_default_timezone_set('Europe/Tallinn');

   include_once '../autoload.php';

   use Lib\Utils;
   use Lib\Validator;
   use Lib\InsuranceReport;
   use Lib\CarInsuranceCalculator;
   
   if(array_key_exists('calculate', $_POST)) {

      if ($_SESSION['token'] != $_POST['token']) { die("INVALID TOKEN"); }
      if (time() >= $_SESSION['token-expire']) { echo '<p>Please reload page</p>'; }

      try {
         $validation_rules = [
            'estimate' => 'required|numeric|min:100|max:100000',
            'tax' => 'numeric|min:0|max:100',
            'instalments' => 'required|numeric|min:1|max:12'
         ];

         $validator = new Validator($validation_rules, $_POST);
         $validator->validate();

        if(!$validator->hasErrors()) {
            $calculator = new CarInsuranceCalculator((int) $_POST['tax'], (int)$_POST['instalments'], (float)$_POST['estimate']);
            $report = new InsuranceReport($calculator);

            $instalmentSchedule = $report->instalmentSchedule(); 
        }

      } catch (Exception $e) {
         echo $e->getMessage();
      }  
   }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Insurance Calculator</title>
        <link rel="stylesheet" type="text/css" href="./styles/styles.css" />
         <script src="./js/script.js"></script>
    </head>

    <body>
        <h1>Car Insurance Calculator</h1>
        <hr />

        <form name="calculatorForm" method="POST" action="" onsubmit="return validateForm()">
            <div class="handle">
                <label>Estimated Value</label><br />
                <?php
                  if(isset($validator) && $validator->has('estimate')) {
                     echo '<span class="err">' . $validator->getMessage('estimate') . '</span><br />';
                  }
                ?>
                <input type="text" name="estimate"/>
                <div class="err" id="estimate_err"></div>
            </div>

            <div class="handle">
                <label>Tax Percentage</label><br />
                <?php
                  if(isset($validator) && $validator->has('tax')) {
                     echo '<span class="err">' . $validator->getMessage('tax') . '</span><br />';
                  }
                ?>
                <input type="text" name="tax"/>
                <div class="err" id="tax_err"></div>
            </div class="handle">

            <div class="handle">
                <label>Number of Instalments</label><br />
                <?php
                  if(isset($validator) && $validator->has('instalments')) {
                     echo '<span class="err">' . $validator->getMessage('instalments') . '</span><br />';
                  }
                ?>
                <input type="text" name="instalments"/>
                <div class="err" id="instalments_err"></div>
            </div>

            <div class="handle"><input type="submit" name="calculate" value="Calculate"/></div>
            <div class="handle"><input type="hidden" name="token" value="<?php echo Utils::csrf(); ?>"/></div>
        </form>

        <?php
         if(isset($instalmentSchedule)) {
            echo $instalmentSchedule;
         }
        ?>
    </body>
</html>
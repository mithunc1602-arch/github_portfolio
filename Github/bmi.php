<?php include("header.php"); ?>

<div class="card">
<h2>BMI Calculator</h2>
<form method="post">
<label>Weight in KG</label>
<input type="number" step="0.1" min="1" name="weight" required>

<label>Height in CM</label>
<input type="number" step="0.1" min="1" name="height" required>

<button type="submit">Calculate BMI</button>
</form>

<?php
if(isset($_POST['weight'], $_POST['height'])){
    $weight=(float)$_POST['weight'];
    $height_cm=(float)$_POST['height'];

    if($weight > 0 && $height_cm > 0){
        $height=$height_cm/100;
        $bmi=$weight/($height*$height);

        echo "<h3>Your BMI: ".number_format($bmi,2)."</h3>";

        if($bmi < 18.5) echo "<p>Underweight</p>";
        elseif($bmi < 25) echo "<p>Normal Weight</p>";
        elseif($bmi < 30) echo "<p>Overweight</p>";
        else echo "<p>Obese</p>";
    }
}
?>
</div>

<?php include("footer.php"); ?>
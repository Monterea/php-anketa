<?php
require ('dbconfig.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h3>Seznam otázek:</h3>
    <table border="1">
        <tr>
            <th>ID otázky</th>
            <th>Název otázky</th>
            <th>Odpověď</th>
</tr>
<?php
//vložení otázky do databáze
$con1 = new mysqli($srvrname,$username,$pw,$db);
    if (!$con1) {
        die("Nelze se připojit k databázovému serveru!". $con1->error."</body></html>");
    }
    mysqli_query($con1, "SET NAMES 'utf8'");
    if (!mysqli_query(
        $con1,
        "INSERT INTO otazky(nazev) VALUES('" .
            addslashes($_POST["zprava"]) . "')"
    )) {
        echo "Vložení otázky se nezdařilo. " . mysqli_error($con1);
    }
    mysqli_close($con1);
?>


 <?php
 //výpis položených otázek
 $con = new mysqli($srvrname,$username,$pw,$db);
if (!$con) {
    die("Nelze se připojit k databázovému serveru!". $con->error."</body></html>");
}
mysqli_query($con,"SET NAMES 'utf8'");
if (!($vysledek = mysqli_query($con, "SELECT id_otazka, nazev FROM otazky")))
{
  die("Nelze provést dotaz.</body></html>");
}
?>
<?php
while ($radek = mysqli_fetch_array($vysledek))
{
?>
<tr>
<td><p><?php echo htmlspecialchars($radek["id_otazka"]);?> </p></td>    
<td><p><?php echo htmlspecialchars($radek["nazev"]);?></p></td>
<td>
<form method="POST" action="vkladOdpovedi.php">
	<input type="hidden" name="otazkaId" value="<?php echo htmlspecialchars($radek["id_otazka"]);?>">
	<input type="submit" value="ZDE">
</form>
</td>
</tr>
<?php   
}
mysqli_free_result($vysledek);
mysqli_close($con);
?>
</table>


<br/>
<form method="post" action="">
    <br/>
<table border="1">
<tr>
  <th colspan="2"> Napiš otázku:</th>
</tr>
  <td colspan="2">
  <textarea name="zprava" value="text">
</textarea>
</td>
</tr>
<tr>
  <th colspan="2"> 
<input type="submit" value="Odešli">
</th>
</tr>



</table>
</form>
</body>

</html>
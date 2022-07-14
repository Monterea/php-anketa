<?php
require ('dbconfig.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styl.css">
    <title>Document</title>
</head>
<body>
 <?php
  //vklad hlasu do databaze
  $od=$_POST["odpovedId"];
if(isset($_POST['hlasuji'])){
if(!($con1 = mysqli_connect($srvrname,$username,$pw,$db))){
    die("nelze se připojit k databázovému serveru!");
}
if(!(mysqli_query($con1," UPDATE odpovedi SET hlasy = hlasy + 1 WHERE id_odpoved ='$od'")))
{
    echo "nelze provést dotaz";
}
mysqli_close($con1);
}
?>

<h1>Anketa</h1>
<section class="sloupce">
  <div class="sloupec">
 <h2>Seznam všech odpovědí a otázek:</h2>
<table>
<tr><th colspan="2">
  Otázka
</th></tr> 
<tr>
  <td>Odpovědi</td>
  <td class="cislo">Počet hlasů</td>
</tr>
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
else {
?>
<?php
while ($radek = mysqli_fetch_array($vysledek))
{
?>
<tr><th colspan="2">
  <?php echo htmlspecialchars($radek["nazev"]);?>
</th></tr>
<input type="hidden" name="id" value="<?php echo htmlspecialchars($radek["id_otazka"]);?>"/>

<?php
 //výpis odpovědí
 $id=$radek["id_otazka"];
 $con2 = new mysqli($srvrname,$username,$pw,$db);
if (!$con2) {
    die("Nelze se připojit k databázovému serveru!". $con2->error."</body></html>");
}
mysqli_query($con2,"SET NAMES 'utf8'");
if (!($vysledek2 = mysqli_query($con2, 
"SELECT id_odpoved, id_otazka, popis, hlasy FROM odpovedi WHERE id_otazka='$id'")))
//"SELECT p.id_produkt, nazev, popis, cena, COUNT(id_objednavka) AS pocet " .
//"FROM produkt AS p LEFT JOIN objednavka AS o ON o.id_produkt = p.id_produkt " . 
//"GROUP BY p.id_produkt, nazev, popis, cena"
{
  die("Nelze provést dotaz.</body></html>");
} 
    ?>
<?php
while ($radek2 = mysqli_fetch_array($vysledek2))
{
?>
<tr>
  <td><?php echo htmlspecialchars($radek2["popis"]);?></td> 
<td><?php echo htmlspecialchars($radek2["hlasy"]);?></td> 
</tr>  
<?php
  }
?>

<?php  
}

}
?>

</table>

<?php
mysqli_free_result($vysledek2);
mysqli_close($con2);
?>
<?php  
mysqli_free_result($vysledek);
mysqli_close($con);
?>



<br/>
<br/>
<a href="hlavni.php">zpět</a>

</div>
</section>

</body>
</html>
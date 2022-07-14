<?php
require ('dbconfig.php');
?>
<?php
session_start();
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

<h1>Anketa</h1>
<section class="sloupce">
  


<div class="sloupec">
<table>
<tr>
  <th colspan="2"> Odpověz na otázku:</th>
</tr>
<tr>

  <th colspan="2">
 <?php
 //výpis názvu otázky
 $con = new mysqli($srvrname,$username,$pw,$db);
if (!$con) {
    die("Nelze se připojit k databázovému serveru!". $con->error."</body></html>");
}
mysqli_query($con,"SET NAMES 'utf8'");
$id = addslashes($_GET["otazkaId"]);
if ($vysledek = mysqli_query($con, "SELECT id_otazka, nazev FROM otazky WHERE id_otazka='$id'"))
{
    if ($radek = mysqli_fetch_array($vysledek)){
        echo ("<p>" . htmlspecialchars($radek["nazev"]) . "   (Id:" . $id . " )</p>");
        
}
}
mysqli_free_result($vysledek);
?>  

</th>
</tr>

 
  <td colspan="2">
  <form method="POST" action=" ">       
  <textarea name="odpoved">
</textarea>
</td>
</tr>
<tr>
  <td colspan="2"> 
<input type="submit" value="Odešli" name="odpovidam" />
<input type="hidden" name="cisloOtazky" value="<?php echo ($_GET["otazkaId"]);  ?> " />
</td>
</tr>
</form>
</table>
<?php
  //vklad odpovedi do databaze
  if((isset($_POST["odpovidam"]))&&(isset($_POST["odpoved"]))){          
      if($con = mysqli_connect($srvrname,$username,$pw,$db)){  
        if(!(mysqli_query($con,"INSERT INTO odpovedi(popis, id_otazka) VALUES
('" 
. addslashes($_POST["odpoved"]).
 "','"
 . addslashes($_POST["cisloOtazky"]).
 "')")))
{
    echo "nelze provést";
}
      }
    }
?> 


<br/>
<br/>
<a href="hlavni.php">zpět</a>

</div>
<?php
 //výpis odpovědí
if (!$con) {
    die("Nelze se připojit k databázovému serveru!". $con2->error."</body></html>");
}
mysqli_query($con,"SET NAMES 'utf8'");
if (!($vysledek2 = mysqli_query($con, 
"SELECT id_odpoved, popis, hlasy FROM odpovedi WHERE id_otazka='$id'")))
//"SELECT p.id_produkt, nazev, popis, cena, COUNT(id_objednavka) AS pocet " .
//"FROM produkt AS p LEFT JOIN objednavka AS o ON o.id_produkt = p.id_produkt " . 
//"GROUP BY p.id_produkt, nazev, popis, cena"
{
  die("Nelze provést dotaz.</body></html>");
} else {
?>
  <div class="sloupec">
 <h3>Seznam odpovědí:</h3>
    <table>
        <tr>
            <th class="cislo"><h4>ID odpovědi</h4></th>
            <th><h4>Odpověď</h4></th>
            <th class="cislo"><h4>Počet hlasů</h4></th>
            <th><h4>Hlasuj</h4></th>
</tr>

<?php
while ($radek2 = mysqli_fetch_array($vysledek2))
{
?>
<tr>
<td class="cislo"><p><?php echo htmlspecialchars($radek2["id_odpoved"]);?> </p></td>    
<td><p><?php echo htmlspecialchars($radek2["popis"]);?></p></td>
<td><p><?php echo htmlspecialchars($radek2["hlasy"]);?></p></td>
<td>
  <form method="POST" action="vkladHlasu.php">          
  <input type="hidden" name="odpovedId" value="<?php  echo htmlspecialchars($radek2["id_odpoved"]);  ?>"/>
<input type="submit" value="Hlasuji" name="hlasuji"/>
</td>

</tr>
<?php   
}
}
mysqli_free_result($vysledek2);
mysqli_close($con);
?>
</table>
</div>



</section>
</body>
</html>
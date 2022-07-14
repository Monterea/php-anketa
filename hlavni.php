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
    <h1>Anketa</h1>
    <section class="sloupce">

<div class="sloupec">
<form method="post" action="hlavni.php">  
<table>
<tr>
  <th colspan="2"> Napiš otázku:</th>
</tr>
<tr>
  <td colspan="2">
  <textarea name="otazka">
</textarea>
</td>
</tr>
<tr>
  <td colspan="2"> 
  
<input type="submit" name="dotaz" value="Odešli"/>
</td>
</tr>

</table>
</form>
<?php
//vložení otázky do databáze
if((isset($_POST['otazka'])) && (isset($_POST['dotaz']))){
$con1 = new mysqli($srvrname,$username,$pw,$db);
    if (!$con1) {
        die("Nelze se připojit k databázovému serveru!". $con1->error."</body></html>");
    }
    mysqli_query($con1, "SET NAMES 'utf8'");
    
    if (!(mysqli_query(
        $con1,
        "INSERT INTO otazky(nazev) VALUES('" .
            addslashes($_POST["otazka"]) . "')"
    )) ){
        echo "Vložení anketní otázky se nezdařilo. " . mysqli_error($con1);
    }
    mysqli_close($con1);
    }

?>


<br/>
<br/>
<a href="../projects.html">zpět na stránku s projekty</a>
</div>

        <div class="sloupec">      
    <h3>Seznam předešlých anketních otázek:</h3>
    <table>
        <tr>
            <th class="cislo">ID otázky</th>
            <th>Název otázky</th>
            <th>Odpověď</th>
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
?>
<?php
while ($radek = mysqli_fetch_array($vysledek))
{
?>
<tr>
<td class="cislo"><p><?php echo htmlspecialchars($radek["id_otazka"]);?> </p></td>    
<td><p><?php echo htmlspecialchars($radek["nazev"]);?></p></td>
<td>
<form method="GET" action="vkladOdpovedi.php">
	<input type="hidden" name="otazkaId" value="<?php echo htmlspecialchars($radek["id_otazka"]);?>" />
	<input type="submit" name="dotaz" value="CHCI ODPOVĚDĚT" />
</form>
</td>
</tr>
<?php   
}
mysqli_free_result($vysledek);
mysqli_close($con);
?>
</table>
</div>



    </section>
</body>

</html>
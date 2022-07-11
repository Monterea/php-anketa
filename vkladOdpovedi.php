<?php
require ('dbconfig.php');
$id= addslashes($_POST["otazkaId"]);
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
 <?php
  //vklad do databaze
if(isset($_POST['submit'])){

if(!($con1 = mysqli_connect($srvrname,$username,$pw,$db))){
    die("nelze se připojit k databázovému serveru!");
}
if(mysqli_query($con1,"INSERT INTO odpovedi(popis, id_otazka) VALUES
('" 
. addslashes($_POST["odpoved"]).
 "','"
 . addslashes($_POST["otazkaId"]).
 "')"))
{
    echo "uspesne vlozeni.";
}
else{
    echo "nelze provést dotaz";
}
mysqli_close($con1);
}
?>

<?php
 //výpis odpovědí
 $con2 = new mysqli($srvrname,$username,$pw,$db);
if (!$con2) {
    die("Nelze se připojit k databázovému serveru!". $con2->error."</body></html>");
}
mysqli_query($con2,"SET NAMES 'utf8'");
$id= addslashes($_POST["otazkaId"]);
if (!($vysledek2 = mysqli_query($con2, "SELECT id_odpoved, popis FROM odpovedi WHERE id_otazka='$id'")))
{
  die("Nelze provést dotaz.</body></html>");
} else {
?>

 <h3>Seznam Odpovědí:</h3>
    <table border="1">
        <tr>
            <th>ID odpovědi</th>
            <th>Odpověď</th>
</tr>

<?php
while ($radek2 = mysqli_fetch_array($vysledek2))
{
?>
<tr>
<td><p><?php echo htmlspecialchars($radek2["id_odpoved"]);?> </p></td>    
<td><p><?php echo htmlspecialchars($radek2["popis"]);?></p></td>
</tr>
<?php   
}
}
mysqli_free_result($vysledek2);
mysqli_close($con2);
?>
</table>


<br/>
<br/>
<table border="1">
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
$id= $_POST["otazkaId"];
if ($vysledek = mysqli_query($con, "SELECT id_otazka, nazev FROM otazky WHERE id_otazka='$id'"))
{
    if ($radek = mysqli_fetch_array($vysledek)){
        echo ("<p>" . htmlspecialchars($radek["nazev"]) . "   (Id:" . $id . " )</p>");
}
}
mysqli_free_result($vysledek);
mysqli_close($con);
?>     
</th>
</tr>
  <td colspan="2">
  <form method="POST" action="vkladOdpovedi.php">       
  <textarea name="odpoved">
</textarea>
</td>
</tr>
<tr>
  <th colspan="2"> 
   
  <input type="hidden" name="otazkaId" value="<?php  echo htmlspecialchars($_POST["otazkaId"]);  ?>">
<input type="submit" value="Odešli" name="submit">
</th>
</tr>
</table>
</form>

  





</body>
</html>
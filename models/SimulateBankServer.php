<?php
//Questo lo uso per simulare quello che farebbe un server paypal...che deve prendere i tuoi dati, nome e pass, e dopo togliere i soldi dal tuo conto,,,e poi ritornarti una scritta che ti dice che e andato tutto bene
echo ("pagamento effettuato dal conto in banca  di  :" . $_POST["nome"]." ". $_POST["cognome"] . " /n denaro trasferito =  ".$_POST["denarotrasferito"]  . " grazie e ciao");
?>
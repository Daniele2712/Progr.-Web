
  /*
  $( "#but3" ).click(function() {
  $( "#loginbox" ).toggle("slow");
});
 */

 $("#loginbutton").click(function(){
        $('#loginbox').slideToggle('slow');
        if($('#registerbox').css('display') === 'block') {$('#registerbox').slideToggle('slow');}
    });
    
$("#registerbutton").click(function(){
    $('#registerbox').slideToggle('slow');
    if($('#loginbox').css('display') === 'block') {$('#loginbox').slideToggle('slow');}
});


function showInfo(){
  
    /* FAI LA CHIAMATA AJAX CHE TI DICE LE INFOO PRESE DAL DATABASE*/
    
};


// nelle prossime 2 funzioni, prev prende il fratello che sta prima, next quello che sta dopo
function subtractOne(that){
    if(parseInt($(that).next().val())>1)
    $(that).next().val(parseInt($(that).next().val())-1);   
    else $(that).next().val(0);
};

function addOne(that){
   if($(that).prev().val()=="")   $(that).prev().val(1);
   else $(that).prev().val(parseInt($(that).prev().val())+1);
    
};

function addToCart(that){
  
    //CODICE CHE LO AGGIUNGE AL CARELLO
    
  $(that).prev().prev().val("");
};








/*
array(18) {
  [0]=>
  array(14) {
    ["id"]=>
    string(1) "1"
    [0]=>
    string(1) "1"
    ["nome"]=>
    string(15) "latte granarolo"
    [1]=>
    string(15) "latte granarolo"
    ["info"]=>
    string(67) "Granarolo Latte Parzialmente Scremato a Lunga Conservazione 1 Litro"
    [2]=>
    string(67) "Granarolo Latte Parzialmente Scremato a Lunga Conservazione 1 Litro"
    ["descrizione"]=>
    string(176) "energia: 199 kJ, 47 kcal 
grassi: 1,6 g 
di cui acidi grassi saturi: 1,1 g 
carboidrati: 5,0 g 
di cui zuccheri: 5,0 g 
proteine: 3,2 g 
sale: 0,10 g 
calcio:120 mg, 15%"
    [3]=>
    string(176) "energia: 199 kJ, 47 kcal 
grassi: 1,6 g 
di cui acidi grassi saturi: 1,1 g 
carboidrati: 5,0 g 
di cui zuccheri: 5,0 g 
proteine: 3,2 g 
sale: 0,10 g 
calcio:120 mg, 15%"
    ["id_categoria"]=>
    string(1) "3"
    [4]=>
    string(1) "3"
    ["prezzo"]=>
    string(4) "1.29"
    [5]=>
    string(4) "1.29"
    ["valuta"]=>
    string(3) "EUR"
    [6]=>
    string(3) "EUR"
  }
  [1]=>
  array(14) {
    ["id"]=>
    string(1) "4"
    [0]=>
    string(1) "4"
    ["nome"]=>
    string(10) "Sedia Ikea"
    [1]=>
    string(10) "Sedia Ikea"
    ["info"]=>
    string(14) "ottima qualita"
    [2]=>
    string(14) "ottima qualita"
    ["descrizione"]=>
    string(21) "100 milla kilocalorie"
    [3]=>
    string(21) "100 milla kilocalorie"
    ["id_categoria"]=>
    string(1) "2"
    [4]=>
    string(1) "2"
    ["prezzo"]=>
    string(4) "12.5"
    [5]=>
    string(4) "12.5"
    ["valuta"]=>
    string(3) "EUR"
    [6]=>
    string(3) "EUR"
  }
  [2]=>
  array(14) {
    ["id"]=>
    string(1) "5"
    [0]=>
    string(1) "5"
    ["nome"]=>
    string(6) "Tavolo"
    [1]=>
    string(6) "Tavolo"
    ["info"]=>
    string(14) "ottima qualita"
    [2]=>
    string(14) "ottima qualita"
    ["descrizione"]=>
    string(21) "100 milla kilocalorie"
    [3]=>
    string(21) "100 milla kilocalorie"
    ["id_categoria"]=>
    string(1) "2"
    [4]=>
    string(1) "2"
    ["prezzo"]=>
    string(2) "33"
    [5]=>
    string(2) "33"
    ["valuta"]=>
    string(3) "EUR"
    [6]=>
    string(3) "EUR"
  }
  [3]=>
  array(14) {
    ["id"]=>
    string(1) "6"
    [0]=>
    string(1) "6"
    ["nome"]=>
    string(17) "Spagnetti Balilla"
    [1]=>
    string(17) "Spagnetti Balilla"
    ["info"]=>
    string(14) "ottima qualita"
    [2]=>
    string(14) "ottima qualita"
    ["descrizione"]=>
    string(21) "portatore di celulite"
    [3]=>
    string(21) "portatore di celulite"
    ["id_categoria"]=>
    string(1) "4"
    [4]=>
    string(1) "4"
    ["prezzo"]=>
    string(3) "2.5"
    [5]=>
    string(3) "2.5"
    ["valuta"]=>
    string(3) "EUR"
    [6]=>
    string(3) "EUR"
  }
  [4]=>
  array(14) {
    ["id"]=>
    string(1) "7"
    [0]=>
    string(1) "7"
    ["nome"]=>
    string(14) "televisore LCD"
    [1]=>
    string(14) "televisore LCD"
    ["info"]=>
    string(14) "ottima qualita"
    [2]=>
    string(14) "ottima qualita"
    ["descrizione"]=>
    string(27) "per chi ha tempo da perdere"
    [3]=>
    string(27) "per chi ha tempo da perdere"
    ["id_categoria"]=>
    string(1) "2"
    [4]=>
    string(1) "2"
    ["prezzo"]=>
    string(4) "2250"
    [5]=>
    string(4) "2250"
    ["valuta"]=>
    string(3) "EUR"
    [6]=>
    string(3) "EUR"
  }
  [5]=>
  array(14) {
    ["id"]=>
    string(1) "8"
    [0]=>
    string(1) "8"
    ["nome"]=>
    string(10) "Tortellini"
    [1]=>
    string(10) "Tortellini"
    ["info"]=>
    string(15) "pessima qualita"
    [2]=>
    string(15) "pessima qualita"
    ["descrizione"]=>
    string(21) "100 milla kilocalorie"
    [3]=>
    string(21) "100 milla kilocalorie"
    ["id_categoria"]=>
    string(1) "1"
    [4]=>
    string(1) "1"
    ["prezzo"]=>
    string(1) "4"
    [5]=>
    string(1) "4"
    ["valuta"]=>
    string(3) "EUR"
    [6]=>
    string(3) "EUR"
  }
  [6]=>
  array(14) {
    ["id"]=>
    string(1) "9"
    [0]=>
    string(1) "9"
    ["nome"]=>
    string(6) "Tavolo"
    [1]=>
    string(6) "Tavolo"
    ["info"]=>
    string(14) "ottima qualita"
    [2]=>
    string(14) "ottima qualita"
    ["descrizione"]=>
    string(21) "100 milla kilocalorie"
    [3]=>
    string(21) "100 milla kilocalorie"
    ["id_categoria"]=>
    string(1) "2"
    [4]=>
    string(1) "2"
    ["prezzo"]=>
    string(2) "33"
    [5]=>
    string(2) "33"
    ["valuta"]=>
    string(3) "EUR"
    [6]=>
    string(3) "EUR"
  }
  [7]=>
  array(14) {
    ["id"]=>
    string(2) "10"
    [0]=>
    string(2) "10"
    ["nome"]=>
    string(17) "Spagnetti Balilla"
    [1]=>
    string(17) "Spagnetti Balilla"
    ["info"]=>
    string(14) "ottima qualita"
    [2]=>
    string(14) "ottima qualita"
    ["descrizione"]=>
    string(21) "portatore di celulite"
    [3]=>
    string(21) "portatore di celulite"
    ["id_categoria"]=>
    string(1) "4"
    [4]=>
    string(1) "4"
    ["prezzo"]=>
    string(3) "2.5"
    [5]=>
    string(3) "2.5"
    ["valuta"]=>
    string(3) "EUR"
    [6]=>
    string(3) "EUR"
  }
  [8]=>
  array(14) {
    ["id"]=>
    string(2) "11"
    [0]=>
    string(2) "11"
    ["nome"]=>
    string(14) "televisore LCD"
    [1]=>
    string(14) "televisore LCD"
    ["info"]=>
    string(14) "ottima qualita"
    [2]=>
    string(14) "ottima qualita"
    ["descrizione"]=>
    string(27) "per chi ha tempo da perdere"
    [3]=>
    string(27) "per chi ha tempo da perdere"
    ["id_categoria"]=>
    string(1) "2"
    [4]=>
    string(1) "2"
    ["prezzo"]=>
    string(4) "2250"
    [5]=>
    string(4) "2250"
    ["valuta"]=>
    string(3) "EUR"
    [6]=>
    string(3) "EUR"
  }
  [9]=>
  array(14) {
    ["id"]=>
    string(2) "12"
    [0]=>
    string(2) "12"
    ["nome"]=>
    string(10) "Tortellini"
    [1]=>
    string(10) "Tortellini"
    ["info"]=>
    string(15) "pessima qualita"
    [2]=>
    string(15) "pessima qualita"
    ["descrizione"]=>
    string(21) "100 milla kilocalorie"
    [3]=>
    string(21) "100 milla kilocalorie"
    ["id_categoria"]=>
    string(1) "1"
    [4]=>
    string(1) "1"
    ["prezzo"]=>
    string(1) "4"
    [5]=>
    string(1) "4"
    ["valuta"]=>
    string(3) "EUR"
    [6]=>
    string(3) "EUR"
  }
  [10]=>
  array(14) {
    ["id"]=>
    string(2) "13"
    [0]=>
    string(2) "13"
    ["nome"]=>
    string(6) "Tavolo"
    [1]=>
    string(6) "Tavolo"
    ["info"]=>
    string(14) "ottima qualita"
    [2]=>
    string(14) "ottima qualita"
    ["descrizione"]=>
    string(21) "100 milla kilocalorie"
    [3]=>
    string(21) "100 milla kilocalorie"
    ["id_categoria"]=>
    string(1) "2"
    [4]=>
    string(1) "2"
    ["prezzo"]=>
    string(2) "33"
    [5]=>
    string(2) "33"
    ["valuta"]=>
    string(3) "EUR"
    [6]=>
    string(3) "EUR"
  }
  [11]=>
  array(14) {
    ["id"]=>
    string(2) "14"
    [0]=>
    string(2) "14"
    ["nome"]=>
    string(17) "Spagnetti Balilla"
    [1]=>
    string(17) "Spagnetti Balilla"
    ["info"]=>
    string(14) "ottima qualita"
    [2]=>
    string(14) "ottima qualita"
    ["descrizione"]=>
    string(21) "portatore di celulite"
    [3]=>
    string(21) "portatore di celulite"
    ["id_categoria"]=>
    string(1) "4"
    [4]=>
    string(1) "4"
    ["prezzo"]=>
    string(3) "2.5"
    [5]=>
    string(3) "2.5"
    ["valuta"]=>
    string(3) "EUR"
    [6]=>
    string(3) "EUR"
  }
  [12]=>
  array(14) {
    ["id"]=>
    string(2) "15"
    [0]=>
    string(2) "15"
    ["nome"]=>
    string(14) "televisore LCD"
    [1]=>
    string(14) "televisore LCD"
    ["info"]=>
    string(14) "ottima qualita"
    [2]=>
    string(14) "ottima qualita"
    ["descrizione"]=>
    string(27) "per chi ha tempo da perdere"
    [3]=>
    string(27) "per chi ha tempo da perdere"
    ["id_categoria"]=>
    string(1) "2"
    [4]=>
    string(1) "2"
    ["prezzo"]=>
    string(4) "2250"
    [5]=>
    string(4) "2250"
    ["valuta"]=>
    string(3) "EUR"
    [6]=>
    string(3) "EUR"
  }
  [13]=>
  array(14) {
    ["id"]=>
    string(2) "16"
    [0]=>
    string(2) "16"
    ["nome"]=>
    string(10) "Tortellini"
    [1]=>
    string(10) "Tortellini"
    ["info"]=>
    string(15) "pessima qualita"
    [2]=>
    string(15) "pessima qualita"
    ["descrizione"]=>
    string(21) "100 milla kilocalorie"
    [3]=>
    string(21) "100 milla kilocalorie"
    ["id_categoria"]=>
    string(1) "1"
    [4]=>
    string(1) "1"
    ["prezzo"]=>
    string(1) "4"
    [5]=>
    string(1) "4"
    ["valuta"]=>
    string(3) "EUR"
    [6]=>
    string(3) "EUR"
  }
  [14]=>
  array(14) {
    ["id"]=>
    string(2) "17"
    [0]=>
    string(2) "17"
    ["nome"]=>
    string(6) "Tavolo"
    [1]=>
    string(6) "Tavolo"
    ["info"]=>
    string(14) "ottima qualita"
    [2]=>
    string(14) "ottima qualita"
    ["descrizione"]=>
    string(21) "100 milla kilocalorie"
    [3]=>
    string(21) "100 milla kilocalorie"
    ["id_categoria"]=>
    string(1) "2"
    [4]=>
    string(1) "2"
    ["prezzo"]=>
    string(2) "33"
    [5]=>
    string(2) "33"
    ["valuta"]=>
    string(3) "EUR"
    [6]=>
    string(3) "EUR"
  }
  [15]=>
  array(14) {
    ["id"]=>
    string(2) "18"
    [0]=>
    string(2) "18"
    ["nome"]=>
    string(17) "Spagnetti Balilla"
    [1]=>
    string(17) "Spagnetti Balilla"
    ["info"]=>
    string(14) "ottima qualita"
    [2]=>
    string(14) "ottima qualita"
    ["descrizione"]=>
    string(21) "portatore di celulite"
    [3]=>
    string(21) "portatore di celulite"
    ["id_categoria"]=>
    string(1) "4"
    [4]=>
    string(1) "4"
    ["prezzo"]=>
    string(3) "2.5"
    [5]=>
    string(3) "2.5"
    ["valuta"]=>
    string(3) "EUR"
    [6]=>
    string(3) "EUR"
  }
  [16]=>
  array(14) {
    ["id"]=>
    string(2) "19"
    [0]=>
    string(2) "19"
    ["nome"]=>
    string(14) "televisore LCD"
    [1]=>
    string(14) "televisore LCD"
    ["info"]=>
    string(14) "ottima qualita"
    [2]=>
    string(14) "ottima qualita"
    ["descrizione"]=>
    string(27) "per chi ha tempo da perdere"
    [3]=>
    string(27) "per chi ha tempo da perdere"
    ["id_categoria"]=>
    string(1) "2"
    [4]=>
    string(1) "2"
    ["prezzo"]=>
    string(4) "2250"
    [5]=>
    string(4) "2250"
    ["valuta"]=>
    string(3) "EUR"
    [6]=>
    string(3) "EUR"
  }
  [17]=>
  array(14) {
    ["id"]=>
    string(2) "20"
    [0]=>
    string(2) "20"
    ["nome"]=>
    string(10) "Tortellini"
    [1]=>
    string(10) "Tortellini"
    ["info"]=>
    string(15) "pessima qualita"
    [2]=>
    string(15) "pessima qualita"
    ["descrizione"]=>
    string(21) "100 milla kilocalorie"
    [3]=>
    string(21) "100 milla kilocalorie"
    ["id_categoria"]=>
    string(1) "1"
    [4]=>
    string(1) "1"
    ["prezzo"]=>
    string(1) "4"
    [5]=>
    string(1) "4"
    ["valuta"]=>
    string(3) "EUR"
    [6]=>
    string(3) "EUR"
  }
}
*/
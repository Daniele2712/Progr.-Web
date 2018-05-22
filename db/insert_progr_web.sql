//categorie
INSERT INTO `categorie` (`id`, `nome`, `padre`) VALUES (NULL, 'alimentari', NULL);
INSERT INTO `categorie` (`id`, `nome`, `padre`) VALUES (NULL, 'elettrodomestici', '1');
INSERT INTO `categorie` (`id`, `nome`, `padre`) VALUES (NULL, 'latticini', '1');
//prodotti
INSERT INTO `prodotti` (`id`, `nome`, `info`, `descrizione`, `id_categoria`, `prezzo`, `valuta`) VALUES (NULL, 'latte granarolo', 'Granarolo Latte Parzialmente Scremato a Lunga Conservazione 1 Litro', 'energia: 199 kJ, 47 kcal \r\ngrassi: 1,6 g \r\ndi cui acidi grassi saturi: 1,1 g \r\ncarboidrati: 5,0 g \r\ndi cui zuccheri: 5,0 g \r\nproteine: 3,2 g \r\nsale: 0,10 g \r\ncalcio:120 mg, 15%', '3', '1.29', 'EUR');
//carrelli
INSERT INTO `carrelli` (`id`, `totale`, `valuta`) VALUES (NULL, '0', 'EUR');
//item
INSERT INTO `items` (`id`, `locazione`, `id_prodotto`, `totale`, `valuta`, `quantita`) VALUES ('1', 'C', '1', '3.87', 'EUR', '3');

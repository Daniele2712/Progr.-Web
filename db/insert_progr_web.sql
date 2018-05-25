//categorie
INSERT INTO `categorie` (`id`, `nome`, `padre`) VALUES (NULL, 'alimentari', NULL);
INSERT INTO `categorie` (`id`, `nome`, `padre`) VALUES (NULL, 'elettrodomestici', '1');
INSERT INTO `categorie` (`id`, `nome`, `padre`) VALUES (NULL, 'latticini', '1');
INSERT INTO `categorie` (`id`, `nome`, `padre`) VALUES (NULL, 'televisori', '2');
//prodotti
INSERT INTO `prodotti` (`id`, `nome`, `info`, `descrizione`, `id_categoria`, `prezzo`, `valuta`) VALUES (NULL, 'latte granarolo', 'Granarolo Latte Parzialmente Scremato a Lunga Conservazione 1 Litro', 'energia: 199 kJ, 47 kcal \r\ngrassi: 1,6 g \r\ndi cui acidi grassi saturi: 1,1 g \r\ncarboidrati: 5,0 g \r\ndi cui zuccheri: 5,0 g \r\nproteine: 3,2 g \r\nsale: 0,10 g \r\ncalcio:120 mg, 15%', '3', '1.29', 'EUR');
//carrelli
INSERT INTO `carrelli` (`id`, `totale`, `valuta`) VALUES (NULL, '0', 'EUR');
//items
INSERT INTO `items_carrello` (`id`, `id_carrello`, `id_prodotto`, `totale`, `valuta`, `quantita`) VALUES (NULL, '1', '1', '3.87', 'EUR', '3');
//comuni
INSERT INTO `comuni` (`id`, `CAP`, `nome`, `provincia`) VALUES (NULL, '67100', 'l\'aquila', 'AQ');
//indirizzi
INSERT INTO `indirizzi` (`id`, `id_comune`, `via`, `civico`, `note`) VALUES (NULL, '1', 'viale croce rossa', '2', '')
INSERT INTO `indirizzi` (`id`, `id_comune`, `via`, `civico`, `note`) VALUES (NULL, '1', 'viale aldo moro', '4', '')
//metodi pagamento
INSERT INTO `carte` (`id`, `numero`, `cvv`, `nome`, `cognome`, `data_scadenza`) VALUES (NULL, '0000000000000001', '000', 'mario', 'rossi', '1970-01-01');
//dati anagrafici
INSERT INTO `dati_anagrafici` (`id`, `nome`, `cognome`, `telefono`, `datanascita`) VALUES (NULL, 'mario', 'rossi', '33312345678', '1970-01-01');
INSERT INTO `dati_anagrafici` (`id`, `nome`, `cognome`, `telefono`, `datanascita`) VALUES (NULL, 'luigi', 'verdi', '33387654321', '1980-02-02');
//filtri
INSERT INTO `filtri` (`id`, `nome`, `filtrabile`, `id_categoria`) VALUES (NULL, 'display', '1', '4');
//gestori
INSERT INTO `gestori` (`id`, `id_datianagrafici`, `email`, `password`) VALUES (NULL, '2', 'luigiverdi@gmail.com', 'abc');
//magazzini
INSERT INTO `magazzini` (`id`, `id_gestore`, `id_indirizzo`) VALUES (NULL, '1', '1');
//utenti registrati
INSERT INTO `utenti_registrati` (`id`, `id_datianagrafici`, `email`, `password`) VALUES (NULL, '1', 'mariorossi@gmail.com', 'xyz');
//indirizzi preferiti
INSERT INTO `indirizzi_preferiti` (`id`, `id_utente_r`, `id_indirizzo`) VALUES (NULL, '1', '2');
//metodi pagamento preferiti
INSERT INTO `pagamenti_preferiti` (`id`, `id_utente_r`, `tipo`, `id_m_pagamento`) VALUES (NULL, '1', 'Carta', '1');
//opzioni (filtro)
INSERT INTO `opzioni` (`id`, `valore`, `id_filtro`) VALUES (NULL, '23\"', '1');
INSERT INTO `opzioni` (`id`, `valore`, `id_filtro`) VALUES (NULL, '40\"', '1');
//

-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Creato il: Mag 26, 2018 alle 21:25
-- Versione del server: 5.7.22-0ubuntu0.16.04.1
-- Versione PHP: 7.0.30-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `progr_web`
--
CREATE DATABASE IF NOT EXISTS `progr_web` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `progr_web`;

-- --------------------------------------------------------

--
-- Struttura della tabella `carrelli`
--

CREATE TABLE `carrelli` (
  `id` int(11) NOT NULL,
  `totale` float NOT NULL,
  `valuta` enum('EUR','USD','GBP','BTC','JPY') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `carrelli`
--

INSERT INTO `carrelli` (`id`, `totale`, `valuta`) VALUES
(1, 0, 'EUR');

-- --------------------------------------------------------

--
-- Struttura della tabella `carte`
--

CREATE TABLE `carte` (
  `id` int(11) NOT NULL,
  `numero` int(20) NOT NULL,
  `cvv` int(5) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cognome` varchar(100) NOT NULL,
  `data_scadenza` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `carte`
--

INSERT INTO `carte` (`id`, `numero`, `cvv`, `nome`, `cognome`, `data_scadenza`) VALUES
(1, 1, 0, 'mario', 'rossi', '1970-01-01');

-- --------------------------------------------------------

--
-- Struttura della tabella `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `padre` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `categorie`
--

INSERT INTO `categorie` (`id`, `nome`, `padre`) VALUES
(1, 'alimentari', NULL),
(2, 'elettrodomestici', NULL),
(3, 'latticini', 1),
(4, 'televisori', 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `comuni`
--

CREATE TABLE `comuni` (
  `id` int(11) NOT NULL,
  `CAP` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `provincia` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `comuni`
--

INSERT INTO `comuni` (`id`, `CAP`, `nome`, `provincia`) VALUES
(1, 67100, 'l\'aquila', 'AQ');

-- --------------------------------------------------------

--
-- Struttura della tabella `dati_anagrafici`
--

CREATE TABLE `dati_anagrafici` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cognome` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `data_nascita` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `dati_anagrafici`
--

INSERT INTO `dati_anagrafici` (`id`, `nome`, `cognome`, `telefono`, `data_nascita`) VALUES
(1, 'mario', 'rossi', '33312345678', '1970-01-01'),
(2, 'luigi', 'verdi', '33387654321', '1980-02-02');

-- --------------------------------------------------------

--
-- Struttura della tabella `filtri`
--

CREATE TABLE `filtri` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `filtrabile` tinyint(1) NOT NULL,
  `id_categoria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `filtri`
--

INSERT INTO `filtri` (`id`, `nome`, `filtrabile`, `id_categoria`) VALUES
(1, 'display', 1, 4);

-- --------------------------------------------------------

--
-- Struttura della tabella `gestori`
--

CREATE TABLE `gestori` (
  `id` int(11) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `indirizzi`
--

CREATE TABLE `indirizzi` (
  `id` int(11) NOT NULL,
  `id_comune` int(11) NOT NULL,
  `via` varchar(200) NOT NULL,
  `civico` int(11) NOT NULL,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `indirizzi`
--

INSERT INTO `indirizzi` (`id`, `id_comune`, `via`, `civico`, `note`) VALUES
(1, 1, 'viale croce rossa', 2, ''),
(2, 1, 'viale aldo moro', 4, '');

-- --------------------------------------------------------

--
-- Struttura della tabella `indirizzi_preferiti`
--

CREATE TABLE `indirizzi_preferiti` (
  `id` int(11) NOT NULL,
  `id_utente_r` int(11) NOT NULL,
  `id_indirizzo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `indirizzi_preferiti`
--

INSERT INTO `indirizzi_preferiti` (`id`, `id_utente_r`, `id_indirizzo`) VALUES
(1, 1, 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `items_carrello`
--

CREATE TABLE `items_carrello` (
  `id` int(11) NOT NULL,
  `id_carrello` int(11) NOT NULL,
  `id_prodotto` int(11) NOT NULL,
  `totale` float NOT NULL,
  `valuta` enum('EUR','USD','GBP','BTC','JPY') NOT NULL,
  `quantita` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `items_carrello`
--

INSERT INTO `items_carrello` (`id`, `id_carrello`, `id_prodotto`, `totale`, `valuta`, `quantita`) VALUES
(1, 1, 1, 3.87, 'EUR', 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `items_magazzino`
--

CREATE TABLE `items_magazzino` (
  `id` int(11) NOT NULL,
  `id_magazzino` int(11) NOT NULL,
  `id_prodotto` int(11) NOT NULL,
  `quantita` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `items_ordine`
--

CREATE TABLE `items_ordine` (
  `id` int(11) NOT NULL,
  `id_ordine` int(11) NOT NULL,
  `id_prodotto` int(11) NOT NULL,
  `prezzo` float NOT NULL,
  `valuta` enum('EUR','USD','GBP','BTC','JPY') NOT NULL,
  `quantita` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `magazzini`
--

CREATE TABLE `magazzini` (
  `id` int(11) NOT NULL,
  `id_gestore` int(11) DEFAULT NULL,
  `id_indirizzo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `magazzini`
--

INSERT INTO `magazzini` (`id`, `id_gestore`, `id_indirizzo`) VALUES
(1, NULL, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `offerte`
--

CREATE TABLE `offerte` (
  `id` int(11) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `data_inizio` datetime NOT NULL,
  `data_fine` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `offerte`
--

INSERT INTO `offerte` (`id`, `id_tipo`, `data_inizio`, `data_fine`) VALUES
(1, 1, '2018-05-25 00:00:00', '2018-05-26 00:00:00');

-- --------------------------------------------------------

--
-- Struttura della tabella `offerte_mxn`
--

CREATE TABLE `offerte_mxn` (
  `id` int(11) NOT NULL,
  `id_offerta` int(11) NOT NULL,
  `id_prodotto` int(11) NOT NULL,
  `quantita_m` int(11) NOT NULL,
  `quantita_n` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `offerte_omaggi`
--

CREATE TABLE `offerte_omaggi` (
  `id` int(11) NOT NULL,
  `id_offerta` int(11) NOT NULL,
  `id_prodotto_omaggio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `offerte_omaggi_condizioni`
--

CREATE TABLE `offerte_omaggi_condizioni` (
  `id` int(11) NOT NULL,
  `id_offerta_omaggio` int(11) NOT NULL,
  `id_prodotto` int(11) NOT NULL,
  `quantita` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `offerte_sconti`
--

CREATE TABLE `offerte_sconti` (
  `id` int(11) NOT NULL,
  `id_offerta` int(11) NOT NULL,
  `id_prodotto` int(11) NOT NULL,
  `prezzo` float NOT NULL,
  `valuta` enum('EUR','USD','GBP','BTC','JPY') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `offerte_sconti`
--

INSERT INTO `offerte_sconti` (`id`, `id_offerta`, `id_prodotto`, `prezzo`, `valuta`) VALUES
(1, 1, 1, 0.25, 'EUR');

-- --------------------------------------------------------

--
-- Struttura della tabella `offerte_tipi`
--

CREATE TABLE `offerte_tipi` (
  `id` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `offerte_tipi`
--

INSERT INTO `offerte_tipi` (`id`, `tipo`) VALUES
(1, 'Sconto'),
(2, 'Omaggio'),
(3, 'NxM');

-- --------------------------------------------------------

--
-- Struttura della tabella `opzioni`
--

CREATE TABLE `opzioni` (
  `id` int(11) NOT NULL,
  `valore` varchar(100) NOT NULL,
  `id_filtro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `opzioni`
--

INSERT INTO `opzioni` (`id`, `valore`, `id_filtro`) VALUES
(1, '23"', 1),
(2, '40"', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `ordini`
--

CREATE TABLE `ordini` (
  `id` int(11) NOT NULL,
  `tipo_pagamento` enum('Carta','Paypal','Bitcoin','Contrassegno') NOT NULL,
  `id_m_pagamento` int(11) DEFAULT NULL,
  `id_indirizzo` int(11) NOT NULL,
  `id_dati_anagrafici` int(11) NOT NULL,
  `totale` float NOT NULL,
  `valuta` enum('EUR','USD','GBP','BTC','JPY') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `pagamenti_preferiti`
--

CREATE TABLE `pagamenti_preferiti` (
  `id` int(11) NOT NULL,
  `id_utente_r` int(11) NOT NULL,
  `tipo` enum('Carta','Paypal','Bitcoin','') NOT NULL,
  `id_m_pagamento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `pagamenti_preferiti`
--

INSERT INTO `pagamenti_preferiti` (`id`, `id_utente_r`, `tipo`, `id_m_pagamento`) VALUES
(1, 1, 'Carta', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotti`
--

CREATE TABLE `prodotti` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `info` varchar(200) NOT NULL,
  `descrizione` text NOT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `prezzo` float NOT NULL,
  `valuta` enum('EUR','USD','GBP','BTC','JPY') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `prodotti`
--

INSERT INTO `prodotti` (`id`, `nome`, `info`, `descrizione`, `id_categoria`, `prezzo`, `valuta`) VALUES
(1, 'latte granarolo', 'Granarolo Latte Parzialmente Scremato a Lunga Conservazione 1 Litro', 'energia: 199 kJ, 47 kcal \r\ngrassi: 1,6 g \r\ndi cui acidi grassi saturi: 1,1 g \r\ncarboidrati: 5,0 g \r\ndi cui zuccheri: 5,0 g \r\nproteine: 3,2 g \r\nsale: 0,10 g \r\ncalcio:120 mg, 15%', 3, 1.29, 'EUR');

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `id` int(11) NOT NULL,
  `id_datianagrafici` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id`, `id_datianagrafici`, `email`, `username`, `password`) VALUES
(1, 1, 'mariorossi@gmail.com', '', 'xyz');

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti_registrati`
--

CREATE TABLE `utenti_registrati` (
  `id` int(11) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `punti` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `valori`
--

CREATE TABLE `valori` (
  `id` int(11) NOT NULL,
  `id_prodotto` int(11) NOT NULL,
  `id_opzione` int(11) DEFAULT NULL,
  `valore` varchar(100) DEFAULT NULL,
  `id_filtro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `carrelli`
--
ALTER TABLE `carrelli`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `carte`
--
ALTER TABLE `carte`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `padre` (`padre`);

--
-- Indici per le tabelle `comuni`
--
ALTER TABLE `comuni`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `dati_anagrafici`
--
ALTER TABLE `dati_anagrafici`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `filtri`
--
ALTER TABLE `filtri`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indici per le tabelle `gestori`
--
ALTER TABLE `gestori`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_datianagrafici` (`id_utente`);

--
-- Indici per le tabelle `indirizzi`
--
ALTER TABLE `indirizzi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_comune` (`id_comune`);

--
-- Indici per le tabelle `indirizzi_preferiti`
--
ALTER TABLE `indirizzi_preferiti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utente_r` (`id_utente_r`),
  ADD KEY `id_indirizzo` (`id_indirizzo`);

--
-- Indici per le tabelle `items_carrello`
--
ALTER TABLE `items_carrello`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_prodotto` (`id_prodotto`),
  ADD KEY `id_carrello` (`id_carrello`);

--
-- Indici per le tabelle `items_magazzino`
--
ALTER TABLE `items_magazzino`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ordine` (`id_magazzino`),
  ADD KEY `id_prodotto` (`id_prodotto`);

--
-- Indici per le tabelle `items_ordine`
--
ALTER TABLE `items_ordine`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ordine` (`id_ordine`),
  ADD KEY `id_prodotto` (`id_prodotto`);

--
-- Indici per le tabelle `magazzini`
--
ALTER TABLE `magazzini`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_gestore` (`id_gestore`),
  ADD KEY `id_indirizzo` (`id_indirizzo`);

--
-- Indici per le tabelle `offerte`
--
ALTER TABLE `offerte`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tipo` (`id_tipo`);

--
-- Indici per le tabelle `offerte_mxn`
--
ALTER TABLE `offerte_mxn`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_offerta` (`id_offerta`),
  ADD KEY `id_prodotto` (`id_prodotto`);

--
-- Indici per le tabelle `offerte_omaggi`
--
ALTER TABLE `offerte_omaggi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_offerta` (`id_offerta`),
  ADD KEY `id_omaggio` (`id_prodotto_omaggio`);

--
-- Indici per le tabelle `offerte_omaggi_condizioni`
--
ALTER TABLE `offerte_omaggi_condizioni`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_prodotto` (`id_prodotto`),
  ADD KEY `id_offerta_omaggio` (`id_offerta_omaggio`);

--
-- Indici per le tabelle `offerte_sconti`
--
ALTER TABLE `offerte_sconti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_offerta` (`id_offerta`),
  ADD KEY `id_prodotto` (`id_prodotto`);

--
-- Indici per le tabelle `offerte_tipi`
--
ALTER TABLE `offerte_tipi`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `opzioni`
--
ALTER TABLE `opzioni`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_filtro` (`id_filtro`);

--
-- Indici per le tabelle `ordini`
--
ALTER TABLE `ordini`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_indirizzo` (`id_indirizzo`),
  ADD KEY `id_dati_anagrafici` (`id_dati_anagrafici`);

--
-- Indici per le tabelle `pagamenti_preferiti`
--
ALTER TABLE `pagamenti_preferiti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utente_r` (`id_utente_r`);

--
-- Indici per le tabelle `prodotti`
--
ALTER TABLE `prodotti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_datianagrafici` (`id_datianagrafici`);

--
-- Indici per le tabelle `utenti_registrati`
--
ALTER TABLE `utenti_registrati`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utente` (`id_utente`);

--
-- Indici per le tabelle `valori`
--
ALTER TABLE `valori`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_prodotto` (`id_prodotto`),
  ADD KEY `id_opzione` (`id_opzione`),
  ADD KEY `id_filtro` (`id_filtro`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `carrelli`
--
ALTER TABLE `carrelli`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT per la tabella `carte`
--
ALTER TABLE `carte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT per la tabella `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT per la tabella `comuni`
--
ALTER TABLE `comuni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT per la tabella `dati_anagrafici`
--
ALTER TABLE `dati_anagrafici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT per la tabella `filtri`
--
ALTER TABLE `filtri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT per la tabella `gestori`
--
ALTER TABLE `gestori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT per la tabella `indirizzi`
--
ALTER TABLE `indirizzi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT per la tabella `indirizzi_preferiti`
--
ALTER TABLE `indirizzi_preferiti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT per la tabella `items_magazzino`
--
ALTER TABLE `items_magazzino`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `items_ordine`
--
ALTER TABLE `items_ordine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `magazzini`
--
ALTER TABLE `magazzini`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT per la tabella `offerte`
--
ALTER TABLE `offerte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT per la tabella `offerte_mxn`
--
ALTER TABLE `offerte_mxn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `offerte_omaggi`
--
ALTER TABLE `offerte_omaggi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `offerte_omaggi_condizioni`
--
ALTER TABLE `offerte_omaggi_condizioni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `offerte_sconti`
--
ALTER TABLE `offerte_sconti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT per la tabella `offerte_tipi`
--
ALTER TABLE `offerte_tipi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT per la tabella `opzioni`
--
ALTER TABLE `opzioni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT per la tabella `ordini`
--
ALTER TABLE `ordini`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `pagamenti_preferiti`
--
ALTER TABLE `pagamenti_preferiti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT per la tabella `prodotti`
--
ALTER TABLE `prodotti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT per la tabella `utenti_registrati`
--
ALTER TABLE `utenti_registrati`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `valori`
--
ALTER TABLE `valori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `categorie`
--
ALTER TABLE `categorie`
  ADD CONSTRAINT `categorie_ibfk_1` FOREIGN KEY (`padre`) REFERENCES `categorie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `filtri`
--
ALTER TABLE `filtri`
  ADD CONSTRAINT `filtri_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorie` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limiti per la tabella `gestori`
--
ALTER TABLE `gestori`
  ADD CONSTRAINT `gestori_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `utenti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `indirizzi`
--
ALTER TABLE `indirizzi`
  ADD CONSTRAINT `indirizzi_ibfk_1` FOREIGN KEY (`id_comune`) REFERENCES `comuni` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Limiti per la tabella `indirizzi_preferiti`
--
ALTER TABLE `indirizzi_preferiti`
  ADD CONSTRAINT `indirizzi_preferiti_ibfk_1` FOREIGN KEY (`id_indirizzo`) REFERENCES `indirizzi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `indirizzi_preferiti_ibfk_2` FOREIGN KEY (`id_utente_r`) REFERENCES `utenti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `items_carrello`
--
ALTER TABLE `items_carrello`
  ADD CONSTRAINT `items_carrello_ibfk_1` FOREIGN KEY (`id_prodotto`) REFERENCES `prodotti` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `items_carrello_ibfk_2` FOREIGN KEY (`id_carrello`) REFERENCES `carrelli` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `items_magazzino`
--
ALTER TABLE `items_magazzino`
  ADD CONSTRAINT `items_magazzino_ibfk_1` FOREIGN KEY (`id_magazzino`) REFERENCES `magazzini` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `items_magazzino_ibfk_2` FOREIGN KEY (`id_prodotto`) REFERENCES `prodotti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `items_ordine`
--
ALTER TABLE `items_ordine`
  ADD CONSTRAINT `items_ordine_ibfk_1` FOREIGN KEY (`id_ordine`) REFERENCES `ordini` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `items_ordine_ibfk_2` FOREIGN KEY (`id_prodotto`) REFERENCES `prodotti` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `magazzini`
--
ALTER TABLE `magazzini`
  ADD CONSTRAINT `magazzini_ibfk_1` FOREIGN KEY (`id_gestore`) REFERENCES `gestori` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `magazzini_ibfk_2` FOREIGN KEY (`id_indirizzo`) REFERENCES `indirizzi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `offerte`
--
ALTER TABLE `offerte`
  ADD CONSTRAINT `offerte_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `offerte_tipi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `offerte_mxn`
--
ALTER TABLE `offerte_mxn`
  ADD CONSTRAINT `offerte_mxn_ibfk_1` FOREIGN KEY (`id_offerta`) REFERENCES `offerte` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `offerte_mxn_ibfk_2` FOREIGN KEY (`id_prodotto`) REFERENCES `prodotti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `offerte_omaggi`
--
ALTER TABLE `offerte_omaggi`
  ADD CONSTRAINT `offerte_omaggi_ibfk_1` FOREIGN KEY (`id_prodotto_omaggio`) REFERENCES `prodotti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `offerte_omaggi_ibfk_2` FOREIGN KEY (`id_offerta`) REFERENCES `offerte` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `offerte_omaggi_condizioni`
--
ALTER TABLE `offerte_omaggi_condizioni`
  ADD CONSTRAINT `offerte_omaggi_condizioni_ibfk_1` FOREIGN KEY (`id_offerta_omaggio`) REFERENCES `offerte_omaggi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `offerte_omaggi_condizioni_ibfk_2` FOREIGN KEY (`id_prodotto`) REFERENCES `prodotti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `offerte_sconti`
--
ALTER TABLE `offerte_sconti`
  ADD CONSTRAINT `offerte_sconti_ibfk_1` FOREIGN KEY (`id_offerta`) REFERENCES `offerte` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `offerte_sconti_ibfk_2` FOREIGN KEY (`id_prodotto`) REFERENCES `prodotti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `opzioni`
--
ALTER TABLE `opzioni`
  ADD CONSTRAINT `opzioni_ibfk_1` FOREIGN KEY (`id_filtro`) REFERENCES `filtri` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `ordini`
--
ALTER TABLE `ordini`
  ADD CONSTRAINT `ordini_ibfk_1` FOREIGN KEY (`id_dati_anagrafici`) REFERENCES `dati_anagrafici` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ordini_ibfk_2` FOREIGN KEY (`id_indirizzo`) REFERENCES `indirizzi` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `pagamenti_preferiti`
--
ALTER TABLE `pagamenti_preferiti`
  ADD CONSTRAINT `pagamenti_preferiti_ibfk_1` FOREIGN KEY (`id_utente_r`) REFERENCES `utenti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `prodotti`
--
ALTER TABLE `prodotti`
  ADD CONSTRAINT `prodotti_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorie` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limiti per la tabella `utenti`
--
ALTER TABLE `utenti`
  ADD CONSTRAINT `utenti_ibfk_1` FOREIGN KEY (`id_datianagrafici`) REFERENCES `dati_anagrafici` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `utenti_registrati`
--
ALTER TABLE `utenti_registrati`
  ADD CONSTRAINT `utenti_registrati_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `utenti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `valori`
--
ALTER TABLE `valori`
  ADD CONSTRAINT `valori_ibfk_2` FOREIGN KEY (`id_opzione`) REFERENCES `opzioni` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `valori_ibfk_3` FOREIGN KEY (`id_prodotto`) REFERENCES `prodotti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `valori_ibfk_4` FOREIGN KEY (`id_filtro`) REFERENCES `filtri` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

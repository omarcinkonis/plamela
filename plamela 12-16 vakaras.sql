-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2020 at 06:10 PM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `plamela`
--

-- --------------------------------------------------------

--
-- Table structure for table `inventory465`
--

CREATE TABLE `inventory465` (
  `pro_id` int(11) NOT NULL,
  `inventory_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventory465`
--

INSERT INTO `inventory465` (`pro_id`, `inventory_quantity`) VALUES
(0, 0),
(1, 1),
(2, 1),
(3, 8),
(4, 2),
(8, 2);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `user_id` int(11) NOT NULL,
  `login_username` varchar(20) NOT NULL,
  `login_password` tinytext NOT NULL,
  `login_salt` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_price` double NOT NULL,
  `order_date` date NOT NULL,
  `order_status` varchar(12) NOT NULL,
  `order_deliveryTime` varchar(20) DEFAULT NULL,
  `order_fullName` varchar(100) NOT NULL,
  `order_phone` varchar(12) NOT NULL,
  `order_products` text NOT NULL,
  `order_shippingAddress` varchar(100) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `pro_id` int(11) NOT NULL,
  `pro_name` varchar(32) NOT NULL,
  `pro_price` double NOT NULL,
  `pro_unitSize` varchar(32) NOT NULL,
  `pro_img` varchar(32) NOT NULL,
  `pro_category` text NOT NULL,
  `pro_supply` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`pro_id`, `pro_name`, `pro_price`, `pro_unitSize`, `pro_img`, `pro_category`, `pro_supply`) VALUES
(1, 'Rikota', 3.49, 'vnt', 'rikota.png', 'Pieno produktai ir kiaušiniai', 12500),
(2, 'Varškė', 1.19, 'vnt', 'varske.png', 'Pieno produktai ir kiaušiniai', 46000),
(3, 'Mangai', 1.99, 'kg', 'mangai.png', 'Daržovės ir vaisiai', 320),
(4, 'Brokoliai', 0.99, 'kg', 'brokolis.png', 'Daržovės ir vaisiai', 265),
(6, 'Avokadai', 2.39, 'kg', 'avokadas-vnt.jpg', 'Daržovės ir vaisiai', 654456),
(7, 'Pienas', 0.89, 'l', 'pienas.jpg', 'Pieno produktai ir kiaušiniai', 156),
(8, 'Vištienos krūtinėlės', 3.89, 'kg', 'vistiena.png', 'Mėsa ir žuvis', 696),
(9, 'Bananai', 0.39, 'kg', 'bananai.png', 'Daržovės ir vaisiai', 7852);

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `rec_id` int(11) NOT NULL,
  `rec_name` varchar(32) NOT NULL,
  `rec_desc` text NOT NULL,
  `rec_ingredients` text NOT NULL,
  `rec_approxPrice` varchar(32) NOT NULL,
  `rec_calories` int(11) NOT NULL,
  `rec_img` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`rec_id`, `rec_name`, `rec_desc`, `rec_ingredients`, `rec_approxPrice`, `rec_calories`, `rec_img`) VALUES
(1, 'Avokadų salotos su ananasais', 'Avokadą perpjauti pusiau, išimti kauliukus, išskobti minkštimą, supjaustyti kubeliais. Ananasą nuvalyti, išpjauti šerdį, supjaustyti kubeliais. Agurkus taip pat supjausti tokios pat dydžio kubeliais. Svogūną smulkiai sukapoti.\r\nViską išmaišyti dubenyje, pabarstyti druska ir pipirais, aitriąją paprika, apšlakstyti citrinos sultimis. Tiekti iš karto!\r\n', 'Ananasai | 1 | vnt\r\nAvokadai | 2 | vnt\r\nAgurkai | 2 | vnt\r\nSvogūnai | 1 | vnt\r\nDruska |  | \r\nAitriosios paprikos milteliai |  | \r\nPipirai |  | \r\nŽalioji citrina | 1 | vnt', '3.80', 100, 'avokadusalotos.jpg'),
(2, 'Moliūgų sriuba', 'Supjaustykite smulkiai imbierą ir pakepkite kokosų aliejuje kol švelniai paruduos\r\nSupilkite kubeliais supjaustytą moliūgą, apkepkite 3-4 min.\r\nĮpilkite vandens ir viską patroškinkite kol moliūgas suminkštės.\r\nĮpilkite kokosų pieno, viską gerai išmaišykite ir dar šiek tiek pakaitinkite.\r\nSupilkite masę į blenderį ir gerai sutrinkite.\r\n', 'Moliūgai | 400 | g\r\nKokosų aliejus |  | \r\nImbierai |  | \r\nKokosų pienas | 80 | ml\r\nVanduo | 160 | ml', '2.00', 140, 'moliugusriuba.jpg'),
(3, 'Ryžių košė su cinamonu', 'Užvirkite vandenį, sudėkite perplautus ryžius.\r\nSumažinkite ugnį ir virkite ryžius pamaišydami apie pusvalandį.\r\nRyžiams suminkštėjus įpilkite kokosų pieną, viską gerai išmaišykite.\r\nSuberkite cinamoną.\r\nIšvirusią košę dėkite į dubenėlius, puoškite bananais, braškėmis, lukštentomis kanapių sėklomis, saldinkite agavų sirupu.', 'Rudi ryžiai | 240 | g\r\nVanduo | 375 | ml\r\nKokosų pienas | 125 | ml\r\nCinamonas |  | \r\nBananai | 1 | vnt\r\nBraškės | 3 | vnt\r\nLukštentos kanapių sėklos | 20 | g\r\nAgavų sirupas |  | ', '1.80', 120, 'ryziukose.jpg'),
(4, 'Gardūs vištienos kąsneliai', 'Vištienos filė supjaustykite vidutinio dydžio gabaliukais. Dėkite į dubenį, įberkite druskos pipirų, įdėkite garstyčių ir medaus padažo, gerai išmaišykite bei bent valandai dėkite į šaldytuvą. Nesaldžius riestainius sutrupinkite elektriniu smulkintuvu ir pridėkite druskos. Kiekvieną vištienos gabaliuką apvoliokite smulkintuose riestainiuose, dėkite ant grotelių ir kepkite iki 180 laipsnių įkaitintoje orkaitėje apie 20 min.', 'Vištienos krūtinėlė | 125 | g\r\nGarstyčių medaus padažas | 13 | ml\r\nDžiūvėsiai | 25 | g', '3.20', 290, 'gardusvistienoskasneliai.jpg'),
(5, 'Šokoladinis pyragas', 'Įkaitinkite orkaitę iki 170–180 laipsnių. Kepimo indą su aukštais kraštai išklokite kepimo popieriumi ir ištepkite sviestu. Ištirpinkite 2 šokolado plyteles ir 150 g sviesto, išplakite 7 kiaušinius. Atsargiai išmaišykite išplaktus kiaušinius, išlydytą šokoladą bei sviestą ir supilkite į kepimo indą.. Kepkite apie 30–40 min, patikrindami dantų krapštuku.', 'Šokoladas | 1 | vnt\r\nSviestas | 75 | g\r\nKiaušiniai | 3 | vnt', '1.60', 450, 'sokoladinispyragas.jpg'),
(6, 'Apelsinų pyragas', 'Dideliame dubenyje sumaišykite 500 g miltinio pyrago mišinio, 200 g neriebaus graikiško jogurto ir 1 stiklinę apelsinų sulčių. Galite įtarkuoti apelsinų žievelės. Kepkite 180 laipsnių orkaitėje 30–35 min.', 'Miltinis pyrago mišinys | 250 | g\r\nJogurtas | 100 | g\r\nApelsinų sultys | 120 | ml', '2.50', 390, 'apelsinupyragas.jpg'),
(7, 'Salotos su persimonais', 'Pirmiausia persimoną supjaustykite kaip tik norisi, griežinėliais arba smulkesniais kubeliais.\r\nTuomet avokadą perpjaukite pusiau, išimkite kaulą ir supjaustykite kubeliais.\r\nApšlakstykite citrinų sultimis. Į lėkštes dėkite rukolos lapelius, avokadą, persimoną ir kumpio griežinėlius.\r\nGaliausiai pabarstykite trupintu fetos sūriu, čili dribsniais bei apšlakstykite alyvuogių aliejumi. ', 'Persimonai | 1 | vnt\r\nAvokadai | 1 | vnt\r\nSerano kumpis | 50 | g\r\nFeta sūris | 50 | g\r\nRukola |  | \r\nCintrinos sultys |  | \r\nAlyvuogių aliejus | 10 | ml\r\nČili dribsniai |  | ', '3.00', 150, 'salotossupersimonais.jpg'),
(8, 'Vafliai', 'Kiaušinius išplakame su cukrumi, kartu beriame ir vanilinį cukrų. Dedame miltus, vėl plakame.\r\nĮ vientisą masę supilame ištirpintą sviestą ir vėl maišome iki vientisos masės. Tešla turi lengvai bėgti nuo šaukšto, jei matote, kad per skysta pridėkite miltų.\r\nTešlą dėkite tik į labai stipriai įkaitusią vaflinę, iškepusius susukite vos išėmę iš keptuvės. Puoškite šokoladu, arba valgykite su ledais.', 'Sviestas | 100 | g\r\nKiaušiniai | 3 | vnt\r\nCukrus | 120 | g\r\nMiltai | 160 | g', '2.80', 280, 'vafliai.jpg'),
(9, 'Vištienos krūtinėlė', 'Dubenėlį pripilkite šilto (ne karšto) vandens, berkite dosniai druskos (kad vanduo gautųsi sūrus, puslitriui vandens dedu vieną-du šaukštus druskos), išmaišykite, kad ištirptų. Sudėkite vištieną ir palikite brinkti apie 15 minučių. Vanduo turėtų visiškai apsemti vištieną. Po 15 minučių išimkite vištieną, nuplaukite po šaltu vandeniu ir nusausinkite. Beje, galite vištieną pamerkti ir iš anksto, tik tada laikykite dubenį su vištiena ne kambario temperatūroje, o šaldytuve ir geriau nelaikykite ilgiau negu 5-6 valandų, nes vištiena bus per sūri.\r\nIštepkite vištieną tirpintu sviestu ir įtrinkite prieskoniais iš abiejų pusių. Sudėkite į kepimo indą.\r\nDėkite vištieną į iki 230 C įkaitintą orkaitę kepti 15 - 18 minučių. Jeigu norite labiau apskrudusios vištienos, į kepimo pabaigą galite 3-5 minutėms įjungti grilio režimą.\r\nVištieną išimkite ir palikite 5 - 10 minučių pastovėti, prieš pjaustant (kad tuo metu vištiena neatvėstų, galite skardą pridengti folija arba rankšluostėliu).', 'Vištienos krūtinėlė | 150 | g\r\nSviestas | 30 | g\r\nPrieskoniai vištienai |  | \r\nDruska |  | ', '3.20', 560, 'vistienoskrutinele.jpg'),
(10, 'Aviečių ledai', 'Bananus supjaustyti riekelėmis, sudėti į šaldymo maišelį ir padėti į šaldiklį kelioms valandoms (arba per naktį), kad visiškai sustingtų.\r\nŠaldytus bananus, šaldytas uogas ir grietinėlę (arba pieną) sudėti į virtuvės kombaino indą ir sutrinti iki vientisos masės. Trinti iki kol masė bus vientisa, bet jokiu būdu ne skysta.\r\nGalima valgyti iškart, arba, jeigu norite tvirtesnių ledų, sudėkite į formą ir palaikykite šaldiklyje 30-60 minučių.', 'Bananai | 2 | vnt\r\nAvietės | 100 | g\r\nGrietinėlė | 60 | ml', '3.20', 460, 'avieciuledai.jpg'),
(11, 'Mango kremas', 'Mangą nulupkite ir nupjaukite minkštimą nuo kauliuko.\r\nViską sudėkite į virtuvės kombaino indą ir gerai sutrinkite iki vientisos kreminės konsistencijos. Jeigu kombaino neturite, sutrinkite rankiniu elektriniu trintuvu.\r\n', 'Rikota | 200 | g\r\nVarškė | 200 | g\r\nMangai | 1 | vnt', '4.50', 320, 'mangokremas.jpg'),
(12, 'Tuno užtepėlė', 'Pomidorus sutriname elektriniu trintuvu (jei norime vientisos masės) arba smulkiai supjaustome (jei norime, kad jaustųsi gabaliukai), tuną išmaišome su kreminiu sūriu ir pomidorais. Tepame ant bagetės.\r\nPuošiame petražolėmis.\r\n', 'Skardinė tuno savo sultyse | 1 | vnt\r\nKreminis sūris | 150 | g\r\nSaulėje džiovinti pomidorai | 8 | vnt\r\nBagetė | 1 | vnt\r\nPetražolės |  | ', '3.20', 470, 'tunouztepele.jpg'),
(13, 'Pomidorų sriuba su pupelėmis', 'Svogūnus, česnaką, papriką susmulkinkite. Morką sutarkuokite.\r\nPuode įkaitinkite aliejų, kelias minutes apkepinkite svogūnus ir česnakus, tuomet dėkite papriką ir morką, pakepinkite, kol morkos šiek tiek susileis 5 - 8 minutes.\r\nĮ puodą supilkite konservuotus pomidorus, nukoštas pupeles, patroškinkite kelias minutes, tuomet pilkite sultinį ir berkite prieskonius. Užvirinkite ir pavirkite ant nedidelės ugnies 10 minučių.\r\nPatiekdami galite užberti smulkintų žalumynų. Skanaus!\r\n', 'Sultinys | 180 | ml\r\nKonservuoti pomidorai savo sultyse  | 100 | g\r\nKonservuotos pupelės | 60 | g\r\nSvogūnai | 1 | vnt\r\nMorkos | 1 | vnt\r\nPaprikos | 1 | vnt\r\nČesnakai |  | \r\nAliejus |  | \r\nDruska |  | \r\nPipirai |  | \r\nMaltas muskatas |  | ', '5.20', 240, 'pomidorusriuba.jpg'),
(14, 'Šnicelis', 'Mėsą nuplaukite, gerai nusausinkite virtuviniu popieriumi, virtuviniu plaktukų plakite mėsą, kol ši bus kuo plonesnė, bet tik tiek, kad neatsirastų skylių ir gabalas liktų vientisas. Paberkite druska ir pipirais.\r\nNuo duonos nupjaukite plutelę, Sumalkite duoną virtuviniu kombainu, iškratykite trupinius į didesnę lėkštę. Įkaitinkite didesnę keptuvę, įpilkite aliejaus, jo reikės gana nemažai, kepsniai turi jame beveik plaukti.\r\nImkite mėsos gabaliuką apvoliokite miltuose, tada kiaušinyje, tada šviežiuose duonos trupiniuose. Dėkite į karštą aliejų, kaitrą sumažinkite iki vidutinio stiprumo, kepkite vos 2 - 4 minutes iš abiejų pusių, kol trupiniai gražiai paruduos.\r\nIšėmus iš keptuvės, dėkite kepsnius ant vrtuvinio popieriaus, kad nuvarvėtų riebalai ir iš kart serviruokite su vienu ar dviem ketvirtadaliais citrinos. Tokius kepsnius austrai valgo su žaliomis salotomis ir visokio pavidalo bulvėmis, tarp jų ir su bulvių salotomis .\r\n', 'Veršienos išpjova  | 2 | vnt\r\nŠviesi forminė duona | 250 | g\r\nKiaušiniai | 1 | vnt\r\nMiltai | 50 | g\r\nDruska |  | \r\nPipirai |  | \r\nAliejus |  | ', '5.60', 630, 'snicelis.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_fullName` varchar(100) NOT NULL,
  `user_shippingAddress` varchar(100) NOT NULL,
  `user_deliveryTimes` varchar(100) DEFAULT NULL,
  `user_phone` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventory465`
--
ALTER TABLE `inventory465`
  ADD PRIMARY KEY (`pro_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`pro_id`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`rec_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `pro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `rec_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

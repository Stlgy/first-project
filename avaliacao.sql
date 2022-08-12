-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17-Jun-2022 às 10:10
-- Versão do servidor: 10.4.11-MariaDB
-- versão do PHP: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `avaliacao`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `champion`
--

CREATE TABLE `champion` (
  `id_c` int(11) NOT NULL,
  `nome_c` varchar(50) NOT NULL,
  `role_c` varchar(30) NOT NULL,
  `dif_c` varchar(20) NOT NULL,
  `des_c` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `champion`
--

INSERT INTO `champion` (`id_c`, `nome_c`, `role_c`, `dif_c`, `des_c`) VALUES
(1, 'Annie', 'Mage', 'Moderate', 'Dangerous, yet disarmingly precocious, Annie is a child mage with immense pyromantic power. Even in the shadows of the mountains north of Noxus, she is a magical outlier. Her natural affinity for fire manifested early in life through unpredictable, emotional outbursts, though she eventually learned to control these “playful tricks.” Her favorite includes the summoning of her beloved teddy bear, Tibbers, as a fiery protector. Lost in the perpetual innocence of childhood, Annie wanders the dark forests, always looking for someone to play with.'),
(6, 'Kog\'Maw', 'Marksman', 'Moderate', 'Belched forth from a rotting Void incursion deep in the wastelands of Icathia, Kog Maw is an inquisitive yet putrid creature with a caustic, gaping mouth. This particular Void-spawn needs to gnaw and drool on anything within reach to truly understand it. Though not inherently evil, Kog Maws beguiling naiveté is dangerous, as it often precedes a feeding frenzy—not for sustenance, but to satisfy its unending curiosity.'),
(10, 'Ziggs', 'Mage', 'Moderate', 'With a love of big bombs and short fuses, the yordle Ziggs is an explosive force of nature. As an inventors assistant in Piltover, he was bored by his predictable life and befriended a mad, blue-haired bomber named Jinx. After a wild night on the town, Ziggs took her advice and moved to Zaun, where he now explores his fascinations more freely, terrorizing the chem-barons and regular citizens alike in his never ending quest to blow stuff up.'),
(20, 'Thresh', 'Support', 'Moderate', 'Sadistic and cunning, Thresh is an ambitious and restless spirit of the Shadow Isles. Once the custodian of countless arcane secrets, he was undone by a power greater than life or death, and now sustains himself by tormenting and breaking others with slow, excruciating inventiveness. His victims suffer far beyond their brief mortal coil as Thresh wreaks agony upon their souls, imprisoning them in his unholy lantern to torture for all eternity.'),
(24, 'Syndra', 'Mage', 'High', 'Syndra is a fearsome Ionian mage with incredible power at her command. As a child, she disturbed the village elders with her reckless and wild magic. She was sent away to be taught greater control, but eventually discovered her supposed mentor was restraining her abilities. Forming her feelings of betrayal and hurt into dark spheres of energy, Syndra has sworn to destroy all who would try to control her.'),
(28, 'Lux', 'Mage', 'Moderate', 'Luxanna Crownguard hails from Demacia, an insular realm where magical abilities are viewed with fear and suspicion. Able to bend light to her will, she grew up dreading discovery and exile, and was forced to keep her power secret, in order to preserve her family s noble status. Nonetheless, Lux s optimism and resilience have led her to embrace her unique talents, and she now covertly wields them in service of her homeland.'),
(32, 'Zyra', 'Mage', 'Moderate', 'Born in an ancient, sorcerous catastrophe, Zyra is the wrath of nature given form—an alluring hybrid of plant and human, kindling new life with every step. She views the many mortals of Valoran as little more than prey for her seeded progeny, and thinks nothing of slaying them with flurries of deadly spines. Though her true purpose has not been revealed, Zyra wanders the world, indulging her most primal urges to colonize, and strangle all other life from it.'),
(33, 'Heimerdinger', 'Mage', 'High', 'A brilliant yet eccentric yordle scientist, Professor Cecil B. Heimerdinger is one of the most innovative and esteemed inventors Piltover has ever known. Relentless in his work to the point of neurotic obsession, he thrives on answering the universe\'s most impenetrable questions. Though his theories often appear opaque and esoteric, Heimerdinger has crafted some of Piltover\'s most miraculous—not to mention lethal—machinery, and constantly tinkers with his inventions to make them even more efficient.');

-- --------------------------------------------------------

--
-- Estrutura da tabela `habilidades`
--

CREATE TABLE `habilidades` (
  `id_h` int(11) NOT NULL,
  `nome_h` varchar(20) NOT NULL,
  `ordem_h` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `habilidades`
--

INSERT INTO `habilidades` (`id_h`, `nome_h`, `ordem_h`) VALUES
(1, 'Desintegrate', 2),
(2, 'Incinerate', 3),
(3, 'Molten Shield', 4),
(4, 'Summon Tibbers', 5),
(5, 'Caustic Spittle', 2),
(6, 'Bio Arcane Barrage', 3),
(7, 'Void Ooze', 4),
(8, 'Living Artillery', 5),
(9, 'Bouncing Bomb', 2),
(10, 'Satchel Charge', 3),
(11, 'Hexplosive Minefield', 4),
(12, 'Mega Inferno Bomb', 5),
(13, 'Pyromania', 1),
(14, 'Icathian Surprise', 1),
(15, 'Illumination', 1),
(16, 'Light Binding', 2),
(17, 'Prismatic Barrier', 3),
(18, 'Lucent Singularity', 4),
(19, 'Final Spark', 5),
(20, 'Damnation', 1),
(21, 'Death Sentence', 2),
(22, 'Dark Passage', 3),
(23, 'Flay', 4),
(24, 'The Box', 5),
(25, 'Short Fuse', 1),
(30, 'Transcendent', 1),
(31, 'Dark Sphere', 2),
(32, 'Force of Will', 3),
(33, 'Scatter the Weak', 4),
(34, 'Unleashed Power', 5),
(35, 'Bop N Block', 1),
(36, 'Prowling projectile', 2),
(37, 'You and Me', 3),
(38, 'Zoomies', 4),
(39, 'Final Chapter', 5),
(40, 'Garden of Thorns', 1),
(41, 'Deadly Spines', 2),
(42, 'Rampant Growth', 3),
(43, 'Grasping Roots', 4),
(44, 'Stranglethorns', 5),
(45, 'Hextech Affinity', 1),
(46, 'H-28 G Evolution Tur', 2),
(47, 'Hextech Micro Rocket', 3),
(48, 'Ch-2 Electron Storm ', 4),
(49, 'Upgrade', 5),
(50, 'Gathering Fire', 1),
(51, 'Inner Flame', 2),
(52, 'Focused Resolve', 3),
(53, 'Inspire', 4),
(54, 'Mantra', 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `habilidadeschampion`
--

CREATE TABLE `habilidadeschampion` (
  `id_hc` int(11) NOT NULL,
  `id_c_hc` int(11) NOT NULL,
  `id_h_hc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `habilidadeschampion`
--

INSERT INTO `habilidadeschampion` (`id_hc`, `id_c_hc`, `id_h_hc`) VALUES
(1, 1, '1,2,3,13,4'),
(2, 6, '6,5,14,8,7'),
(3, 10, '9,11,12,10,25'),
(4, 20, '20,22,21,23,24'),
(5, 24, '31,32,33,30,34'),
(6, 28, '19,15,16,18,17'),
(7, 32, '41,40,43,42,44'),
(8, 32, '35,39,36,37,38'),
(9, 32, '35,39,36,37,38'),
(10, 32, '48,46,45,47,49'),
(11, 32, '48,46,45,47,49'),
(12, 32, '48,46,45,47,49'),
(13, 33, '48,46,45,47,49'),
(14, 33, '48,46,45,47,49'),
(15, 33, '48,46,45,47,49');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id_u` int(11) NOT NULL,
  `nome_u` varchar(50) NOT NULL,
  `pass_u` varchar(256) NOT NULL,
  `nivel_u` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id_u`, `nome_u`, `pass_u`, `nivel_u`) VALUES
(1, 'admin', '$2y$10$PUvYseDtOn9/.zf4PAVQx.3nMT/oGSU2XQe8d5tDJCX7p.1unu8eW', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `champion`
--
ALTER TABLE `champion`
  ADD PRIMARY KEY (`id_c`);

--
-- Índices para tabela `habilidades`
--
ALTER TABLE `habilidades`
  ADD PRIMARY KEY (`id_h`);

--
-- Índices para tabela `habilidadeschampion`
--
ALTER TABLE `habilidadeschampion`
  ADD PRIMARY KEY (`id_hc`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_u`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `champion`
--
ALTER TABLE `champion`
  MODIFY `id_c` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de tabela `habilidades`
--
ALTER TABLE `habilidades`
  MODIFY `id_h` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de tabela `habilidadeschampion`
--
ALTER TABLE `habilidadeschampion`
  MODIFY `id_hc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id_u` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

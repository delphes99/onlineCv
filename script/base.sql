SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Structure de la table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
`id` int(11) NOT NULL COMMENT 'primary key',
  `name` varchar(100) NOT NULL COMMENT 'company name',
  `icon` varchar(50) NOT NULL,
  `url` varchar(100) DEFAULT NULL
);

-- --------------------------------------------------------

--
-- Structure de la table `experience`
--

CREATE TABLE IF NOT EXISTS `experience` (
`id` int(11) NOT NULL COMMENT 'primary key',
  `title` varchar(50) NOT NULL COMMENT 'title',
  `status` varchar(50) NOT NULL COMMENT 'mission status',
  `client` int(11) NOT NULL COMMENT 'client',
  `employer` int(11) NOT NULL COMMENT 'employer',
  `type` varchar(50) NOT NULL COMMENT 'mission type',
  `location` varchar(50) NOT NULL COMMENT 'mission location',
  `short_desc` text NOT NULL COMMENT 'short description',
  `long_desc` text NOT NULL COMMENT 'long description',
  `beginning` date NOT NULL COMMENT 'mission start',
  `end` date DEFAULT NULL COMMENT 'mission end',
  `lang` varchar(15) NOT NULL DEFAULT 'fr_FR.utf8'
);

-- --------------------------------------------------------

--
-- Structure de la table `experience_goal`
--

CREATE TABLE IF NOT EXISTS `experience_goal` (
`id` int(11) NOT NULL COMMENT 'primary key',
  `id_experience` int(11) NOT NULL COMMENT 'link experience',
  `description` varchar(150) NOT NULL COMMENT 'text'
);

-- --------------------------------------------------------

--
-- Structure de la table `experience_skill`
--

CREATE TABLE IF NOT EXISTS `experience_skill` (
  `id_experience` int(11) NOT NULL,
  `id_skill` int(11) NOT NULL,
  `version` varchar(50) NOT NULL
);

--
-- Structure de la table `formation`
--

CREATE TABLE IF NOT EXISTS `formation` (
`id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `instructor` varchar(150) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1 : Formation / 2 : Education'
);

-- --------------------------------------------------------

--
-- Structure de la table `major_skill_type`
--

CREATE TABLE IF NOT EXISTS `major_skill_type` (
  `id` int(11) NOT NULL,
  `alias` varchar(15) CHARACTER SET latin1 NOT NULL,
  `name` varchar(25) CHARACTER SET latin1 NOT NULL,
  `icon` varchar(100) CHARACTER SET latin1 NOT NULL
);

-- --------------------------------------------------------

--
-- Structure de la table `personnal_experience`
--

CREATE TABLE IF NOT EXISTS `personnal_experience` (
  `id` int(11) NOT NULL COMMENT 'primary key',
  `title` varchar(50) NOT NULL COMMENT 'title',
  `html` text NOT NULL COMMENT 'description',
  `beginning` date NOT NULL COMMENT 'mission start',
  `end` date DEFAULT NULL COMMENT 'mission end',
  `lang` varchar(15) NOT NULL DEFAULT 'fr_FR.utf8'
);

-- --------------------------------------------------------

--
-- Structure de la table `personnal_experience_skill`
--

CREATE TABLE IF NOT EXISTS `personnal_experience_skill` (
  `id_personnal_experience` int(11) NOT NULL,
  `id_skill` int(11) NOT NULL,
  `version` varchar(50) NOT NULL
);

-- --------------------------------------------------------

--
-- Structure de la table `skill`
--

CREATE TABLE IF NOT EXISTS `skill` (
`id` int(11) NOT NULL COMMENT 'primary key',
  `name` text NOT NULL COMMENT 'name',
  `type` int(11) NOT NULL COMMENT 'type',
  `description` varchar(255) NOT NULL COMMENT 'description',
  `important` tinyint(1) NOT NULL
);

-- --------------------------------------------------------

--
-- Structure de la table `skill_type`
--

CREATE TABLE IF NOT EXISTS `skill_type` (
`id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `major_type` int(11) NOT NULL COMMENT '1 : Technologies / 2 : Librairies / 3 : Utils'
);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `company`
--
ALTER TABLE `company`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `experience`
--
ALTER TABLE `experience`
 ADD PRIMARY KEY (`id`), ADD KEY `client` (`client`), ADD KEY `employer` (`employer`);

--
-- Index pour la table `experience_goal`
--
ALTER TABLE `experience_goal`
 ADD PRIMARY KEY (`id`), ADD KEY `id_experience` (`id_experience`), ADD KEY `id_experience_2` (`id_experience`);

--
-- Index pour la table `experience_skill`
--
ALTER TABLE `experience_skill`
 ADD PRIMARY KEY (`id_experience`,`id_skill`), ADD KEY `id_skill` (`id_skill`);

--
-- Index pour la table `formation`
--
ALTER TABLE `formation`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `major_skill_type`
--
ALTER TABLE `major_skill_type`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `personnal_experience`
--
ALTER TABLE `personnal_experience`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `personnal_experience_skill`
--
ALTER TABLE `personnal_experience_skill`
 ADD PRIMARY KEY (`id_personnal_experience`,`id_skill`);

--
-- Index pour la table `skill`
--
ALTER TABLE `skill`
 ADD PRIMARY KEY (`id`), ADD KEY `type` (`type`);

--
-- Index pour la table `skill_type`
--
ALTER TABLE `skill_type`
 ADD PRIMARY KEY (`id`), ADD KEY `major_type` (`major_type`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `company`
--
ALTER TABLE `company`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key';
--
-- AUTO_INCREMENT pour la table `experience`
--
ALTER TABLE `experience`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key';
--
-- AUTO_INCREMENT pour la table `experience_goal`
--
ALTER TABLE `experience_goal`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key';
--
-- AUTO_INCREMENT pour la table `formation`
--
ALTER TABLE `formation`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `skill`
--
ALTER TABLE `skill`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key';
--
-- AUTO_INCREMENT pour la table `skill_type`
--
ALTER TABLE `skill_type`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `experience`
--
ALTER TABLE `experience`
ADD CONSTRAINT `experience_ibfk_1` FOREIGN KEY (`client`) REFERENCES `company` (`id`),
ADD CONSTRAINT `experience_ibfk_2` FOREIGN KEY (`employer`) REFERENCES `company` (`id`);

--
-- Contraintes pour la table `experience_skill`
--
ALTER TABLE `experience_skill`
ADD CONSTRAINT `experience_skill_ibfk_1` FOREIGN KEY (`id_experience`) REFERENCES `experience` (`id`),
ADD CONSTRAINT `experience_skill_ibfk_2` FOREIGN KEY (`id_skill`) REFERENCES `skill` (`id`);

--
-- Contraintes pour la table `skill`
--
ALTER TABLE `skill`
ADD CONSTRAINT `skill_ibfk_1` FOREIGN KEY (`type`) REFERENCES `skill_type` (`id`);

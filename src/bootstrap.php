<?php
	require 'model/Company.php';
	require 'model/Experience.php';
	require 'model/experienceGoal.php';
	require 'model/experienceSkill.php';
	require 'model/Formation.php';
	require 'model/Skill.php';
	require 'model/SkillType.php';
	require 'model/MajorSkillType.php';

	// Header HTTP
	header("Content-Type: text/html; charset=utf8");

	// Connexion en base de données
	$db = new PDO('mysql:host='.$con_serv.';dbname='.$con_dbname.'', $con_username, $con_password);
	$db->exec("SET CHARACTER SET utf8");

	// Traduction à partir des .po via Gettext
	$lang = 'fr_FR.utf8';
	$domain = 'cv';
	putenv('LC_ALL=' . $lang);
	setlocale(LC_ALL, $lang);
	bindtextdomain($domain, './lang');
	textdomain($domain);

	// Calcul age
	$today = time();
    $secondes = $today - $dateNaissance;
    $age = date('Y', $secondes) - 1970;


    // Affichage skill
    function listSkillsHelper($list, $displayMinor) {
		$html = '';
		foreach ($list as $skill) {
			if($skill->isImportant()) {
				$html .= '<a class="tech_' . $skill->getId() .' skill importantSkill" onclick="javascript:toggleFilterSkill(' . $skill->getId() . ');">' . $skill->getName() . '</a>';
			} else if($displayMinor) {
				$html .= '<a class="tech_' . $skill->getId() .' skill" onclick="javascript:toggleFilterSkill(' . $skill->getId() . ');">' . $skill->getName() . '</a>';
			}
		}

		return $html;
	}

	// Compagnies
	$selectCompagnies = $db->prepare('SELECT co.id AS ID, co.name AS NAME, co.icon AS ICON FROM company co');
	$selectCompagnies->execute();
	$selectCompagniesResult = $selectCompagnies->fetchAll();

	$compagnies = array();
	foreach ($selectCompagniesResult as $companyDb) {
		$compagnies[$companyDb['ID']] = new Model_Company($companyDb['ID'], $companyDb['NAME'], $companyDb['ICON']);
	}

	// Major Skills
	$selectMajorSkill = $db->prepare('SELECT mj.id AS ID, mj.name AS NAME, mj.alias AS ALIAS FROM major_skill_type mj');
	$selectMajorSkill->execute();
	$selectMajorSkillResult = $selectMajorSkill->fetchAll();

	$majorSkillTypes = array();
	foreach ($selectMajorSkillResult as $majorSkillDb) {
		$majorSkillTypes[$majorSkillDb['ID']] = new Model_MajorSkillType($majorSkillDb['ID'], $majorSkillDb['NAME'], $majorSkillDb['ALIAS']);
	}

	// Skill types
	$selectSkillType = $db->prepare('SELECT ty.id AS ID, ty.name AS NAME, ty.major_type AS MAJOR_TYPE_ID FROM skill_type ty');
	$selectSkillType->execute();
	$selectSkillTypeResult = $selectSkillType->fetchAll();

	$skillTypes = array();
	foreach ($selectSkillTypeResult as $skillTypeDb) {
		$majorSkill = $majorSkillTypes[$skillTypeDb['MAJOR_TYPE_ID']];
		$skillTypes[$skillTypeDb['ID']] = new Model_SkillType($skillTypeDb['ID'], $skillTypeDb['NAME'], $majorSkill);
		$majorSkill->addSkillType($skillTypes[$skillTypeDb['ID']]);
	}

	// Skills
	$selectSkill = $db->prepare('SELECT sk.id AS ID, sk.name AS NAME, sk.description AS DESCRIPTION, sk.type AS SKILL_TYPE_ID, sk.important AS IMPORTANT FROM skill sk');
	$selectSkill->execute();
	$selectSkillResult = $selectSkill->fetchAll();

	$skills = array();
	foreach ($selectSkillResult as $skillDb) {
		$skillType = $skillTypes[$skillDb['SKILL_TYPE_ID']];
		$skills[$skillDb['ID']] = new Model_Skill($skillDb['ID'], $skillDb['NAME'], $skillDb['DESCRIPTION'], $skillType, $skillDb['IMPORTANT']);
		$skillType->addSkill($skills[$skillDb['ID']]);
	}

	// Experiences
	$selectExperiences = $db->prepare('SELECT ex.id AS ID, ex.title AS TITLE, ex.status AS STATUS, ex.client AS CLIENT_ID, ex.employer AS EMPLOYER_ID, ex.type AS TYPE, ex.location AS LOCATION, ex.short_desc AS SHORT_DESCRIPTION, ex.long_desc AS LONG_DESCRIPTION, ex.beginning AS BEGINNING, ex.end AS END FROM experience ex');
	$selectExperiences->execute();
	$selectExperiencesResult = $selectExperiences->fetchAll();

	$experiences = array();
	foreach ($selectExperiencesResult as $experienceDb) {
		$client = $compagnies[$experienceDb['CLIENT_ID']];
		$employer = $compagnies[$experienceDb['EMPLOYER_ID']];
		$experiences[$experienceDb['ID']] = new Model_Experience($experienceDb['ID'], $experienceDb['TITLE'], $experienceDb['STATUS'], $experienceDb['TYPE'], $experienceDb['LOCATION'], $experienceDb['SHORT_DESCRIPTION'], $experienceDb['LONG_DESCRIPTION'], $client, $employer, $experienceDb['BEGINNING'], $experienceDb['END']);
	}

	// Experiences / Skill
	$selectExperienceSkills = $db->prepare('SELECT sk.id_experience AS ID_EXPERIENCE, sk.id_skill AS ID_SKILL, sk.version AS VERSION FROM experience_skill sk');
	$selectExperienceSkills->execute();
	$selectExperienceSkillsResult = $selectExperienceSkills->fetchAll();

	foreach ($selectExperienceSkillsResult as $experienceSkillDb) {
		$skill = $skills[$experienceSkillDb['ID_SKILL']];
		$experience = $experiences[$experienceSkillDb['ID_EXPERIENCE']];
		$experienceSkill = new Model_ExperienceSkill($skill, $experience, $experienceSkillDb['VERSION']);
		$experience->addSkill($experienceSkill);
	}

	// Experiences / goal
	$selectExperienceGoals = $db->prepare('SELECT go.id AS ID, go.id_experience AS ID_EXPERIENCE, go.description AS DESCRIPTION FROM experience_goal go');
	$selectExperienceGoals->execute();
	$selectExperienceGoalsResult = $selectExperienceGoals->fetchAll();

	foreach ($selectExperienceGoalsResult as $experienceGoalDb) {
		$experience = $experiences[$experienceGoalDb['ID_EXPERIENCE']];
		$experienceGoal = new Model_ExperienceGoal($experienceGoalDb['ID'], $experienceGoalDb['DESCRIPTION'], $experience);
		$experience->addGoal($experienceGoal);
	}



	// Formations
	$selectFormations = $db->prepare('SELECT fo.id AS ID, fo.name AS NAME, fo.instructor AS INSTRUCTOR, fo.date AS DATE, fo.type AS TYPE FROM formation fo');
	$selectFormations->execute();
	$selectFormationsResult = $selectFormations->fetchAll();

	$formations = array();
	$educations = array();
	foreach ($selectFormationsResult as $formationDb) {
		$formation = new Model_Formation($formationDb['ID'], $formationDb['NAME'], $formationDb['INSTRUCTOR'], $formationDb['DATE'], $formationDb['TYPE']);
		if($formation->getType() == Model_Formation::TYP_FORMATION) {
			$formations[$formationDb['ID']] = $formation;
		} else if($formation->getType() == Model_Formation::TYP_EDUCTION) {
			$educations[$formationDb['ID']] = $formation;
		}
	}
?>
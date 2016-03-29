<?php
   require 'const.php';

	require 'model/Company.php';
	require 'model/Experience.php';
	require 'model/ExperienceGoal.php';
	require 'model/ExperienceSkill.php';
	require 'model/Formation.php';
	require 'model/PersonnalExperience.php';
	require 'model/PersonnalExperienceSkill.php';
	require 'model/Skill.php';
	require 'model/SkillType.php';
	require 'model/MajorSkillType.php';
	
	// Connexion en base de données
	$db = new PDO('mysql:host='.$con_serv.';dbname='.$con_dbname.';charset=utf8', $con_username, $con_password);
	$db->exec("set names utf8");
	
	// Gestion de la langue
	$langDef=array('fr'=>'fr_FR', 'en'=>'en_EN');
	
	if(isset($_GET['lang'])) {
		// Définition manuelle de langue
		setcookie('lglCvLang', $_GET['lang'], (time() + 365*24*3600));
		$lang = $langDef[$_GET['lang']];
	} else {
		if(isset($_COOKIE['lglCvLang'])) {
			$lang = $langDef[$_COOKIE['lglCvLang']];
		} else {
			// Aucun cookie, langue par défaut
			$lang = $langDef['fr'];
		}
	}
	
	// Récupération de la langue
	
	// Traduction à partir des .po via Gettext
	$domain = 'cv';
	putenv('LC_ALL=' . $lang);
	setlocale(LC_ALL, $lang);
	bindtextdomain($domain, './lang');
	bind_textdomain_codeset($domain, "UTF-8");
	textdomain($domain);

	// Calcul age
	$today = time();
    $secondes = $today - $dateNaissance;
    $age = date('Y', $secondes) - 1970;


    // Affichage skill
    function listSkillsHelper($list, $displayMinor, $displayNumberExperiences) {
		$html = '';
		foreach ($list as $skill) {
			if($skill->isImportant()) {
				$html .= '<a class="tech_' . $skill->getId() .' skill important_skill" onclick="javascript:toggleFilterSkill(' . $skill->getId() . ');">' . $skill->getName();
				if($displayNumberExperiences) {
					$html .= ' (' . $skill->countAllExperiences() . ')';
				}
				$html .='</a>';
			} else if($displayMinor) {
				$html .= '<a class="tech_' . $skill->getId() .' skill" onclick="javascript:toggleFilterSkill(' . $skill->getId() . ');">' . $skill->getName();
				if($displayNumberExperiences) {
					$html .= ' (' . $skill->countAllExperiences() . ')';
				}
				$html .='</a>';
			}
		}

		return $html;
	}

	// Companies
	$selectCompanies = $db->prepare('SELECT co.id AS ID, co.name AS NAME, co.icon AS ICON, co.url AS URL FROM company co');
	$selectCompanies->execute();
	$selectCompaniesResult = $selectCompanies->fetchAll();
	$Companies = array();

	foreach ($selectCompaniesResult as $companyDb) {
		$Companies[$companyDb['ID']] = new Company($companyDb['ID'], $companyDb['NAME'], $companyDb['ICON'], $companyDb['URL']);
	}

	// Major Skills
	$selectMajorSkill = $db->prepare('SELECT mj.id AS ID, mj.name AS NAME, mj.alias AS ALIAS FROM major_skill_type mj');
	$selectMajorSkill->execute();
	$selectMajorSkillResult = $selectMajorSkill->fetchAll();

	$majorSkillTypes = array();
	foreach ($selectMajorSkillResult as $majorSkillDb) {
		$majorSkillTypes[$majorSkillDb['ID']] = new MajorSkillType($majorSkillDb['ID'], $majorSkillDb['NAME'], $majorSkillDb['ALIAS']);
	}

	// Skill types
	$selectSkillType = $db->prepare('SELECT ty.id AS ID, ty.name AS NAME, ty.major_type AS MAJOR_TYPE_ID FROM skill_type ty');
	$selectSkillType->execute();
	$selectSkillTypeResult = $selectSkillType->fetchAll();

	$skillTypes = array();
	foreach ($selectSkillTypeResult as $skillTypeDb) {
		$majorSkill = $majorSkillTypes[$skillTypeDb['MAJOR_TYPE_ID']];
		$skillTypes[$skillTypeDb['ID']] = new SkillType($skillTypeDb['ID'], $skillTypeDb['NAME'], $majorSkill);
		$majorSkill->addSkillType($skillTypes[$skillTypeDb['ID']]);
	}

	// Skills
	$selectSkill = $db->prepare('SELECT sk.id AS ID, sk.name AS NAME, sk.description AS DESCRIPTION, sk.type AS SKILL_TYPE_ID, sk.important AS IMPORTANT FROM skill sk');
	$selectSkill->execute();
	$selectSkillResult = $selectSkill->fetchAll();

	$skills = array();
	foreach ($selectSkillResult as $skillDb) {
		$skillType = $skillTypes[$skillDb['SKILL_TYPE_ID']];
		$skills[$skillDb['ID']] = new Skill($skillDb['ID'], $skillDb['NAME'], $skillDb['DESCRIPTION'], $skillType, $skillDb['IMPORTANT']);
		$skillType->addSkill($skills[$skillDb['ID']]);
	}

	// Experiences
	$selectExperiences = $db->prepare('SELECT ex.id AS ID, ex.title AS TITLE, ex.status AS STATUS, ex.client AS CLIENT_ID, ex.employer AS EMPLOYER_ID, ex.type AS TYPE, ex.location AS LOCATION, ex.short_desc AS SHORT_DESCRIPTION, ex.long_desc AS LONG_DESCRIPTION, ex.beginning AS BEGINNING, ex.end AS END FROM experience ex WHERE ex.lang=\''.$lang.'\'');
	$selectExperiences->execute();
	$selectExperiencesResult = $selectExperiences->fetchAll();

	$experiences = array();
	foreach ($selectExperiencesResult as $experienceDb) {
		$client = $Companies[$experienceDb['CLIENT_ID']];
		$employer = $Companies[$experienceDb['EMPLOYER_ID']];
		$experiences[$experienceDb['ID']] = new Experience($experienceDb['ID'], $experienceDb['TITLE'], $experienceDb['STATUS'], $experienceDb['TYPE'], $experienceDb['LOCATION'], $experienceDb['SHORT_DESCRIPTION'], $experienceDb['LONG_DESCRIPTION'], $client, $employer, $experienceDb['BEGINNING'], $experienceDb['END']);
	}

	// Experiences / Skill
	$selectExperienceSkills = $db->prepare('SELECT sk.id_experience AS ID_EXPERIENCE, sk.id_skill AS ID_SKILL, sk.version AS VERSION FROM experience_skill sk INNER JOIN experience ex ON (sk.id_experience = ex.id) WHERE ex.lang=\''.$lang.'\'');
	$selectExperienceSkills->execute();
	$selectExperienceSkillsResult = $selectExperienceSkills->fetchAll();

	foreach ($selectExperienceSkillsResult as $experienceSkillDb) {
		$skill = $skills[$experienceSkillDb['ID_SKILL']];
		$experience = $experiences[$experienceSkillDb['ID_EXPERIENCE']];
		$experienceSkill = new ExperienceSkill($skill, $experience, $experienceSkillDb['VERSION']);
		$experience->addSkill($experienceSkill);
		$skill->addExperience($experienceSkill);
	}

	// Experiences / goal
	$selectExperienceGoals = $db->prepare('SELECT go.id AS ID, go.id_experience AS ID_EXPERIENCE, go.description AS DESCRIPTION FROM experience_goal go INNER JOIN experience ex ON (go.id_experience = ex.id) WHERE ex.lang=\''.$lang.'\'');
	$selectExperienceGoals->execute();
	$selectExperienceGoalsResult = $selectExperienceGoals->fetchAll();

	foreach ($selectExperienceGoalsResult as $experienceGoalDb) {
		$experience = $experiences[$experienceGoalDb['ID_EXPERIENCE']];
		$experienceGoal = new ExperienceGoal($experienceGoalDb['ID'], $experienceGoalDb['DESCRIPTION'], $experience);
		$experience->addGoal($experienceGoal);
	}

	// Personnal Experiences
	$selectPersonnalExperiences = $db->prepare('SELECT ex.id AS ID, ex.title AS TITLE, ex.html AS HTML, ex.beginning AS BEGINNING, ex.end AS END FROM personnal_experience ex WHERE ex.lang=\''.$lang.'\'');
	$selectPersonnalExperiences->execute();
	$selectPersonnalExperiencesResult = $selectPersonnalExperiences->fetchAll();

	$personnalExperiences = array();
	foreach ($selectPersonnalExperiencesResult as $personnalExperienceDb) {
		$personnalExperiences[$personnalExperienceDb['ID']] = new PersonnalExperience($personnalExperienceDb['ID'], $personnalExperienceDb['TITLE'], $personnalExperienceDb['HTML'],$personnalExperienceDb['BEGINNING'], $personnalExperienceDb['END']);
	}

	// Personnal Experiences / Skill
	$selectPersonnalExperienceSkills = $db->prepare('SELECT sk.id_personnal_experience AS ID_PERSONNAL_EXPERIENCE, sk.id_skill AS ID_SKILL, sk.version AS VERSION FROM personnal_experience_skill sk INNER JOIN personnal_experience ex ON (sk.id_personnal_experience = ex.id) WHERE ex.lang=\''.$lang.'\'');
	$selectPersonnalExperienceSkills->execute();
	$selectPersonnalExperienceSkillsResult = $selectPersonnalExperienceSkills->fetchAll();

	foreach ($selectPersonnalExperienceSkillsResult as $personnalExperienceSkillDb) {
		$skill = $skills[$personnalExperienceSkillDb['ID_SKILL']];
		$personnalExperience = $personnalExperiences[$personnalExperienceSkillDb['ID_PERSONNAL_EXPERIENCE']];
		$personnalExperienceSkill = new PersonnalExperienceSkill($skill, $personnalExperience, $personnalExperienceSkillDb['VERSION']);
		$skill->addPersonnalExperience($personnalExperienceSkill);
		$personnalExperience->addSkill($personnalExperienceSkill);
	}

	// Formations
	$selectFormations = $db->prepare('SELECT fo.id AS ID, fo.name AS NAME, fo.instructor AS INSTRUCTOR, fo.date AS DATE, fo.type AS TYPE FROM formation fo');
	$selectFormations->execute();
	$selectFormationsResult = $selectFormations->fetchAll();

	$formations = array();
	$educations = array();
	foreach ($selectFormationsResult as $formationDb) {
		$formation = new Formation($formationDb['ID'], $formationDb['NAME'], $formationDb['INSTRUCTOR'], $formationDb['DATE'], $formationDb['TYPE']);
		if($formation->getType() == Formation::TYP_FORMATION) {
			$formations[$formationDb['ID']] = $formation;
		} else if($formation->getType() == Formation::TYP_EDUCTION) {
			$educations[$formationDb['ID']] = $formation;
		}
	}
?>
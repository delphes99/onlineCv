<?php
require 'epiphany/Epi.php';
require '../bootstrap.php';

header('Content-Type: application/json; charset=UTF-8');

Epi::init('api');
getApi()->get('/skills.json', 'apiSkills', EpiApi::external);
getApi()->get('/experiences.json', 'apiExperiences', EpiApi::external);
getApi()->get('/companies.json', 'apiCompanies', EpiApi::external);
getRoute()->run();

function apiSkills() {
	global $db;
	$selectSkill = $db->prepare('SELECT sk.id AS ID, sk.name AS NAME, sk.description AS DESCRIPTION, sk.type AS SKILL_TYPE_ID, sk.important AS IMPORTANT FROM skill sk');
	$selectSkill->execute();
	$selectSkillResult = $selectSkill->fetchAll();

	$skills = array();
	foreach ($selectSkillResult as $skillDb) {
		$skills[] = array('id' => $skillDb['ID'],
						  'name' => $skillDb['NAME'],
						  'description' => $skillDb['DESCRIPTION'],
						  'skillType' => $skillDb['SKILL_TYPE_ID'],
						  'important' => $skillDb['IMPORTANT']);
	}
	
	return $skills;
}

function apiExperiences() {
	global $db;
	global $lang;

	// Experiences / Skill
	$selectExperienceSkills = $db->prepare('SELECT sk.id_experience AS ID_EXPERIENCE, sk.id_skill AS ID_SKILL, sk.version AS VERSION FROM experience_skill sk INNER JOIN experience ex ON (sk.id_experience = ex.id) WHERE ex.lang=\''.$lang.'\'');
	$selectExperienceSkills->execute();
	$selectExperienceSkillsResult = $selectExperienceSkills->fetchAll();

	$experiences_skills = array();
	foreach ($selectExperienceSkillsResult as $experienceSkillDb) {
		$experiences_skills[$experienceSkillDb['ID_EXPERIENCE']][] = array('skillId' => $experienceSkillDb['ID_SKILL'],
																			 'version' => $experienceSkillDb['VERSION']);
	}

	// Experiences
	$selectExperiences = $db->prepare('SELECT ex.id AS ID, ex.title AS TITLE, ex.status AS STATUS, ex.client AS CLIENT_ID, ex.employer AS EMPLOYER_ID, ex.type AS TYPE, ex.location AS LOCATION, ex.short_desc AS SHORT_DESCRIPTION, ex.long_desc AS LONG_DESCRIPTION, ex.beginning AS BEGINNING, ex.end AS END FROM experience ex WHERE ex.lang=\''.$lang.'\'');
	$selectExperiences->execute();
	$selectExperiencesResult = $selectExperiences->fetchAll();

	$experiences = array();
	foreach ($selectExperiencesResult as $experienceDb) {
		$experiences[$experienceDb['ID']] = array('id' => $experienceDb['ID'],
												  'title' => $experienceDb['TITLE'],
												  'status' => $experienceDb['STATUS'],
												  'type' => $experienceDb['TYPE'],
												  'location' => $experienceDb['LOCATION'],
												  'short_description' => $experienceDb['SHORT_DESCRIPTION'],
												  'description' => $experienceDb['LONG_DESCRIPTION'],
												  'clientId' => $experienceDb['CLIENT_ID'],
												  'employerId' => $experienceDb['EMPLOYER_ID'],
												  'beginning' => $experienceDb['BEGINNING'],
												  'end' => $experienceDb['END'],
												  'skills' => $experiences_skills[$experienceDb['ID']]);
	}

	return $experiences;
}

function apiCompanies() {
	global $db;
	$selectCompanies = $db->prepare('SELECT co.id AS ID, co.name AS NAME, co.icon AS ICON, co.url AS URL FROM company co');
	$selectCompanies->execute();
	$selectCompaniesResult = $selectCompanies->fetchAll();

	$companies = array();
	foreach ($selectCompaniesResult as $companyDb) {
		$companies[] = array('id' => $companyDb['ID'],
							  'name' => $companyDb['NAME'],
							  'icon' => $companyDb['ICON'],
							  'url' => $companyDb['URL']);
	}
	
	return $companies;
}
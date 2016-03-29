<?php
   // Fonctions
   require 'bootstrap.php';
   
	// Header HTTP
	header("Content-Type: text/html; charset=utf8");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html>
   <head>
      <title><?php echo _('headTitle'); ?></title>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <script type="text/javascript" src="js/jquery-1.6.4.js"></script>
      <script type="text/javascript" src="js/jquery.inherit-1.3.2.js"></script>
      <script type="text/javascript" src="js/jquery.bpopup.min.js"></script>
      <script type="text/javascript" src="js/jquery.qtip.min.js"></script>
      <script type="text/javascript" src="js/cv.js"></script>
      
      <link rel="stylesheet" type="text/css" media="screen" href="css/base.css" />
      <link rel="stylesheet" type="text/css" media="screen" href="css/jquery.qtip.min.css" />
      <link id="switchCss" rel="stylesheet" type="text/css" media="screen" />
   </head>
   <body>
      <div id="menu_bar">
         <img id="hamburger" src="img/hamburger.png">
         <hgroup>
            <h1><?php echo _('prenom') ?> <?php echo _('nom'); ?></h1>
            <h2><?php echo _('titrePoste'); ?></h2>
         </hgroup>
      </div>
         
      <div id="nav_filters">
         <input class="button" id="activateFilter" type="button" value="<?php echo _('activateFilter'); ?>" />
         <div id="listFilters">
            <div id="tabFilter">
            </div>
         </div>
      </div>
      <nav>
         <div id="navigation">
            <div id="nav_content">
               <div id="nav_direct_access">
                  <ul>
                     <li><a href="#skills"><?php echo _('skillsTitle'); ?></a></li>
                     <li><a href="#experience"><?php echo _('experienceTitle'); ?></a></li>
                     <li><a href="#personalExperience"><?php echo _('personalExperienceTitle'); ?></a></li>
                     <li><a href="#formation"><?php echo _('formationTitle'); ?></a></li>
                     <li><a href="#other"><?php echo _('otherTitle'); ?></a></li>
                  </ul>
               </div>
               <div id="lang">
                  <h4><?php echo _('lang'); ?></h4>
                  <ul>
                     <li><a href="index.php?lang=fr"><?php echo _('langFr'); ?></a></li>
                     <li><a href="index.php?lang=en"><?php echo _('langEn'); ?></a></li>
                  </ul>
               </div>
               <div id="nav_styles">
                  <h4><?php echo _('style'); ?></h4>
                  <a id="selectColor1" class="selectColor" href="javascript:switchStyle('green');"></a>
                  <a id="selectColor2" class="selectColor" href="javascript:switchStyle('blue');"></a>
                  <a id="selectColor3" class="selectColor" href="javascript:switchStyle('grey');"></a>
                  <a id="selectColor4" class="selectColor" href="javascript:switchStyle('amber');"></a>
                  <a id="selectColor5" class="selectColor" href="javascript:switchStyle('pink');"></a>
               </div>
               <div>
                  <h4><?php echo _('style'); ?></h4>
                  <ul>
                     <li><a href="archives/index.htm"><?php echo _('archives'); ?></a></li>
                  </ul>
               </div>
            </div>
         </div>
      </nav>
      <div id="container">
         <div id="header">
            <div class="header_item"><label for="age"><?php echo _('ageLabel'); ?>
               </label>
               <div id="age"><?php echo $age; ?></div>
            </div>
            <div class="header_item">
               <label for="mail"><?php echo _('mailLabel'); ?></label>
               <div id="mail"><a href="mailto:<?php echo _('mail'); ?>"><?php echo _('mail'); ?></a></div>
            </div>
            <div class="header_item">
               <label for="city"><?php echo _('ville'); ?></label>
               <div id="city"><?php echo $ville; ?></div>
            </div>
            <div class="header_item">
               <a id="viadeo_ico" class="ico" href="<?php echo $urlViadeo; ?>"><img src="img/viadeo.png" title="<?php echo _('viadeoIco'); ?>" alt="<?php echo _('viadeoIco'); ?>" /></a>
               <a id="linkedin_ico" class="ico" href="<?php echo $urlLinkedIn; ?>"><img src="img/linkedin.png" title="<?php echo _('linkedinIco'); ?>" alt="<?php echo _('linkedinIco'); ?>" /></a>
               <a id="twitter_ico" class="ico" href="<?php echo $urlTwitter; ?>"><img src="img/twitter.png" title="<?php echo _('twitterIco'); ?>" alt="<?php echo _('twitterIco'); ?>" /></a>
               <a id="pdf_ico" class="ico" href="<?php echo $urlCvPdf; ?>"><img src="img/pdf.png" title="<?php echo _('pdfIco'); ?>" alt="<?php echo _('pdfIco'); ?>" /></a>
            </div>
         </div>
         <div id="description">
            <?php echo _('generalDescription'); ?>
         </div>
         <div id="main">
            <div id="main_content">
               <div id="skills" class="main_section">
                  <h2><?php echo _('skillsTitle'); ?></h2>
                  <div class="main_content_item">
                     <?php foreach ($majorSkillTypes as $majorSkill) : ?>
                        <div class="main_content_item_title">
                           <h3><?php echo $majorSkill->getName(); ?></h3>
                        </div>
                        <div class="main_content_item_content" id="<?php echo $majorSkill->getAlias(); ?>_desc">
                           <table class="table_skill">
                              <?php foreach($majorSkill->getSkillTypes() as $skillType) : ?>
                                 <tr>
                                    <th><?php echo $skillType->getName(); ?></th>
                                    <td><?php echo listSkillsHelper($skillType->getSkills(), true, true); ?></td>
                                 </tr>
                              <?php endforeach; ?>
                           </table>
                        </div>
                        <div class="main_content_item_footer"/>
                     <?php endforeach; ?>
                  </div>
               </div>
               <div id="experience" class="main_section">
                  <h2><?php echo _('experienceTitle'); ?></h2>
                  <?php foreach($experiences as $experience) : ?>
                  <div class="main_content_item" id="experience_<?php echo $experience->getId(); ?>">
                     <div class="main_content_item_title">
                        <h3><?php echo $experience->getTitle(); ?></h3>
                        <div class= "main_content_item_title_period" id="period_<?php echo $experience->getId(); ?>"><?php echo $experience->getBeginning()->format('M y'); ?> - <?php echo $experience->getEnd()->format('M y'); ?> (<?php echo $experience->getDuration(); ?> <?php echo _('month'); ?>)</div>
                        <div class="main_content_item_title_footer"></div>
                     </div>
                     <div class="main_content_item_content">
                        <div class="main_content_item_informations">
                           <div class="client mission_detail">
                              <label for="client_<?php echo $experience->getId(); ?>">Client : </label>
                              <div id="client_<?php echo $experience->getId(); ?>">
                                 <?php if($experience->getClient()->getUrl() != null) { ?><a href="<?php echo $experience->getClient()->getUrl(); ?>" ><?php } ?>
                                 <?php if($experience->getClient()->getIcon() != null) { ?>
                                 <img class="company_<?php echo $experience->getClient()->getId(); ?>" src="img/company/<?php echo $experience->getClient()->getIcon(); ?>" />
                                 <?php } else { echo $experience->getClient()->getName(); }?>
                                 <?php if($experience->getClient()->getUrl() != null) { ?></a><?php } ?>
                              </div>
                           </div>
                           <div class="firm mission_detail">
                              <label for="firm_<?php echo $experience->getId(); ?>">Employeur : </label>
                              <div id="firm_<?php echo $experience->getId(); ?>">
                                 <?php if($experience->getEmployer()->getUrl() != null) { ?><a href="<?php echo $experience->getEmployer()->getUrl(); ?>" ><?php } ?>
                                 <?php if($experience->getEmployer()->getIcon() != null) { ?>
                                 <img class="company_<?php echo $experience->getEmployer()->getId(); ?>" src="img/company/<?php echo $experience->getEmployer()->getIcon(); ?>" />
                                 <?php } else { echo $experience->getEmployer()->getName(); }?>
                                 <?php if($experience->getEmployer()->getUrl() != null) { ?></a><?php } ?>
                              </div>
                           </div>
                           <div class="job_type mission_detail">
                              <label for="job_type_<?php echo $experience->getId(); ?>">Type : </label>
                              <div id="job_type_<?php echo $experience->getId(); ?>">
                                 <?php echo $experience->getType(); ?>
                              </div>
                           </div>
                           <div class="job_place mission_detail">
                              <label for="job_place_<?php echo $experience->getId(); ?>">Lieu : </label>
                              <div id="job_place_<?php echo $experience->getId(); ?>">
                                 <?php echo $experience->getLocation(); ?>
                              </div>
                           </div>
                           <div class="mission_detail_footer"></div>
                        </div>
                        <p class="experience_description">
                           <?php echo $experience->getShortDescription(); ?>
                        </p>
                        <div class="goals">
                           <ul>
                              <?php foreach($experience->getGoals() as $goal) : ?>
                              <li><?php echo $goal->getDescription(); ?></li>
                              <?php endforeach; // Goals ?>
                           </ul>
                        </div>
                        <?php if(count($experience->getSkills()) > 0) : ?>
                        <div class="environnement">
                           <div id="subpreview_<?php echo $experience->getId(); ?>" class="preview">
                              <?php echo listSkillsHelper($experience->getSkills(), true, false); ?>
                           </div>
                        </div>
                        <?php endif; ?>
                     </div>
                     <div class="main_content_item_footer">
                        <input type="button" class="show_experience button" onclick="javascript:viewDetailExperience(<?php echo $experience->getId(); ?>);" id="expander_experience_<?php echo $experience->getId(); ?>" value="<?php echo _('viewDetail'); ?>" />
                     </div>
                  </div>
                  <div id="experienceDetails_<?php echo $experience->getId(); ?>" class="experienceDetails">
                     <h1><?php echo $experience->getTitle(); ?></h1>
                     <div class="client mission_detail">
                        <label for="client_<?php echo $experience->getId(); ?>"><?php echo _('jobClient'); ?> : </label>
                        <div id="client_<?php echo $experience->getId(); ?>">
                           <?php if($experience->getClient()->getUrl() != null) { ?><a href="<?php echo $experience->getClient()->getUrl(); ?>" ><?php } ?>
                           <?php echo $experience->getClient()->getName();?>
                           <?php if($experience->getClient()->getUrl() != null) { ?></a><?php } ?>
                           <?php if($experience->getClient()->getIcon() != null) { ?>
                           <img class="company_<?php echo $experience->getClient()->getId(); ?>" src="img/company/<?php echo $experience->getClient()->getIcon(); ?>" />
                           <?php } ?>
                        </div>
                     </div>
                     <div class="firm mission_detail">
                        <label for="firm_<?php echo $experience->getId(); ?>"><?php echo _('jobEmployer'); ?> : </label>
                        <div id="firm_<?php echo $experience->getId(); ?>">
                           <?php if($experience->getEmployer()->getUrl() != null) { ?><a href="<?php echo $experience->getEmployer()->getUrl(); ?>" ><?php } ?>
                           <?php echo $experience->getEmployer()->getName();?>
                           <?php if($experience->getEmployer()->getUrl() != null) { ?></a><?php } ?>
                           <?php if($experience->getEmployer()->getIcon() != null) { ?>
                           <img class="company_<?php echo $experience->getEmployer()->getId(); ?>" src="img/company/<?php echo $experience->getEmployer()->getIcon(); ?>" title="<?php echo $experience->getEmployer()->getName(); ?>"/>
                           <?php } ?>
                        </div>
                     </div>
                     <div class="job_type mission_detail">
                        <label for="job_type_<?php echo $experience->getId(); ?>"><?php echo _('jobType'); ?> : </label>
                        <div id="job_type_<?php echo $experience->getId(); ?>">
                           <?php echo $experience->getType(); ?>
                        </div>
                     </div>
                     <div class="job_place mission_detail">
                        <label for="job_place_<?php echo $experience->getId(); ?>"><?php echo _('jobPlace'); ?> : </label>
                        <div id="job_place_<?php echo $experience->getId(); ?>">
                           <?php echo $experience->getLocation(); ?>
                        </div>
                     </div>
                     <div class="job_status mission_detail">
                        <label for="job_status_<?php echo $experience->getId(); ?>"><?php echo _('jobStatus'); ?> : </label>
                        <div id="job_status_<?php echo $experience->getId(); ?>">
                           <?php echo $experience->getStatus(); ?>
                        </div>
                     </div>
                     <div class="mission_detail_footer"></div>
                     <div class="experienceDetailsContent" >
                        <p class="experience_description">
                           <?php echo $experience->getLongDescription(); ?>
                        </p>
                        <div class="goals">
                           <ul>
                              <?php foreach($experience->getGoals() as $goal) : ?>
                              <li><?php echo $goal->getDescription(); ?></li>
                              <?php endforeach; // Goals ?>
                           </ul>
                        </div>
                        <div id="subexpand_<?php echo $experience->getId(); ?>" >
                           <?php foreach ($majorSkillTypes as $majorSkill) : 
                              $listSkill = $experience->getSkillByMajorTypeSkill($majorSkill);
                                 if(sizeof($listSkill) > 0) :?>
                           <div>
                              <img class="<?php echo $majorSkill->getAlias(); ?>Icon" />
                              <h2><?php echo $majorSkill->getName(); ?></h2>
                              <?php echo listSkillsHelper($listSkill, true, false); ?>
                           </div>
                           <?php endif; ?>
                           <?php endforeach; // Major skill type ?>
                        </div>
                     </div>
                  </div>
                  <?php endforeach; // Experiences ?>
               </div>
               <div id="personalExperience" class="main_section">
                  <h2><?php echo _('personalExperienceTitle'); ?></h2>
                  <?php foreach($personnalExperiences as $experience) : ?>
                  <div class="main_content_item" id="experience_p_<?php echo $experience->getId(); ?>">
                     <div class="main_content_item_title">
                        <h3><?php echo $experience->getTitle(); ?></h3>
                        <div class= "main_content_item_title_period" id="period_p_<?php echo $experience->getId(); ?>"><?php echo $experience->getBeginning()->format('M y'); ?> - <?php echo $experience->getEnd()->format('M y'); ?> (<?php echo $experience->getDuration(); ?> <?php echo _('month'); ?>)</div>
                        <div class="main_content_item_title_footer"></div>
                     </div>
                     <div class="main_content_item_content">
                        <p class="experience_description">
                           <?php echo $experience->getHTML(); ?>
                        </p>
                        <?php if(count($experience->getSkills()) > 0) : ?>
                        <div class="environnement">
                           <div id="subpreview_p_<?php echo $experience->getId(); ?>" class="preview">
                              <?php echo listSkillsHelper($experience->getSkills(), true, false); ?>
                           </div>
                        </div>
                        <?php endif; ?>
                     </div>
                     <div class="main_content_item_footer">
                     </div>
                  </div>
                  <?php endforeach; // PersonnalExperiences ?>
               </div>
               <div id="formation" class="main_section">
                  <h2><?php echo _('formationTitle'); ?></h2>
                  <div class="main_content_item">
                     <div class="main_content_item_title">
                        <h3><?php echo _('formationSubtitle'); ?></h3>
                     </div>
                     <div class="main_content_item_content">
                        <?php foreach($formations as $formation) : ?>
                        <h4><?php echo $formation->getName(); ?></h4>
                        <div class="instructor"><?php echo $formation->getYear(); ?> : <?php echo $formation->getInstructor(); ?></div>
                        <?php endforeach; // Formations ?>
                     </div>
                     <div class="main_content_item_footer">
                     </div>
                  </div>
                  <div class="main_content_item">
                     <div class="main_content_item_title">
                        <h3><?php echo _('educationSubtitle'); ?></h3>
                     </div>
                     <div class="main_content_item_content">
                        <?php foreach($educations as $education) : ?>
                        <h4><?php echo $education->getName(); ?></h4>
                        <div class="instructor"><?php echo $education->getYear(); ?> : <?php echo $education->getInstructor(); ?></div>
                        <?php endforeach; // Education ?>
                     </div>
                     <div class="main_content_item_footer">
                     </div>
                  </div>
               </div>
               <div id="other" class="main_section">
                  <h2><?php echo _('otherTitle'); ?></h2>
                  <div class="main_content_item">
                     <div class="main_content_item_title">
                        <h1><?php echo _('languageSubtitle'); ?></h1>
                     </div>
                     <div class="main_content_item_content">
                        <h3>Français</h3>
                        <div class="infos">Langue maternelle</div>
                        <h3>Anglais</h3>
                        <div class="infos">Moyen (TOEIC : 905)</div>
                     </div>
                     <div class="main_content_item_footer">
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div id="footer">
         <div id="footer_nav">
            <a href="#header"><?php echo _('toTop'); ?></a>
         </div>
         <div id="footer_content">
            <div id="footer_content_top">
            </div>
         </div>
      </div>
      <hr>
      <div id="disclaimer">
         <?php echo _('disclaimer'); ?>
      </div>
      <script text="text/javascript">
         var txtActivateFilter = '<?php echo _('activateFilter'); ?>';
         var txtDesactivateFilter = '<?php echo _('desactivateFilter'); ?>';

         function loadFilter() {
			$.ajax({
				url: "api/skills.json",
				async: false
			}).then(function(data) {
				$.each(data, function(i, skill) {
					filter.addSkill(new SkillC(skill.id, skill.name, skill.important));
					if(skill.description != null) {
						addToolTips('.tech_' + skill.id, skill.description);
					}
				});
			});
				
			$.ajax({
				url: "api/experiences.json",
				async: false
			}).then(function(data) {
				$.each(data, function(i, experience) {
					exp = new ExperienceC(experience.id, experience.title);
					
					$.each(experience.skills, function(j, skill) {
						exp.addSkill(filter.getSkill(skill.skillId));
					});
					
					filter.addExperience(exp);
				});
			});
			
			$.ajax({
				url: "api/companies.json",
				async: false
			}).then(function(data) {
				$.each(data, function(i, company) {
					addToolTipsCompany('.company_' + company.id, company.name);
				});
			});
         }

         // Tooltips
         addToolTips('#viadeo_ico', '<?php echo _('viadeoIco'); ?>');
         addToolTips('#linkedin_ico', '<?php echo _('linkedinIco'); ?>');
         addToolTips('#pdf_ico', '<?php echo _('pdfIco'); ?>');
         addToolTips('#twitter_ico', '<?php echo _('twitterIco'); ?>');
   
         // Hide long descriptions
         $(".expand").hide('slow');
         $("#nav_filters").hide();
      </script>
   </body>
</html>
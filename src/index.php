<?php
   // Base de données
   require 'const.php';

   // Fonctions
   require 'bootstrap.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html>
   <head>
      <title><?php echo _('headTitle'); ?></title>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <script type="text/javascript" src="js/jquery-1.6.4.js"></script>
      <script type="text/javascript" src="js/jquery.inherit-1.3.2.js"></script>
      <script type="text/javascript" src="js/jquery-1.6.4.js"></script>
      <script type="text/javascript" src="js/jquery.inherit-1.3.2.js"></script>
      <script type="text/javascript" src="js/jquery.bpopup.min.js"></script>
      <script type="text/javascript" src="js/jquery.qtip.min.js"></script>
      <script type="text/javascript" src="js/cv.js"></script>
       
      <link id="switchCss" rel="stylesheet" type="text/css" media="screen" />
      <link rel="stylesheet" type="text/css" media="screen" href="css/jquery.qtip.min.css" />
       
      <script type="text/javascript">
         var baseUrl = '.';
      </script>
   </head>
   <body>
      <div id="menu_bar">
         <img id="hamburger" src="img/hamburger.png">
         <h1><?php echo _('prenom') ?> <?php echo _('nom'); ?></h1>
         <h2><?php echo _('titrePoste'); ?></h2>
      </div>
      <div id="navigation">
         <div id="nav_content">
            <div id="nav_direct_access">
               <ul>
                  <li><a href="#skills"><?php echo _('skillsTitle'); ?></a></li>
                  <li><a href="#experience"><?php echo _('experienceTitle'); ?></a></li>
                  <li><a href="#formation"><?php echo _('formationTitle'); ?></a></li>
                  <li><a href="#other"><?php echo _('otherTitle'); ?></a></li>
               </ul>
            </div>
            <div id="nav_filters">
               <h4><?php echo _('Filtres'); ?></h4>
               <input id="activateFilter" type="checkbox" ><label for="activateFilter" ><?php echo _('Activer les filtres'); ?></label>
               <div id="listFilters">
                  <hr/>
                  <table id="tabFilter">
                  </table>
                  <img id="removeAllFilterSkill" class="reload" /><?php echo _('Supprimer tous les filtres'); ?>
               </div>
               <div id="listExceptions">
                  <hr/>
                  <h4><?php echo _('Exception'); ?></h4>
                  <table id="tabException">
                  </table>
                  <img id="removeAllFilterExperience" class="reload" /> Réinitialiser
               </div>
            </div>
            <div id="nav_styles">
               <h4>Style</h4>
               <a href="javascript:switchStyle('black');">Noir</a>
               <a href="javascript:switchStyle('white');">Blanc</a>
            </div>
         </div>
      </div>
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
               <a id="viadeo_ico" href="<?php echo $urlViadeo; ?>"><img src="img/viadeo.png" title="Viadeo" alt="Viadeo" /></a>
               <a id="linkedin_ico" href="<?php echo $urlLinkedIn; ?>"><img src="img/linkedin.png" title="LinkedIn" alt="LinkedIn" /></a>
               <a id="pdf_ico" href="<?php echo $urlCvPdf; ?>"><img src="img/pdf.png" title="<?php echo _('pdfFormatLabel'); ?>" alt="<?php echo _('pdfFormatLabel'); ?>" /></a>
            </div>
         </div>
         <div id="description">
            <?php echo _('generalDescription'); ?>
         </div>
         <div id="main">
            <div id="main_content">
               <div id="skills" class="main_section">
                  <h1><?php echo _('skillsTitle'); ?></h1>
                  <div class="main_content_item">
                     <?php foreach ($majorSkillTypes as $majorSkill) : ?>
                        <div class="main_content_item_title">
                           <h1><?php echo $majorSkill->getName(); ?></h1>
                        </div>
                        <div class="main_content_item_content" id="<?php echo $majorSkill->getAlias(); ?>_desc">
                           <table>
                              <?php foreach($majorSkill->getSkillTypes() as $skillType) : ?>
                                 <tr>
                                    <th><?php echo $skillType->getName(); ?></th>
                                    <td><?php echo listSkillsHelper($skillType->getSkills(), true); ?></td>
                                 </tr>
                              <?php endforeach; ?>
                           </table>
                        </div>
                        <div class="main_content_item_footer"/>
                     <?php endforeach; ?>
                  </div>
               </div>
               <div id="experience" class="main_section">
               	<h1><?php echo _('experienceTitle'); ?></h1>
                  <?php foreach($experiences as $experience) : ?>
                  <hr/>
                  <div class="main_content_item" id="experience_<?php echo $experience->getId(); ?>">
                     <div class="main_content_item_title">
                        <h1><?php echo $experience->getTitle(); ?></h1>
                     <div class="main_content_item_function"><?php echo $experience->getStatus(); ?></div>
                     <div class="main_content_item_title_footer"></div>
                  </div>
                  <div class="main_content_item_informations">
                     <div class="client mission_detail">
                        <label for="client_<?php echo $experience->getId(); ?>">Client : </label>
                        <div id="client_<?php echo $experience->getId(); ?>"><?php echo $experience->getClient()->getName(); ?></div>
                     </div>
                     <div class="firm mission_detail">
                        <label for="firm_<?php echo $experience->getId(); ?>">Employeur : </label><div id="firm_<?php echo $experience->getId(); ?>"><?php echo $experience->getEmployer()->getName(); ?></div>
                     </div>
                        <div class="job_type mission_detail">
                           <label for="job_type_<?php echo $experience->getId(); ?>">Type : </label><div id="job_type_<?php echo $experience->getId(); ?>"><?php echo $experience->getType(); ?></div>
                        </div>
                        <div class="job_place mission_detail">
                           <label for="job_place_<?php echo $experience->getId(); ?>">Lieu : </label><div id="job_place_<?php echo $experience->getId(); ?>"><?php echo $experience->getLocation(); ?></div>
                        </div>
                        <div class="period mission_detail">
                           <div id="period_<?php echo $experience->getId(); ?>"><?php echo $experience->getBeginning()->format('M y'); ?> - <?php echo $experience->getEnd()->format('M y'); ?> (<?php echo $experience->getDuration(); ?> <?php echo _('month'); ?>)</div>
                        </div>
                  </div>
                  <div class="main_content_item_content">
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
                     <?php if(count($experience->getSkills()) > 0) : ?>
                     <a class="subExperience_maximize" href="javascript:displaySubExperience(<?php echo $experience->getId(); ?>);" id="subexpander_<?php echo $experience->getId(); ?>">-</a>
                     <div class="environnement">
                        <div id="subpreview_<?php echo $experience->getId(); ?>" class="preview">
                           <?php echo listSkillsHelper($experience->getSkills(), false); ?>
                        </div>
                     </div>
                     <?php endif; ?>
                  </div>
                  <div class="main_content_item_footer">
                     <a class="experience_minimize" href="javascript:viewDetailExperience(<?php echo $experience->getId(); ?>);" id="expander_experience_<?php echo $experience->getId(); ?>"><?php echo _('viewDetail'); ?></a>
                  </div>
               </div>
               <div id="experienceDetails_<?php echo $experience->getId(); ?>" class="experienceDetail">
                  <h1><?php echo $experience->getTitle(); ?></h1>
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
                     <?php foreach ($majorSkillTypes as $majorSkill) : ?>
                     <div>
                        <img class="<?php echo $majorSkill->getAlias(); ?>Icon" />
                        <h2><?php echo $majorSkill->getName(); ?></h2>
                        <?php echo listSkillsHelper($experience->getSkills($majorSkill), true); ?>
                     </div>
                     <?php endforeach; // Major skill type ?>
                  </div>
               </div>
               <?php endforeach; // Experiences ?>
               </div>
               <div id="formation" class="main_section">
                  <h1><?php echo _('formationTitle'); ?></h1>
                  <div class="main_content_item">
                     <div class="main_content_item_title">
                        <h1><?php echo _('formationSubtitle'); ?></h1>
                     </div>
                     <div class="main_content_item_content">
                        <?php foreach($formations as $formation) : ?>
                        <h3><?php echo $formation->getYear(); ?> : <?php echo $formation->getName(); ?></h3>
                        <div class="instructor"><?php echo $formation->getInstructor(); ?></div>
                        <?php endforeach; // Formations ?>
                     </div>
                     <div class="main_content_item_footer">
                     </div>
                  </div>
                  <div class="main_content_item">
                     <div class="main_content_item_title">
                        <h1><?php echo _('educationSubtitle'); ?></h1>
                     </div>
                     <div class="main_content_item_content">
                        <?php foreach($educations as $education) : ?>
                        <h3><?php echo $education->getYear(); ?> : <?php echo $education->getName(); ?></h3>
                        <div class="instructor"><?php echo $education->getInstructor(); ?></div>
                        <?php endforeach; // Education ?>
                     </div>
                     <div class="main_content_item_footer">
                     </div>
                  </div>
               </div>
               <div id="other" class="main_section">
                  <h1><?php echo _('otherTitle'); ?></h1>
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
      <script text="text/javascript">
      function loadFilter() {
<?php foreach($skills as $skill) : ?>
         filter.addSkill(new SkillC(<?php echo $skill->getId(); ?>, '<?php echo $skill->getName(); ?>', '<?php echo $skill->getSkillType()->getMajorSkillType()->getAlias(); ?>Icon'));
<?php if ($skill->getDescription() != null && $skill->getDescription() != "") : ?>
         addToolTips(".tech_<?php echo $skill->getId(); ?>", '<?php echo addslashes($skill->getDescription()); ?>');
<?php endif; ?>
<?php endforeach; // Technologies ?>
         var exp;
<?php foreach($experiences as $experience) : ?>
         exp = new ExperienceC(<?php echo $experience->getId(); ?>, '<?php echo $experience->getTitle(); ?>');
<?php foreach($experience->getSkills() as $skill) : ?>
         exp.addSkill(filter.getSkill(<?php echo $skill->getId(); ?>));
<?php endforeach; // Skills ?>
         filter.addExperience(exp);
<?php endforeach; // Experiences ?>
      }

         // Tooltips
         addToolTips("#viadeo_ico", '<?php echo _('viadeoIco'); ?>');
         addToolTips("#linkedin_ico", '<?php echo _('linkedinIco'); ?>');
         addToolTips("#pdf_ico", '<?php echo _('pdfIco'); ?>');
   
         // Hide long descriptions
         $(".expand").hide('slow');
<?php foreach ($majorSkillTypes as $majorSkill) : ?>
         hideSkills('<?php echo $majorSkill->getAlias(); ?>');
<?php endforeach; // Major skill type ?>
      </script>
   </body>
</html>
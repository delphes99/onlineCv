<?php
class Skill {
  private $id;
  private $name;
  private $description;
  private $skillType;
  private $important;
  private $experiences;
  private $personnalExperiences;

  /*
   * Constructor
   */
  public function __construct($id, $name, $description, $skillType, $important) {
    $this->id = $id;
    $this->name = $name;
    $this->description = $description;
    $this->skillType = $skillType;
    $this->important = $important;
	
    $this->experiences = array();
    $this->personnalExperiences = array();
  }

   /**
    * Return the id
    * @return String
    */
   public function getId() {
      return $this->id;
   }
   
   /**
    * Return the name
    * @return String
    */
   public function getName() {
      return $this->name;
   }
      
   /**
    * Return the description
    * @return String
    */
   public function getDescription() {
      return $this->description;
   }
   
   /**
    * Return the skill type
    * @return Model_SkillType
    */
   public function getSkillType() {
      return $this->skillType;
   }
   
   /**
    * Return if the skill is important
    * @return boolean
    */
   public function isImportant() {
      return $this->important;
   }
   
   /**
    * Return all experiences attached
    * @return Model_ExperienceSkill
    */
   public function getExperiences() {
      return $this->experiences;
   }

   /**
    * Add an experience
    * @param Model_ExperienceSkill $experience
    */
   public function addExperience($experience) {
      $this->experiences[] = $experience;
   }
   
   /**
    * Return the number of experiences
    * @return int
    */
   public function countExperiences() {
      return count($this->experiences);
   }
   
   /**
    * Return all personnal experiences attached
    * @return Model_PersonnalExperienceSkill
    */
   public function getPersonnalExperiences() {
      return $this->personnalExperiences;
   }

   /**
    * Add an personnal experience
    * @param Model_PersonnalExperienceSkill $experience
    */
   public function addPersonnalExperience($experience) {
      $this->personnalExperiences[] = $experience;
   }
   
   /**
    * Return the number of personnal experiences
    * @return int
    */
   public function countPersonnalExperiences() {
      return count($this->personnalExperiences);
   }
   
   /**
    * Return the number of all experiences attached
    * @return int
    */
   public function countAllExperiences() {
      return $this->countExperiences() + $this->countPersonnalExperiences();
   }
}

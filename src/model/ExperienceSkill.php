<?php
class Model_ExperienceSkill {
  private $skill;
  private $experience;
  private $version;

  /*
   * Constructor
   */
  public function __construct($skill, $experience, $version) {
    $this->skill = $skill;
    $this->experience = $experience;
    $this->version = $version;
  }

   /**
    * Return the version
    * @return String
    */
   public function getVersion() {
      return $this->version;
   }
   
   /**
    * Return the experience
    * @return Model_Experience
    */
   public function getExperience() {
      return $this->experience;
   }
   
   /**
    * Return the experience
    * @return Model_Skill
    */
   public function getSkill() {
    return $this->skill;
   }
   
   /**
    * @see Model_Experience
    */
   public function getName() {
      return $this->getSkill()->getName();
   }
   
   /**
    * @see Model_Experience
    */
   public function getDescription() {
      return $this->getSkill()->getDescription();
   }
   
   /**
    * @see Model_Experience
    */
   public function getId() {
      return $this->getSkill()->getId();
   }
   
   /**
    * @see Model_Experience
    */
   public function isImportant() {
      return $this->getSkill()->isImportant();
   }
}

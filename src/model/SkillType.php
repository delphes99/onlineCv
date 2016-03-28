<?php
class Model_SkillType {   
  private $id;
  private $name;
  private $skills;
  private $majorSkillType;

  /*
   * Constructor
   */
  public function __construct($id, $name, $majorSkillType) {
      $this->id = $id;
      $this->name = $name;
      $this->majorSkillType = $majorSkillType;

      $this->skills = array();
  }

   /**
   * Return the technical id
   * @return number
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
    * Return all skills
    * @return Zend_Db_Table_Rowset_Abstract
    */
   public function getSkills() {
      return $this->skills;
   }

   /**
    * Add skill
    */
   public function addSkill($skill) {
      $this->skills[] = $skill;
   }
   
   /**
   * Return the major type
   * @return number
   */
   public function getMajorSkillType() {
      return $this->majorSkillType;
   }
}

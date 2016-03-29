<?php
class MajorSkillType {
  private $id;
  private $name;
  private $alias;
  private $skillType;

  /*
   * Constructor
   */
  public function __construct($id, $name, $alias) {
    $this->id = $id;
    $this->name = $name;
    $this->alias = $alias;
    $this->skillType = array();
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
    * Return the alias
    * @return String
    */
   public function getAlias() {
      return $this->alias;
   }

   /**
    * Add skill type
    */
   public function addSkillType($skillType) {
      $this->skillType[] = $skillType;
   }

   /**
    * Return the list of skill
    * @return Model_SkillType[]
    */
   public function getSkillTypes() {
      return $this->skillType;
   }

   /**
    * Return the list of skill
    * @return Model_Skill[]
    */
   public function getSkills() {
      $skills = array();
      foreach ($this->skillType as $skillType) {
        $skills = array_merge($skills, $skillType->getSkills());
      }
      return $skills;
   }
}

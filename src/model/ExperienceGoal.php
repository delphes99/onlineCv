<?php
class Model_ExperienceGoal {
  private $id;
  private $description;
  private $skillType;

  /*
   * Constructor
   */
  public function __construct($id, $description, $experience) {
    $this->id = $id;
    $this->description = $description;
    $this->experience = $experience;
  }
   /**
   * Return the technical id
   * @return number
   */
   public function getId() {
      return $this->id;
   }
   
   /**
   * Return the description
   * @return String
   */
   public function getDescription() {
      return $this->description;
   }
   
   /**
    * Return the experience
    * @return Model_Experience
    */
   public function getExperience() {
      return $this->experience;
   }
}

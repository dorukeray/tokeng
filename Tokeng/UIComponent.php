<?php
  namespace Tokeng;

  use Tokeng\Seeder;

  /**
   * Class UIComponent.
   * a basic Lucid-like server-side rendered component
   */
  class UIComponent
  {
    protected array $_data = array();
    protected string $_templateString = "";

    public function __construct(array $data = array(), string $templateString = "") {
      $this->_data = $data;
      $this->_templateString = $templateString;
    }

    /**
     * Will return a data-seeded view string of the component
     */
    public function render()
    {
      # will replace all placeholders using Seeder 
      return Seeder::seed($this->_templateString, $this->_data);
    }

    /**
     * Set a data placeholder key-value pair
     *
     * @param string $key
     * @param string $value
     * 
     * @return string
     */
    public function setData(string $key, string $value)
    {
      $this->_data[$key] = $value;
    }

    /**
     * Get a data placeholder value by key
     *
     * @param string $key
     * @return string
     */
    public function getData(string $key)
    {
      return $this->_data[$key];
    }

    /**
     * Remove a data placeholder value by key
     *
     * @param string $key
     * @return string
     */
    public function removeData(string $key)
    {
      unset($this->_data[$key]);
    }
  }
  
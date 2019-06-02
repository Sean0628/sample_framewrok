<?php
class DbManager
{
  protected $connections = array();
  protected $repository_connection_map = array();
  protected $repositories = array();

  public function connect($name, $params)
  {
    $params = array_merge(array(
      'dsn' => null,
      'user' => '',
      'password' => '',
      'options' => array(),
    ), $params);

    $con = new PDO(
      $params['dsn'],
      $params['user'],
      $params['password'],
      $params['options']
    );

    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $this->connections[$name] = $con;
  }

  public function getConnection($name = null)
  {
    if (is_null($name)) {
      return current($this->connections);
    }

    return $this->connection[$name];
  }

  public function setRepositoryConnectionMap($repository_name, $name)
  {
    $this->repository_connection_map[$repository_name] = $name;
  }

  public function getConnectionForRepository($repisitory_name)
  {
    if (isset($this->repository_connection_map[$repository_name])) {
      $name = $this->repository_connection_map[$repository_name];
      $con = $this->getConnection($name);
    } else {
      $con = $this->getConnection();
    }
    return $con;
  }

  public function __destruct()
  {
    foreach ($this->repositories as $repository) {
      unset($repository);
    }
    foreach ($this->connections as $con) {
      unset($con);
    }
  }
}

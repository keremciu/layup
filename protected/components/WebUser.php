<?php 
class WebUser extends CWebUser
{
    public function checkAccess($operation, $params=array())
    {
        if (empty($this->id)) {
            // Not identified => no rights
            return false;
        }
        $rol = $this->getState('role');
        if ($rol === 'admin') {
            return true; // admin role has access to everything
        }
        // allow access if the operation request is the current user's role
        return ($operation === $rol);
    }
}
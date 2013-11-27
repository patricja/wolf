<?php
/**
* Controller for the Admin Control Panel
*
* @package WolfCore
*/
class CCAdminControlPanel extends CObject implements IController {


  /**
* Constructor
*/
  public function __construct() {
    parent::__construct();
  }


  /**
* Show profile information of the user.
*/
  public function Index() {
    $this->views->SetTitle('Admin Control Panel')
                ->AddInclude(__DIR__ . '/index.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'],'user'=>$this->user), 'primary')
                ->AddInclude(__DIR__ . '/sidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'],'user'=>$this->user), 'sidebar');
  }
  
  
  /**
* View and edit user profile.
*/
    public function Users($id = null) {
          $users = new CMAdminControlPanel();
          if(isset($id)) {
    $allgroups = $users->ListAllGroups();        
    $memberships = $users->GetGroupMemberships($id);
    $form = new CFormAdminUserProfile($this, $users->GetUser($id), $allgroups, $memberships);
    $form->Check();

    $this->views->SetTitle('User Profile')
                ->AddInclude(__DIR__ . '/edituser.tpl.php', array(
                  'is_authenticated'=>$this->user['isAuthenticated'],
                  'user'=>$this->user,
                  'edituser' => $users->GetUser($id),
                  'profile_form'=>$form->GetHTML(),
                ))
                ->AddInclude(__DIR__ . '/sidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'],'user'=>$this->user), 'sidebar');
          } else {
    $this->views->SetTitle('User Profile')
                ->AddInclude(__DIR__ . '/user.tpl.php', array(
                  'is_authenticated'=>$this->user['isAuthenticated'],
                  'user'=>$this->user,
                  'allusers' => $users->ListAllUsers(),
                ))
                ->AddInclude(__DIR__ . '/sidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'],'user'=>$this->user), 'sidebar');
  }
}
  
  
  /**
* View and edit groups.
*/
  public function Groups($id = null) {
          $groups = new CMAdminControlPanel();
          if(isset($id)) {
    $form = new CFormGroupProfile($this, $groups->GetGroup($id));
    $form->Check();
    $this->views->SetTitle('Group Profile')
                ->AddInclude(__DIR__ . '/editgroup.tpl.php', array(
                  'is_authenticated'=>$this->user['isAuthenticated'],
                  'user'=>$this->user,
                  'editgroup' => $groups->GetGroup($id),
                  'group_form'=>$form->GetHTML(),
                ))
                ->AddInclude(__DIR__ . '/sidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'],'user'=>$this->user), 'sidebar');
          } else {
    $this->views->SetTitle('Group Profiles')
                ->AddInclude(__DIR__ . '/groups.tpl.php', array(
                  'is_authenticated'=>$this->user['isAuthenticated'],
                  'user'=>$this->user,
                  'allgroups' => $groups->ListAllGroups(),
                ))
                ->AddInclude(__DIR__ . '/sidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'],'user'=>$this->user), 'sidebar');
  }
  }
  
/**
* Create a new group.
*/
  public function CreateGroup() {
    $form = new CFormGroupCreate($this);
    if($form->Check() === false) {
      $this->AddMessage('notice', 'You must fill in all values.');
      $this->RedirectToController('CreateGroup');
    }
    $this->views->SetTitle('Create group')
                ->AddInclude(__DIR__ . '/creategroup.tpl.php', array('form' => $form->GetHTML()), 'primary')
                ->AddInclude(__DIR__ . '/sidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'],'user'=>$this->user), 'sidebar');
  }  
  
  
  /**
* View and edit content.
*/
  public function Content($id = null) {
    $contents = new CMContent($id);
    $groups = new CMAdminControlPanel();
    
    $this->views->SetTitle('Group Profiles')
                ->AddInclude(__DIR__ . '/content.tpl.php', array(
                  'is_authenticated'=>$this->user['isAuthenticated'],
                  'user'=>$this->user,
                  'allgroups' => $groups->ListAllGroups(),
                  'contents' => $contents->ListAll(),
                ))
                ->AddInclude(__DIR__ . '/sidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'],'user'=>$this->user), 'sidebar');
  }
  

  /**
* Change the password.
*/
  public function DoChangePassword($form) {
    if($form['password']['value'] != $form['password1']['value'] || empty($form['password']['value']) || empty($form['password1']['value'])) {
      $this->AddMessage('error', 'Password does not match or is empty.');
    } else {
      $this->edituser = new CMAdminControlPanel();
      $ret = $this->edituser->ChangePassword($form['password']['value'],$form['id']['value']);
      $this->AddMessage($ret, 'Saved new password.', 'Failed updating password.');
    }
    $this->RedirectToController('users/'.$form['id']['value']);
  }
  

  /**
* Save updates to profile information.
*/
  public function DoProfileSave($form) {
          $this->edituser = new CMAdminControlPanel();
    $ret = $this->edituser->Save($form['name']['value'], $form['email']['value'], $form['id']['value']);
    $this->AddMessage($ret, 'Saved profile.', 'Failed saving profile.');
    $this->RedirectToController('users/'.$form['id']['value']);
  }
  


  /**
* Save updates to group information.
*/
  public function DoGroupSave($form) {
          $this->editgroup = new CMAdminControlPanel();
    $ret = $this->editgroup->SaveGroup($form['username']['value'], $form['name']['value'], $form['id']['value']);
    $this->AddMessage($ret, 'Saved group.', 'Failed saving profile.');
    $this->RedirectToController('groups/'.$form['id']['value']);
  }
  

  /**
* Create a new user.
*/
  public function Create() {
    $form = new CFormUserCreate($this);
    if($form->Check() === false) {
      $this->AddMessage('notice', 'You must fill in all values.');
      $this->RedirectToController('Create');
    }
    $this->views->SetTitle('Create user')
                ->AddInclude(__DIR__ . '/create.tpl.php', array('form' => $form->GetHTML()), 'primary')
                ->AddInclude(__DIR__ . '/sidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'],'user'=>$this->user), 'sidebar');
  }
  

 /**
* Perform a creation of a user as callback on a submitted form.
*
* @param $form CForm the form that was submitted
*/
  public function DoCreate($form) {
    if($form['password']['value'] != $form['password1']['value'] || empty($form['password']['value']) || empty($form['password1']['value'])) {
      $this->AddMessage('error', 'Password does not match or is empty.');
      $this->RedirectToController('create');
    } else if($this->user->Create($form['acronym']['value'],
                           $form['password']['value'],
                           $form['name']['value'],
                           $form['email']['value']
                           )) {
      $this->AddMessage('success', "Your have successfully created a new account.");
      $this->RedirectToController('users');
    } else {
      $this->AddMessage('notice', "Failed to create an account.");
      $this->RedirectToController('create');
    }
  }


  /**
* Perform a creation of a group as callback on a submitted form.
*
* @param $form CForm the form that was submitted
*/
  public function DoCreateGroup($form) {
          $acp = new CMAdminControlPanel();
    if($acp->CreateGroup($form['acronym']['value'],
                                           $form['name']['value']
                                                                 )) {
      $this->AddMessage('success', "You have successfully created the group {$form['name']['value']}.");
      $this->RedirectToController('groups');
    } else {
      $this->AddMessage('notice', "Failed to create an account.");
      $this->RedirectToController('creategroup');
    }
  }

  /**
* Delete a group as callback on a submitted form.
*
* @param $form CForm the form that was submitted
*/
  public function DoDeleteGroup($form) {
	$acp = new CMAdminControlPanel();

    if($acp->DeleteGroup($form['id']['value'])) {
      $this->AddMessage('success', "You have successfully deleted the group");
      $this->RedirectToController('groups');
    } else {
      $this->AddMessage('notice', "Failed to delete group.");
      $this->RedirectToController('groups');
    }
  }
  
 /**
* Delete a user as callback on a submitted form.
*
* @param $form CForm the form that was submitted
*/
  public function DoDeleteUser($form) {
	  
	$acp = new CMAdminControlPanel();
    if($acp->DeleteUser($form['id']['value'])) {
      $this->AddMessage('success', "You have successfully deleted the user");
      $this->RedirectToController('users');
    } else {
      $this->AddMessage('notice', "Failed to delete user.");
      $this->RedirectToController('users');
    }
  }
  

}  

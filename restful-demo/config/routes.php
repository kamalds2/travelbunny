<?php 
  use Psr\Http\Message\ResponseInterface;
  use Psr\Http\Message\ServerRequestInterface;
  use Slim\App;
  define('SOURCEPATH', ''); 
  return function (App $app) {    
    //User Login

  $app->post(SOURCEPATH.'/users/checklogin',\App\Action\Users\CheckLogin::class);

  $app->get(SOURCEPATH.'/users/getusers',\App\Action\Users\GetUser::class);
  $app->get(SOURCEPATH.'/users/getuserdetails/{user_id}',\App\Action\Users\GetUserDetails::class);
  $app->post(SOURCEPATH.'/users/adduser', \App\Action\Users\AddUser::class);
  $app->post(SOURCEPATH.'/users/edituser', \App\Action\Users\EditUser::class);
  $app->post(SOURCEPATH.'/users/deleteuser',\App\Action\Users\DeleteUser::class);
  $app->post(SOURCEPATH.'/users/checkpassword',\App\Action\Users\CheckPassword::class);
  $app->post(SOURCEPATH.'/users/updateuserpassword', \App\Action\Users\UpdateUserPassword::class);
  $app->post(SOURCEPATH.'/users/checkuseremail',\App\Action\Users\CheckUserEmail::class);


  /* Roles*/

   $app->get(SOURCEPATH.'/roles/getroles',\App\Action\Roles\GetRoles::class);
  $app->post(SOURCEPATH.'/roles/addrole',\App\Action\Roles\AddRole::class);
  $app->post(SOURCEPATH.'/roles/editrole',\App\Action\Roles\EditRole::class);
  $app->delete(SOURCEPATH.'/roles/deleterole/{role_id}/{user_id}/{apiKey}',\App\Action\Roles\DeleteRole::class);
  $app->get(SOURCEPATH.'/roles/getmodules',\App\Action\Roles\GetModules::class);
  $app->get(SOURCEPATH.'/roles/getprivileges/{role_id}',\App\Action\Roles\GetPrivileges::class);
  $app->post(SOURCEPATH.'/roles/accesspages',\App\Action\Roles\AccessPages::class);



   
  };
?>
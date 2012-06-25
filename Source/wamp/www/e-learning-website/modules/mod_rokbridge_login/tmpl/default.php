<?php 
/**
 * @version	$Id: default.php 2047 2007-10-02 00:42:56Z rhuk $ 
 * @package RokBridge - phpBB3 edition
 * @copyright Copyright (C) 2009 RocketTheme. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @author RocketTheme, LLC
 */
defined('_JEXEC') or die('Restricted access');
?>
<div class="rokbridge_login">
<?php
$return = base64_encode(base64_decode($return).'#content');
if ($type == 'logout') : ?>
<form action="index.php" method="post" name="login" class="log">
  <?php if ($params->get('avatar')) : ?>
  <a href="<?php echo PHP_AVATAR_URL; ?>" title="change avatar"><span class="avatar"><?php echo $avatar; ?></span></a>
  <?php endif; ?>
  <?php if ($params->get('pretext')) : ?>
      <div class="pretext"><?php echo $params->get('pretext'); ?></div>
  <?php endif; ?>
  <?php if ($params->get('greeting')) : ?>
  <h4 class="welcome">
    <p>
      <?php if ($params->get('name')) : {
		echo JText::sprintf( 'HINAME', $user->get('name') );
	} else : {
		echo JText::sprintf( 'HINAME', $user->get('username') );
	} endif; ?>
    </p>
  </h4>
  <?php endif; ?>
  <div class="login-links">
    <?php if ($params->get('messages')) : ?>
    <p><a href="<?php echo PHP_PM_URL; ?>"><?php echo JText::_('MESSAGES'); ?>: <b>(<?php echo $pms; ?> <?php echo JText::_('UNREAD'); ?>)</b></a></p>
    <?php endif; ?>
    <?php if ($params->get('lastvisit')) : ?>
    <p><a href="<?php echo PHP_YOUR_ACTIVITY; ?>"><?php echo JText::_('YOUR_LAST_VISIT'); ?>: <b><?php echo $lastvisit; ?> </b></a></p>
    <?php endif; ?>
    <?php if ($params->get('unanswered')) : ?>
    <p><a href="<?php echo PHP_UNANSWERED_URL; ?>"><?php echo JText::_('VIEW_UNANSWERED'); ?></a></p>
    <?php endif; ?>
    <?php if ($params->get('new')) : ?>
    <p><a href="<?php echo PHP_NEW_URL; ?>"><?php echo JText::_('VIEW_NEW'); ?></a></p>
    <?php endif; ?>
    <?php if ($params->get('active')) : ?>
    <p><a href="<?php echo PHP_ACTIVE_URL; ?>"><?php echo JText::_('VIEW_ACTIVE'); ?></a></p>
    <?php endif; ?>
    <?php if ($params->get('yours')) : ?>
    <p><a href="<?php echo PHP_YOUR_URL; ?>"><?php echo JText::_('VIEW_YOUR'); ?></a></p>
    <?php endif; ?>
    <p id="form-login-submit">
      <input type="submit" name="Submit" class="button" value="<?php echo JText::_('BUTTON_LOGOUT'); ?>" title="<?php echo JText::_('BUTTON_LOGOUT'); ?>" />
    </p>
  </div>
  <input type="hidden" name="option" value="com_user" />
  <input type="hidden" name="task" value="logout" />
  <input type="hidden" name="return" value="<?php echo $return;?>" />
</form>
<?php else : ?>
<?php if(JPluginHelper::isEnabled('authentication', 'openid')) :
		$lang->load( 'plg_authentication_openid', JPATH_ADMINISTRATOR );
		$langScript = 	'var JLanguage = {};'.
						' JLanguage.WHAT_IS_OPENID = \''.JText::_( 'WHAT_IS_OPENID' ).'\';'.
						' JLanguage.LOGIN_WITH_OPENID = \''.JText::_( 'LOGIN_WITH_OPENID' ).'\';'.
						' JLanguage.NORMAL_LOGIN = \''.JText::_( 'NORMAL_LOGIN' ).'\';';
		$document = &JFactory::getDocument();
		$document->addScriptDeclaration( $langScript );
		JHTML::_('script', 'openid.js');		
endif; ?>
<div class="main-login-form">
  <form action="<?php echo JRoute::_( 'index.php', true, $params->get('usesecure')); ?>" method="post" name="login" id="form-login" >
    <?php echo $params->get('pretext'); ?>
    <h4><?php echo JText::_('MEMBER_LOGIN'); ?></h4>
    <div class="login-username">
      <label for="mod_login_username"><?php echo JText::_('USERNAME') ?></label>
      <br />
      <input name="username" id="mod_login_username" type="text" class="inputbox png" value="<?php echo JText::_('USERNAME'); ?>" alt="<?php echo JText::_('USERNAME'); ?>" onblur="if(this.value=='') this.value='<?php echo JText::_('USERNAME'); ?>';" onfocus="if(this.value=='<?php echo JText::_('USERNAME'); ?>') this.value='';" size="26" />
    </div>
    <div class="login-password">
      <label for="mod_login_password"><?php echo JText::_('PASSWORD') ?></label>
      <br />
      <input name="passwd" id="mod_login_password" type="password" class="inputbox png" value="<?php echo JText::_('PASSWORD'); ?>" alt="<?php echo JText::_('PASSWORD'); ?>" onblur="if(this.value=='') this.value='<?php echo JText::_('PASSWORD'); ?>';" onfocus="if(this.value=='<?php echo JText::_('PASSWORD'); ?>') this.value='';" size="26" />
    </div>
    <br/>
    <?php if(JPluginHelper::isEnabled('system', 'remember') && !$params->get('autoremember')) : ?>
    <div class="remember-me">
      <label for="mod_login_remember" class="remember"><?php echo JText::_('REMEMBER ME') ?></label>
      <input type="checkbox" name="remember" id="mod_login_remember" class="checkbox" value="yes" alt="Remember Me" />
    </div>
    <?php endif; ?>
    <input type="submit" name="Submit" class="button" value="<?php echo JText::_('BUTTON_LOGIN'); ?>" />
    <div class="login-links">
      <p><a href="<?php echo JRoute::_('index.php?option=com_user&view=reset#content'); ?>"> <?php echo JText::_('FORGOT_YOUR_PASSWORD'); ?></a></p>
      <p><a href="<?php echo JRoute::_('index.php?option=com_user&view=remind#content'); ?>"> <?php echo JText::_('FORGOT_YOUR_USERNAME'); ?></a></p>
    </div>
    <?php
		$usersConfig = &JComponentHelper::getParams( 'com_users' );
		if ($usersConfig->get('allowUserRegistration')) : ?>
    <p> <?php echo JText::_('NO ACCOUNT YET?'); ?> <a href="<?php echo JRoute::_('index.php?option=com_user&task=register#content'); ?>"> <?php echo JText::_('REGISTER'); ?></a> </p>
    <?php endif;
		echo $params->get('posttext'); ?>
    <?php if(JPluginHelper::isEnabled('system', 'remember') && $params->get('autoremember')) : ?>
    <input type="hidden" name="remember" value="yes" />
    <?php endif; ?>
    <input type="hidden" name="option" value="com_user" />
    <input type="hidden" name="task" value="login" />
    <input type="hidden" name="return" value="<?php echo $return; ?>" />
    <?php echo JHTML::_( 'form.token' ); ?>
  </form>
</div>
<?php endif; ?>
</div>
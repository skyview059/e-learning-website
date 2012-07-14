<?php
 
// No direct access
 
defined('_JEXEC') or die('Restricted access'); ?>

<form id="form2" name="form2" method="post" action="http://localhost/e-learning-website/index.php?option=com_dientich&view=Dientich&Itemid=19">
  <table width="380" border="0" align="center" cellpadding="2" cellspacing="2" bordercolor="#FFebca" bgcolor="#ffebca">
    <tr bgcolor="#FFCC00">
      <td colspan="2" bgcolor="#FFCC66"><div align="center" class="style8 style9">Diện tích hình chữ nhật </div></td>
    </tr>
    <tr>
      <td width="119">Chiều dài : </td>
      <td width="261"><label>
        <input name="dai" type="text" id="dai" value="<?php echo $this->dai; ?>" size="40" />
      </label></td>
    </tr>
    <tr>
      <td>Chiều Rộng : </td>
      <td><input name="rong" type="text" id="rong" value="<?php echo $this->rong; ?>" size="40" /></td>
    </tr>
    <tr>
      <td>Diện tích : </td>
      <td><input name="dien_tich" type="text" id="dien_tich" style="background-color:#FFCCCC" value="<?php echo $this->dientich; ?>" size="40" readonly="true"/></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle"><div align="center">
          <label>
			<input type="submit" name="Submit" value="Tính" />
          </label>
      </div></td>
    </tr>
  </table>
</form>
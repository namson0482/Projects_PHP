<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<h4>Install a impress-cart extension in .zip format</h4>
<div><?php echo $message; ?></div>
<p class="install-help">If you have a plug-in in a .zip format, you may install it by uploading it here.</p>
<form action="" enctype="multipart/form-data" method="post">
    <select name="type">        
        <option value="payment">Payment Extension</option>
        <option value="shipping">Shipping Extension</option>
        <option value="total">Total Extension</option>
    </select>
    <label for="pluginzip" class="screen-reader-text">Plugin zip file</label>
    <input type="file" name="pluginzip" id="pluginzip">
    <input type="submit" value="Install Now" class="button">    
</form>
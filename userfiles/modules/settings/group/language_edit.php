

  <div class="send-your-lang">

  <label class="mw-ui-label"><small>Help us to improove Microweber</small></label>
  <a onclick="send_lang_form_to_microweber()" class="mw-ui-btn mw-ui-btn-blue">Send us your translation</a>

  </div>



<?php only_admin_access(); ?>
<label class="mw-ui-label left">
    <?php _e("Edit your language file"); ?>
</label>





<div class="mw_clear"></div>
<div class="vSpace"></div>



<script  type="text/javascript">
    mw.require('forms.js', true);
</script>

<script type="text/javascript">




 function send_lang_form_to_microweber(){


 mw.form.post('#language-form-<?php print $params['id'] ?>', '<?php print site_url('api/send_lang_form_to_microweber'); ?>',
      function(msg) {
mw.notification.msg(this);

      });
            return false;

 }



 function save_lang_form(){


 mw.form.post('#language-form-<?php print $params['id'] ?>', '<?php print site_url('api/save_language_file_content'); ?>',
			function(msg) {
mw.notification.msg(this);

			});
            return false;

 }


</script>

<style>
    .send-your-lang{
      float: right;
      width: 190px;
      text-align: center;
      margin-top: -77px;
    }
    .send-your-lang label{
      text-align: center;
    }

    .send-your-lang a{
      width: 165px;
      margin: auto
    }

    .mw-ui-admin-table .mw-ui-field{
        background-color: transparent;
        border-color: transparent;
        width: 300px;
        height: 17px;
        resize: none;
    }
    .mw-ui-admin-table .mw-ui-field:hover, .mw-ui-admin-table .mw-ui-field:focus{
        background-color: white;
        border-color:#C6C6C6 #E6E6E6 #E6E6E6;
        resize: vertical;
    }

</style>

<?php


$cont  = get_language_file_content();





 ?>
<?php if(!empty($cont)): ?>
<form id="language-form-<?php print $params['id'] ?>">
<input name="unicode_temp_remove" type="hidden" value="☃"  />
<table width="100%" border="0" class="mw-ui-admin-table" cellspacing="0" cellpadding="0">
<thead>
  <tr>
    <th scope="col">Key</th>
    <th scope="col">Value</th>

  </tr>
  </thead>
  <tbody>
  <?php foreach($cont as $k => $item): ?>
  <tr>
    <td><? print $k ?></td>
    <td>
    <textarea name="<? print $k ?>" class="mw-ui-field" type="text" onchange="save_lang_form()" wrap="soft"><? print $item ?></textarea>

<?php /*    <input name="<? print $k ?>" class="mw-ui-field" value="<? print $item ?>" style="width: 400px;" type="text" onchange="save_lang_form()" /></td> */ ?>

  </tr>
  </tbody>
  <? endforeach; ?>
</table>
</form>
<? endif; ?>




  <div class="send-your-lang" style="margin: 40px 0;">

  <label class="mw-ui-label"><small>Help us to improove Microweber</small></label>
  <a onclick="send_lang_form_to_microweber()" class="mw-ui-btn mw-ui-btn-blue">Send us your translation</a>

  </div>

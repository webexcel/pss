<fieldset>
    <div class="form-group">
        <label for="title">Title *</label>
          <input type="text" name="title" value="<?php echo htmlspecialchars($edit ? $contents['title'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Title" class="form-control" required="required" id = "title" >
    </div> 
    <div class="bootstrap-switch-square">
      <input class="form-check-input" name="page_1" data-toggle="switch" type="checkbox" id="flexSwitchCheckDefault1" value="<?php if($edit && $contents['page_1']){ echo $contents['page_1'];}else{ echo '0';} ?>" <?php if($edit){ if ($contents['page_1']==1) {echo "checked";}}?>>
      <label class="form-check-label"  for="flexSwitchCheckDefault1">Page 1</label>
    </div>
    <div class="bootstrap-switch-square">
      <input class="form-check-input" name="page_2" data-toggle="switch" type="checkbox" id="flexSwitchCheckDefault2" value="<?php if($edit && $contents['page_2']){ echo $contents['page_2'];}else{ echo '0';} ?>" <?php if($edit){ if ($contents['page_2']==1) {echo "checked";}}?>>
      <label class="form-check-label"  for="flexSwitchCheckDefault2">Page 2</label>
    </div>
    <div class="bootstrap-switch-square">
      <input class="form-check-input" name="page_3" type="checkbox" data-toggle="switch" id="flexSwitchCheckDefault3" value="<?php if($edit && $contents['page_3']){ echo $contents['page_3'];}else{ echo '0';} ?>" <?php if($edit){ if ($contents['page_3']==1) {echo "checked";}}?>>
      <label class="form-check-label"  for="flexSwitchCheckDefault3">Page 3</label>
    </div>
    <div class="bootstrap-switch-square">
      <input class="form-check-input" name="page_4" type="checkbox" data-toggle="switch" id="flexSwitchCheckDefault4" value="<?php if($edit && $contents['page_4']){ echo $contents['page_4'];}else{ echo '0';} ?>" <?php if($edit){ if ($contents['page_4']==1) {echo "checked";}}?>>
      <label class="form-check-label"  for="flexSwitchCheckDefault4">Page 4</label>
    </div>
    <div class="bootstrap-switch-square">
      <input class="form-check-input" name="page_5" type="checkbox" data-toggle="switch" id="flexSwitchCheckDefault5" value="<?php if($edit && $contents['page_5']){ echo $contents['page_5'];}else{ echo '0';} ?>" <?php if($edit){ if ($contents['page_5']==1) {echo "checked";}}?>>
      <label class="form-check-label"  for="flexSwitchCheckDefault5">Page 5</label>
    </div>
    <div class="bootstrap-switch-square">
      <input class="form-check-input" name="page_6" type="checkbox" data-toggle="switch" id="flexSwitchCheckDefault6" value="<?php if($edit && $contents['page_6']){ echo $contents['page_6'];}else{ echo '0';} ?>" <?php if($edit){ if ($contents['page_6']==1) {echo "checked";}}?>>
      <label class="form-check-label"  for="flexSwitchCheckDefault6">Page 6</label>
    </div>
    <div class="form-group">
        <label for="l_name">description *</label>
        <textarea name="description" id="editor" required="required"><?php echo htmlspecialchars($edit ? $contents['description'] : '', ENT_QUOTES, 'UTF-8'); ?></textarea>
    </div>
    
    <div class="form-group text-center">
        <label></label>
        <button type="submit" class="btn btn-warning" >Save <span class="glyphicon glyphicon-send"></span></button>
    </div>     
   
</fieldset>

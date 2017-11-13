<div class="multilangs">
<?php foreach($langs as $key => $value):?>
<a href="#" class="multilanguage-set" data-language="<?=$value['lang_id'];?>"><?=$value['lang_symbols'];?></a>
<?php endforeach;?>
</div>
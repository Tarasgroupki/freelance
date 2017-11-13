<?php
use yii\helpers\Url;?>
<li>
                <div class="navbar-form navbar-right">
                <button class="btn btn-sm btn-default"
                        data-container="body"
                        data-toggle="popover"
                        data-trigger="focus"
                        data-placement="bottom"
                        data-title='<?=Yii::$app->user->identity['username']?>'
                        data-content="
                            <a href='<?=Url::to(['/site/profile'])?>' >Мой профиль</a><br>
                            <a href='<?=Url::to(['/site/logout'])?>' data-method=post>Выход</a>
                        ">
						<?if(!isset($profile)):?>
                    <span class="glyphicon glyphicon-user"></span>
                <?else:?>
				<img style="width:20px; height:20px;" src="<?=$profile['avatar'];?>">
				<?endif;?>
				</button>
            </div></li>
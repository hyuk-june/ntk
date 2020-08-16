<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;
?>
            </div>
            <aside class="col-lg-3 d-none d-lg-block">
                <!-- 페이지 공용 (두번째 인자에 $pg_id 를 삽입하면 개별로 세팅 가능합니다) -->
                <?php btb\show_widgets(__FILE__, "", "side");?>
            </aside>
        </div>
    </div>
    <div class="visual-bot"><?php btb\show_widgets(__FILE__, $pg_id, "visual_bot")?></div>
</div>

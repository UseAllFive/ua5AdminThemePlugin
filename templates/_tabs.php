<ul id="hd-nav">
  <li class="tab"><a <?php if ($active == 'pending') {echo "class='active'";}?> href="<?php echo url_for("pending/index")?>">Requests</a></li>
  <li class="tab"><a <?php if ($active == 'media') {echo "class='active'";}?> href="<?php echo url_for("project/index")?>">Media</a></li>
  <li class="tab"><a <?php if ($active == 'user') {echo "class='active'";}?> href="<?php echo url_for("user/index")?>">Press Users</a></li>
  <li class="tab"><a <?php if ($active == 'credit') {echo "class='active'";}?> href="<?php echo url_for("credit/index")?>">Credits</a></li>
</ul> 
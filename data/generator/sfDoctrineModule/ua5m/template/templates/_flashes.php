[?php if ($sf_user->hasFlash('notice')): ?]
  <div class="notice">[?php echo __($sf_user->getFlash('notice'), array(), 'ua5_admin') ?]</div>
[?php endif; ?]

[?php if ($sf_user->hasFlash('error')): ?]
  <div class="error">[?php echo __($sf_user->getFlash('error'), array(), 'ua5_admin') ?]</div>
[?php endif; ?]
